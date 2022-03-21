<?php

namespace core\controllers\admin;

use core\helpers\Functions;
use core\services\AdminService;
use core\services\HousingService;
use core\services\PropertyService;

class PropertyController {

    private $loggedAdmin;
    private $permission;

    public function __construct() {
        $this->loggedAdmin = AdminService::checkAdminLogin();
        if($this->loggedAdmin === false) {
            Functions::Redirect("signin", true);
        } else {
            $this->permission = Functions::verifyPermission($this->loggedAdmin->adminField);
        }
    }

    public function property() {

        if(isset($_GET["page"]) && !empty($_GET["page"])) {
            $page = intval(filter_input(INPUT_GET, 'page'));
        } else {
            $page = 1;
        }

        $flash = "";
        $success = "";

        if(!empty($_SESSION["flash"])) {
            $flash = $_SESSION["flash"];
            unset($_SESSION["flash"]);
        }

        if(!empty($_SESSION["success"])) {
            $success = $_SESSION["success"];
            unset($_SESSION["success"]);
        }

        $data = [
            "activeMenu" => "property",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,

            "flash" => $flash,
            "success" => $success,

            "properties" => PropertyService::getListProperties($page),
            "propertiesPage" => true,
            "search" => false
        ];

        // Apresentar a view do admin
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/property/index",
            "partials/footer",
        ], $data);

    }

    public function newProperty() {

        $flash = "";
        $success = "";

        if(!empty($_SESSION["flash"])) {
            $flash = $_SESSION["flash"];
            unset($_SESSION["flash"]);
        }

        if(!empty($_SESSION["success"])) {
            $success = $_SESSION["success"];
            unset($_SESSION["success"]);
        }

        $data = [
            "activeMenu" => "property",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,

            "flash" => $flash,
            "success" => $success
        ];

        // Apresentar a view das propriedades
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/property/new",
            "partials/footer",
        ], $data);

    }

    public function submitProperty() {

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido";
            Functions::Redirect("newProperty", true);
            exit;
        }

        foreach($_POST as $key => $value ) {
            // Remove todas as tags HTML
            // Remove os espaços em branco do valor
            $key = trim( strip_tags($value) );
        
            // Verifica se tem algum valor em branco
            if(empty($value)) {
                $_SESSION["flash"] = "Todos os campos precisam estar preenchidos!";
                Functions::Redirect("newProperty", true);
                exit;
            }
        }

        if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

            $image = $_FILES["image"];
            if(in_array($image["type"], ["image/jpeg", "image/jpg", "image/png"])) {

                $folder = "../../public/assets/images/properties";
                $imageName = Functions::cutImage($image, 1280, 720, $folder);

            } else {
                $_SESSION["flash"] = "Imagem inválida!";
                Functions::Redirect("newProperty", true);
                exit;
            }

        } else {
            $imageName = "default.jpg";
        }

        $fields = [
            "name" => filter_input(INPUT_POST, "name"),
            "type" => filter_input(INPUT_POST, "type"),
            "price" => filter_input(INPUT_POST, "price"),
            "image" => $imageName
        ];

        // Adicionar ao banco de dados
        PropertyService::addPropertyInDatabase($fields);

        $_SESSION["success"] = "Propriedade adicionada com sucesso!";
        Functions::Redirect("newProperty", true);
        exit;

    }

    public function editProperty() {

        $flash = "";
        $success = "";

        if(!empty($_SESSION["flash"])) {
            $flash = $_SESSION["flash"];
            unset($_SESSION["flash"]);
        }

        if(!empty($_SESSION["success"])) {
            $success = $_SESSION["success"];
            unset($_SESSION["success"]);
        }

        if(!isset($_GET["id"]) || empty($_GET["id"])) {
            $_SESSION["flash"] = "Id não enviado!";
            Functions::Redirect("property", true);
            exit;
        }

        if(strlen($_GET["id"]) != 32) {
            $_SESSION["flash"] = "Id não encriptado!";
            Functions::Redirect("property", true);
            exit;
        }

        $id = Functions::aesDescrypt($_GET["id"]);
        if(empty($id)) {
            $_SESSION["flash"] = "Id vazio ou não permitido!";
            Functions::Redirect("property", true);
            exit;
        }

        // Verificar no banco de dados se existe o produto
        $propertyExists = PropertyService::verifyIfPropertyExistsInDatabase($id);
        if(!$propertyExists) {
            $_SESSION["flash"] = "Produto não existe!";
            Functions::Redirect("property", true);
            exit;
        }

        $housingsFromProperty = HousingService::getHousingsFromPropertyId($propertyExists->id);

        $data = [
            "activeMenu" => "property",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,

            "flash" => $flash,
            "success" => $success,
            
            "property" => $propertyExists,
            "housings" => $housingsFromProperty
        ];

        // Apresentar a view de adicionar produto
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/property/edit",
            "partials/footer",
        ], $data);

    }

    public function editSubmit() {

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido";
            Functions::Redirect("property", true);
            exit;
        }

        foreach($_POST as $key => $value ) {
            // Remove todas as tags HTML
            // Remove os espaços em branco do valor
            $key = trim( strip_tags($value) );
        
            // Verifica se tem algum valor em branco
            if(empty($value)) {
                $_SESSION["flash"] = "Todos os campos precisam estar preenchidos!";
                Functions::Redirect("property", true);
                exit;
            }
        }

        if(strlen($_POST["id"]) != 32) {
            $_SESSION["flash"] = "Id não encriptado!";
            Functions::Redirect("property", true);
            exit;
        }

        $id = Functions::aesDescrypt($_POST["id"]);
        if(empty($id)) {
            $_SESSION["flash"] = "Id vazio ou não permitido!";
            Functions::Redirect("property", true);
            exit;
        }

        // Verificar no banco de dados se existe o produto
        $propertyExists = PropertyService::verifyIfPropertyExistsInDatabase($id);
        if(!$propertyExists) {
            $_SESSION["flash"] = "Propriedade não existe!";
            Functions::Redirect("property", true);
            exit;
        }

        if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

            $image = $_FILES["image"];
            if(in_array($image["type"], ["image/jpeg", "image/jpg", "image/png"])) {

                $folder = "../../public/assets/images/properties";
                $imageName = Functions::cutImage($image, 1280, 720, $folder);
                
                if($_POST["oldImage"] !== "default.jpg") {
                    $fileRemove = $folder = "../../public/assets/images/properties/".$_POST["oldImage"];
                    if(file_exists($fileRemove)) {
                        unlink($fileRemove);
                    }
                }

            } else {
                $_SESSION["flash"] = "Imagem inválida!";
                Functions::Redirect("property", true);
                exit;
            }

        } else {
            $imageName = $_POST["oldImage"];
        }

        $fields = [
            "id" => $id,
            "name" => filter_input(INPUT_POST, "name"),
            "type" => filter_input(INPUT_POST, "type"),
            "price" => filter_input(INPUT_POST, "price"),
            "image" => $imageName
        ];

        // Adicionar ao banco de dados
        PropertyService::updatePropertyInDatabase($fields);

        $_SESSION["success"] = "Propriedade editada com sucesso!";
        Functions::Redirect("editProperty?id=".$_POST["id"], true);
        exit;

    }

    public function searchProperty() {

        if(empty($_GET["search"])) {
            $_SESSION["flash"] = "Digite um termo para buscar!";
            Functions::Redirect("property", true);
            exit;
        }

        if(isset($_GET["page"]) && !empty($_GET["page"])) {
            $page = intval(filter_input(INPUT_GET, 'page'));
        } else {
            $page = 1;
        }

        $search = filter_input(INPUT_GET, "search");

        $data = [
            "activeMenu" => "property",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,

            "properties" => PropertyService::searchPropertiesInDatabase($search, $page),
            "propertiesPage" => false,
            "searchTerm" => $search,
            "search" => true
        ];

        // Apresentar a view das propriedades
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/property/index",
            "partials/footer",
        ], $data);

    }

    public function delete() {

        $id = filter_input(INPUT_GET, "id");

        if(empty($id)) {
            $_SESSION["flash"] = "Id não enviado!";
            Functions::Redirect("property", true);
            exit;
        }

        if(strlen($id) != 32) {
            $_SESSION["flash"] = "Id não encriptado!";
            Functions::Redirect("property", true);
            exit;
        }

        $propertyId = Functions::aesDescrypt($id);
        if(empty($propertyId)) {
            $_SESSION["flash"] = "Ocorreu um erro com o id!";
            Functions::Redirect("property", true);
            exit;
        }

        $propertyItem = PropertyService::verifyIfPropertyExistsInDatabase($propertyId);
        if(!$propertyItem) {
            $_SESSION["flash"] = "Nada para deletar!";
            Functions::Redirect("property", true);
            exit;
        }

        // Pegar lista de imóveis da propriedade
        $housingList = HousingService::getHousingsByIdProperty($propertyItem->id);
        
        // echo "<pre>";
        // print_r($housingList);
        // exit;

        if(count($housingList) > 0) {
            HousingService::deleteHousing($housingList["housing"]->id);

            if(count($housingList["images"]) > 0) {
                foreach($housingList["images"] as $item) {

                    $folder = "../../public/assets/images/housings/".$item->image;
                    if(file_exists($folder)) {
                        if($item->image !== "default.jpg") {
                            unlink($folder);
                        }
                    }
                    
                    HousingService::deleteSingleImageByIdAndImage($item->image, $item->id);
                }
            }
        }

        // Deletar imagem da propriedade
        $folderProperty = "../../public/assets/images/properties/";
        if($propertyItem->image !== "default.jpg") {
            if(file_exists($folderProperty.$propertyItem->image)) {
                unlink($folderProperty.$propertyItem->image);
            }
        }

        PropertyService::deleteProperty($propertyItem->id);
        
        $_SESSION["success"] = "Produto deletado com sucesso!";
        Functions::Redirect("property", true);
        exit;

    }

}
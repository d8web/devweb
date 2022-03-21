<?php

namespace core\controllers\admin;

use core\helpers\Functions;
use core\services\AdminService;
use core\services\HousingService;
use core\services\PropertyService;

class HousingController {

    private $loggedAdmin;
    private $permission;

    public function __construct() {
        $this->loggedAdmin = AdminService::checkAdminLogin();
        if($this->loggedAdmin === false) {
            Functions::Redirect("signin", true);
            exit;
        } else {
            $this->permission = Functions::verifyPermission($this->loggedAdmin->adminField);
        }
    }

    public function show() {

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

        $housingExists = HousingService::verifyIfHousingExistsInDatabase($id);
        if(!$housingExists) {
            $_SESSION["flash"] = "Imóvel não encontrado!";
            Functions::Redirect("property", true);
            exit;
        }

        $data = [
            "activeMenu" => "property",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,

            "flash" => $flash,
            "success" => $success,

            "list" => $housingExists
        ];

        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/housing/show",
            "partials/footer",
        ], $data);        
        
    }

    public function newHousingSubmit() {

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido!";
            Functions::Redirect("property", true);
            exit;
        }

        foreach($_POST as $key => $value ) {
            // Remove todas as tags HTML
            // Remove os espaços em branco do valor
            $key = trim( strip_tags($value) );
        
            // Verifica se tem algum valor em branco
            if(empty($value)) {
                $_SESSION["flash"] = "Todos os campos do formulário dos imóveis precisam estar preenchidos!";
                Functions::Redirect("property", true);
                exit;
            }
        }

        $idProperty = filter_input(INPUT_POST, "idProperty");
        if(strlen($idProperty) != 32) {
            $_SESSION["flash"] = "Id precisa ter 32 caracteres!";
            Functions::Redirect("property", true);
            exit;
        }

        $idPropertyDescript = Functions::aesDescrypt($idProperty);
        if(empty($idPropertyDescript)) {
            $_SESSION["flash"] = "Id vazio ou não permitido!";
            Functions::Redirect("property", true);
            exit;
        }

        // Verificar se a propriedade existe
        $propertyExists = PropertyService::verifyIfPropertyExistsInDatabase($idPropertyDescript);
        if(!$propertyExists) {
            $_SESSION["flash"] = "Propriedade não existe!";
            Functions::Redirect("editProperty?id=".$idProperty, true);
            exit;
        }

        // Preparando campos para adicionar ao banco de dados
        $fields = [
            "idProperty" => $idPropertyDescript,
            "name" => filter_input(INPUT_POST, "name"),
            "price" => filter_input(INPUT_POST, "price"),
            "area" => filter_input(INPUT_POST, "area")
        ];

        $images = [];
        if(isset($_FILES["imovel_image"])) {
            
            foreach($_FILES["imovel_image"]["name"] as $key => $val) {
                if(in_array($_FILES["imovel_image"]["type"][$key], ["image/jpg", "image/jpeg", "image/png"])) {

                    $images[] = [
                        "name" => $_FILES["imovel_image"]["name"][$key],
                        "full_path" => $_FILES["imovel_image"]["full_path"][$key],
                        "type" => $_FILES["imovel_image"]["type"][$key],
                        "tmp_name" => $_FILES["imovel_image"]["tmp_name"][$key],
                        "error" => $_FILES["imovel_image"]["error"][$key],
                        "size" => $_FILES["imovel_image"]["size"][$key]
                    ];

                } else {
                    $_SESSION["flash"] = "Formato da imagem não é válido!";
                    Functions::Redirect("editProperty?id=".$idProperty, true);
                    exit;
                }
            }

            $names = [];
            foreach($images as $item) {
                $folder = "../../public/assets/images/housings";
                $names[] = Functions::cutImage($item, 1280, 720, $folder);
            }

        }

        $housingId = HousingService::addHousingInDatabase($fields);
        
        foreach($names as $image) {
            // Inserir imagens no banco de dados
            HousingService::addImagesFromHousing($housingId, $image);
        }

        // Produto e imagens adicionados!
        $_SESSION["success"] = "Imóvel adicionado com sucesso junto com as imagens na propriedade!";
        Functions::Redirect("editProperty?id=".$idProperty, true);
        exit;

    }

    public function updateHousingSubmit() {

        $idProperty = filter_input(INPUT_POST, "propertyId");
        if(empty($idProperty)) {
            $_SESSION["flash"] = "Id da propriedade está vazio!";
            Functions::Redirect("property", true);
            exit;
        }

        if(strlen($idProperty) != 32) {
            $_SESSION["flash"] = "Id da propriedade precisa ter 32 caracteres!";
            Functions::Redirect("property", true);
            exit;
        }

        $propertyId = Functions::aesDescrypt($idProperty);
        if(empty($propertyId)) {
            $_SESSION["flash"] = "Id da propriedade está vazio!";
            Functions::Redirect("property", true);
            exit;
        }

        // Verificação do id do imóvel
        $idHousing = filter_input(INPUT_POST, "id");
        if(empty($idHousing)) {
            $_SESSION["flash"] = "Id do imóvel não enviado!";
            Functions::Redirect("editProperty?id=".$idProperty, true);
            exit;
        }

        if(strlen($idHousing) != 32) {
            $_SESSION["flash"] = "Id do imóvel precisa ter 32 caracteres!";
            Functions::Redirect("editProperty?id=".$idProperty, true);
            exit;
        }

        $id = Functions::aesDescrypt($idHousing);
        if(empty($id)) {
            $_SESSION["flash"] = "Id do imóvel está vazio!";
            Functions::Redirect("editProperty?id=".$idProperty, true);
            exit;
        }
        
        if(empty(trim($_POST["name"])) || empty(trim($_POST["area"])) || empty(trim($_POST["price"]))) {
            $_SESSION["flash"] = "Todos os campos precisam ser preenchidos!";
            Functions::Redirect("showHousing?id=".$idHousing, true);
            exit;
        }

        $fields = [
            "id"         => $id,
            "propertyId" => $propertyId,
            "name"       => filter_input(INPUT_POST, "name"),
            "area"       => filter_input(INPUT_POST, "area"),
            "price"      => filter_input(INPUT_POST, "price")
        ];

        // Atualizar no banco de dados
        HousingService::updateSingleHousing($fields);
        
        $_SESSION["success"] = "Imóvel atualizado com sucesso!";
        Functions::Redirect("showHousing?id=".$idHousing, true);
        exit;

    }

    public function newImagesHousing() {

        $housingId = filter_input(INPUT_POST, "housingId");
        if(empty($housingId)) {
            $_SESSION["flash"] = "Envie o id do produto!";
            Functions::Redirect("property", true);
            exit;
        }

        if(strlen($housingId) != 32) {
            $_SESSION["flash"] = "O id precisa ter 32 caracteres!";
            Functions::Redirect("property", true);
            exit;
        }

        $id = Functions::aesDescrypt($housingId);
        if(empty($id)) {
            $_SESSION["flash"] = "Ocorreu um erro com o id!";
            Functions::Redirect("property", true);
            exit;
        }

        $images = [];
        if(isset($_FILES["image"])) {
            
            foreach($_FILES["image"]["name"] as $key => $val) {
                if(in_array($_FILES["image"]["type"][$key], ["image/jpg", "image/jpeg", "image/png"])) {

                    $images[] = [
                        "name" => $_FILES["image"]["name"][$key],
                        "full_path" => $_FILES["image"]["full_path"][$key],
                        "type" => $_FILES["image"]["type"][$key],
                        "tmp_name" => $_FILES["image"]["tmp_name"][$key],
                        "error" => $_FILES["image"]["error"][$key],
                        "size" => $_FILES["image"]["size"][$key]
                    ];

                } else {
                    $_SESSION["flash"] = "Formato da imagem não é válido!";
                    Functions::Redirect("property", true);
                    exit;
                }
            }

            $names = [];
            foreach($images as $item) {
                $folder = "../../public/assets/images/housings";
                $names[] = Functions::cutImage($item, 1280, 720, $folder);
            }

        }

        foreach($names as $image) {
            // Inserir imagens no banco de dados
            HousingService::addImageHousing($id, $image);
        }

        $_SESSION["success"] = "Imagem adicionada com sucesso!";
        Functions::Redirect("showHousing?id=".$housingId, true);
        exit;

    }

    public function delSingleImageHousing() {

        if(empty($_GET["id"])) {
            $_SESSION["flash"] = "ID não enviado!";
            Functions::Redirect("property", true);
            exit;
        }

        if(strlen($_GET["id"]) != 32) {
            $_SESSION["flash"] = "Ocorreu um erro com o ID!";
            Functions::Redirect("property", true);
            exit;
        }

        $id = Functions::aesDescrypt(filter_input(INPUT_GET, "id"));
        if(empty($id)) {
            $_SESSION["flash"] = "ID está vazio!";
            Functions::Redirect("property", true);
            exit;
        }

        $image = filter_input(INPUT_GET, "image");
        if(empty($image)) {
            $_SESSION["flash"] = "Imagem não enviada!";
            Functions::Redirect("showHousing?id=".$_GET["id"], true);
            exit;
        }

        $folder = "../../public/assets/images/housings/".$image;
        if(file_exists($folder)) {

            HousingService::deleteSingleImage($image, $id);
            unlink($folder);

            $_SESSION["success"] = "Imagem deletada com sucesso!!";
            Functions::Redirect("showHousing?id=".$_GET["id"], true);
            exit;

        }

        $_SESSION["flash"] = "Imagem não existe!";
        Functions::Redirect("showHousing?id=".$_GET["id"], true);
        exit;

    }

    public function deleteHousing() {

        if(empty($_GET["id"])) {
            $_SESSION["flash"] = "ID não enviado!";
            Functions::Redirect("property", true);
            exit;
        }

        if(strlen($_GET["id"]) != 32) {
            $_SESSION["flash"] = "Ocorreu um erro com o ID!";
            Functions::Redirect("property", true);
            exit;
        }

        $id = Functions::aesDescrypt(filter_input(INPUT_GET, "id"));
        if(empty($id)) {
            $_SESSION["flash"] = "ID está vazio!";
            Functions::Redirect("property", true);
            exit;
        }

        // Verificar se a propriedade está vazia
        if(empty($_GET["property"])) {
            $_SESSION["flash"] = "ID da propriedade está vazio!";
            Functions::Redirect("property", true);
            exit;
        }

        if(strlen($_GET["property"]) != 32) {
            $_SESSION["flash"] = "Ocorreu um erro com o ID da propriedade!";
            Functions::Redirect("property", true);
            exit;
        }

        $idProperty = Functions::aesDescrypt(filter_input(INPUT_GET, "property"));
        if(empty($idProperty)) {
            $_SESSION["flash"] = "ID da propriedade está vazio!";
            Functions::Redirect("property", true);
            exit;
        }

        // Verificar se a propriedade existe no banco de dados
        $housingExists = HousingService::verifyIfHousingExistsInDatabase($id);
        if(!$housingExists) {
            $_SESSION["flash"] = "Imóvel não existe!";
            Functions::Redirect("property", true);
            exit;
        }

        // Excluir propriedade junto com as imagens da pasta e no banco de dados
        HousingService::deleteHousing($housingExists["housing"]->id);
        foreach($housingExists["images"] as $item) {

            $folder = "../../public/assets/images/housings/".$item->image;
            if(file_exists($folder)) {
                if($item->image !== "default.jpg") {
                    unlink($folder);
                }

                HousingService::deleteSingleImageByIdAndImage($item->image, $item->id);
            }

        }

        $_SESSION["success"] = "Imóvel deletado com sucesso junto com as imagens!";
        Functions::Redirect("editProperty?id=".$_GET["property"], true);
        exit;

    }

}
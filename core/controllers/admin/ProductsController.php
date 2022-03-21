<?php

namespace core\controllers\admin;

use core\helpers\Functions;
use core\services\AdminService;
use core\services\ProductService;

class ProductsController {

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

    public function index() {

        if(isset($_GET["page"]) && !empty($_GET["page"])) {
            $page = intval(filter_input(INPUT_GET, 'page'));
        } else {
            $page = 1;
        }

        // echo "<pre>";
        // print_r(ProductService::getListProducts($page));exit;

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
            "activeMenu" => "products",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,

            "flash" => $flash,
            "success" => $success,
            
            "productsEnding" => ProductService::getProductsEnding(),
            "productsNotStock" => ProductService::getProductsWhereNotStock(),

            "products" => ProductService::getListProducts($page),
            "productsPage" => true,
            "search" => false
        ];

        // Apresentar a view do produto
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/products/products",
            "partials/footer",
        ], $data);

    }

    public function searchProduct() {

        if(isset($_GET["page"]) && !empty($_GET["page"])) {
            $page = intval(filter_input(INPUT_GET, 'page'));
        } else {
            $page = 1;
        }

        if(isset($_GET["search"]) && empty($_GET["search"])) {
            $_SESSION["flash"] = "Digite um termo para buscar!";
            Functions::Redirect("products", true);
            exit;
        }

        $search = filter_input(INPUT_GET, "search");
        
        $data =  [
            "activeMenu" => "products",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,

            "products" => ProductService::searchProductsInDatabase($search, $page),
            "searchTerm" => $search,
            "search" => true,

            "productsEnding" => false,
            "productsNotStock" => false,
            "productsPage" => false
        ];

        // Apresentar a view do produto
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/products/products",
            "partials/footer",
        ], $data);

    }

    // Tela para adicionar novos produtos
    public function newProduct() {

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
            "activeMenu" => "products",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,
            "flash" => $flash,
            "success" => $success
        ];

        // Apresentar a view de adicionar produto
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/products/newProduct",
            "partials/footer",
        ], $data);

    }

    public function productSubmit() {

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido!";
            Functions::Redirect("newProduct", true);
            exit;
        }

        foreach($_POST as $key => $value ) {
            // Remove todas as tags HTML
            // Remove os espaços em branco do valor
            $key = trim( strip_tags($value) );
        
            // Verifica se tem algum valor em branco
            if(empty($value)) {
                $_SESSION["flash"] = "Todos os campos precisam estar preenchidos!";
                Functions::Redirect("newProduct", true);
                exit;
            }
        }

        $fields = [
            "name" => filter_input(INPUT_POST, "name"),
            "description" => filter_input(INPUT_POST, "description"),
            "price" => filter_input(INPUT_POST, "price"),
            "width" => filter_input(INPUT_POST, "width"),
            "height" => filter_input(INPUT_POST, "height"),
            "length" => filter_input(INPUT_POST, "length"),
            "weight" => filter_input(INPUT_POST, "weight"),
            "stock" => filter_input(INPUT_POST, "stock")
        ];

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
                    Functions::Redirect("newProduct", true);
                    exit;
                }
            }

            $names = [];
            foreach($images as $item) {
                $folder = "../../public/assets/images/products";
                $names[] = Functions::cutImage($item, 1080, 1080, $folder);
            }

        }

        $productId = ProductService::addProductInDatabase($fields);
        
        foreach($names as $image) {
            // Inserir imagens no banco de dados
            ProductService::addImageProduct($productId, $image);
        }

        // Produto e imagens adicionados!
        $_SESSION["success"] = "Produto adicionado com sucesso junto com as imagens!";
        Functions::Redirect("newProduct", true);
        exit;

    }

    public function editProduct() {

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
            Functions::Redirect("products", true);
            exit;
        }

        if(strlen($_GET["id"]) != 32) {
            $_SESSION["flash"] = "Id não encriptado!";
            Functions::Redirect("products", true);
            exit;
        }

        $id = Functions::aesDescrypt($_GET["id"]);
        if(empty($id)) {
            $_SESSION["flash"] = "Id vazio ou não permitido!";
            Functions::Redirect("products", true);
            exit;
        }

        // Verificar no banco de dados se existe o produto
        $productExists = ProductService::verifyIfProductExistsInDatabase($id);
        if(!$productExists) {
            $_SESSION["flash"] = "Produto não existe!";
            Functions::Redirect("products", true);
            exit;
        }

        $images = ProductService::getImagesFromProductById($productExists->id);

        $data = [
            "activeMenu" => "products",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,

            "flash" => $flash,
            "success" => $success,
            
            "product" => $productExists,
            "images" => $images
        ];

        // Apresentar a view de adicionar produto
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/products/editForm",
            "partials/footer",
        ], $data);

    }

    public function editProductSubmit() {

        // echo "<pre>";
        // print_r($_FILES["image"]);exit;

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido!";
            Functions::Redirect("products", true);
            exit;
        }

        $id = filter_input(INPUT_POST, "id");

        if(empty($id)) {
            $_SESSION["flash"] = "Id não enviado!";
            Functions::Redirect("products", true);
            exit;
        }

        if(strlen($id) != 32) {
            $_SESSION["flash"] = "Id não encriptado!";
            Functions::Redirect("products", true);
            exit;
        }

        $productId = Functions::aesDescrypt($id);
        if(empty($productId)) {
            $_SESSION["flash"] = "Ocorreu um erro com o id!";
            Functions::Redirect("products", true);
            exit;
        }

        foreach($_POST as $key => $value ) {
            // Remove todas as tags HTML
            // Remove os espaços em branco do valor
            $key = trim( strip_tags($value) );
        
            // Verifica se tem algum valor em branco
            if(empty($value)) {
                $_SESSION["flash"] = "Todos os campos precisam estar preenchidos!";
                Functions::Redirect("editProduct?id=".$id, true);
                exit;
            }
        }

        $fields = [
            "id" => $productId,
            "name" => filter_input(INPUT_POST, "name"),
            "description" => filter_input(INPUT_POST, "description"),
            "price" => filter_input(INPUT_POST, "price"),
            "width" => filter_input(INPUT_POST, "width"),
            "height" => filter_input(INPUT_POST, "height"),
            "length" => filter_input(INPUT_POST, "length"),
            "weight" => filter_input(INPUT_POST, "weight"),
            "stock" => filter_input(INPUT_POST, "stock")
        ];

        ProductService::updateProductInDatabase($fields);

        // Produto e imagens editados!
        $_SESSION["success"] = "Produto editado com sucesso!";
        Functions::Redirect("editProduct?id=".$id, true);
        exit;

    }

    public function deleteImageSingle() {

        $productId = filter_input(INPUT_GET, "productId");
        $url = filter_input(INPUT_GET, "image");

        if(empty($url) || empty($productId)) {
            $_SESSION["flash"] = "Envie uma imagem e o id do produto!";
            Functions::Redirect("products", true);
            exit;
        }

        if(strlen($productId) != 32) {
            $_SESSION["flash"] = "Id não esta encriptado!";
            Functions::Redirect("products", true);
            exit;
        }

        $idProduct = Functions::aesDescrypt($productId);
        if(empty($idProduct)) {
            $_SESSION["flash"] = "Id vazio!";
            Functions::Redirect("products", true);
            exit;
        }



        $folder = "../../public/assets/images/products/".$url;

        if(file_exists($folder)) {
            // Deletar no banco de dados

            ProductService::deleteSingleImage($url);
            unlink($folder);

            $_SESSION["success"] = "Imagem deletada com sucesso!";
            Functions::Redirect("editProduct?id=".$productId, true);
            exit;

        } else {
            $_SESSION["flash"] = "Imagem não existe!";
            Functions::Redirect("products", true);
            exit;
        }

    }

    public function showProductsEndingOrZero() {

        if(isset($_GET["page"]) && !empty($_GET["page"])) {
            $page = intval(filter_input(INPUT_GET, 'page'));
        } else {
            $page = 1;
        }

        $type = filter_input(INPUT_GET, "type");
        if(empty($type)) {
            $_SESSION["flash"] = "Envie o tipo!";
            Functions::Redirect("products", true);
            exit;
        }

        if($type !== "ending" && $type !== "notStock") {
            $_SESSION["flash"] = "Ocorreu um erro!";
            Functions::Redirect("products", true);
            exit;
        }

        $data = [
            "activeMenu" => "products",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,
            "products" => ProductService::getListProductFromType($type, $page),
            "type" => $type
        ];

        // Apresentar a view do produto
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/products/productsEnding",
            "partials/footer",
        ], $data);

    }

    public function addImages() {

        $productId = filter_input(INPUT_POST, "productId");
        if(empty($productId)) {
            $_SESSION["flash"] = "Envie o id do produto!";
            Functions::Redirect("products", true);
            exit;
        }

        if(strlen($productId) != 32) {
            $_SESSION["flash"] = "O id precisa ter 32 caracteres!";
            Functions::Redirect("products", true);
            exit;
        }

        $id = Functions::aesDescrypt($productId);
        if(empty($id)) {
            $_SESSION["flash"] = "Ocorreu um erro com o id!";
            Functions::Redirect("products", true);
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
                    Functions::Redirect("newProduct", true);
                    exit;
                }
            }

            $names = [];
            foreach($images as $item) {
                $folder = "../../public/assets/images/products";
                $names[] = Functions::cutImage($item, 1080, 1080, $folder);
            }

        }

        foreach($names as $image) {
            // Inserir imagens no banco de dados
            ProductService::addImageProduct($id, $image);
        }

        $_SESSION["success"] = "Imagem adicionada com sucesso!";
        Functions::Redirect("editProduct?id=".$productId, true);
        exit;

    }

    public function delProduct() {

        $id = filter_input(INPUT_GET, "id");

        if(empty($id)) {
            $_SESSION["flash"] = "Id não enviado!";
            Functions::Redirect("products", true);
            exit;
        }

        if(strlen($id) != 32) {
            $_SESSION["flash"] = "Id não encriptado!";
            Functions::Redirect("products", true);
            exit;
        }

        $productId = Functions::aesDescrypt($id);
        if(empty($productId)) {
            $_SESSION["flash"] = "Ocorreu um erro com o id!";
            Functions::Redirect("products", true);
            exit;
        }

        $productItem = ProductService::verifyIfProductExistsInDatabase($productId);
        if(!$productItem) {
            $_SESSION["flash"] = "Nada para deletar!";
            Functions::Redirect("products", true);
            exit;
        }

        // Pegar as imagens do produto para deletar
        $listImages = ProductService::getAllImagesFromProductId($productItem->id);

        if(count($listImages) > 0) {
            
            $folder = "../../public/assets/images/products/";
            foreach($listImages as $image) {
                if(file_exists($folder.$image->url)) {
                    unlink($folder.$image->url);
                }
            }

        }

        ProductService::deleteProduct($productItem->id);
        
        $_SESSION["success"] = "Produto deletado com sucesso!";
        Functions::Redirect("products", true);
        exit;

    }

}
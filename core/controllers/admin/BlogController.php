<?php

namespace core\controllers\admin;

use core\helpers\Functions;
use core\services\AdminService;
use core\services\CategoryService;
use core\services\NoticeService;

class BlogController {

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

    public function blog() {

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
            "activeMenu" => "blog",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,

            "flash" => $flash,
            "success" => $success,

            "categories" => CategoryService::getAllCategories(),
            "notices" => NoticeService::getAllNoticesFromAdmin()
        ];

        // Apresentar a view do blog
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/blog/blog",
            "partials/footer",
        ], $data);
    }

    public function newCategory() {

        $data = [
            "activeMenu" => "blog",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission
        ];

        // Apresentar a view da nova categoria
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/blog/newCategory",
            "partials/footer",
        ], $data);
    }

    public function newCategorySubmit() {

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido!";
            Functions::Redirect("notices", true);
            exit;
        }

        if(isset($_POST["name"]) && !empty($_POST["name"])) {
            $name = filter_input(INPUT_POST, "name");

            CategoryService::addCategory($name);
            $_SESSION["success"] = "Categoria inserida com sucesso!";
            Functions::Redirect("notices", true);
            exit;
        } else {
            $_SESSION["flash"] = "Envie o nome da categoria!";
            Functions::Redirect("notices", true);
            exit;
        }
    }

    public function getCategoryById() {

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido!";
            Functions::Redirect("notices", true);
            exit;
        }

        $post = json_decode(file_get_contents("php://input"), true);

        $id = $post["id"];
        $data = [];

        if($id) {

            $result = CategoryService::getCategoryById($id);
            if ($result) {
                $data["result"] = $result;
            } else {
                $data["error"] = true;
            }
        }

        echo json_encode($data);
    }

    public function editcategorySubmit() {

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido!";
            Functions::Redirect("notices", true);
            exit;
        }

        if(!isset($_POST["id"]) && empty($_POST["id"]) || !isset($_POST["name"]) && empty($_POST["name"])) {
            $_SESSION["flash"] = "Preencha os dados corretamente!";
            Functions::Redirect("notices", true);
            exit;
        }

        $id = filter_input(INPUT_POST, "id");
        $name = filter_input(INPUT_POST, "name");

        CategoryService::updateCategory($id, $name);

        $_SESSION["success"] = "Categoria atualizada com sucesso!";
        Functions::Redirect("notices", true);
        exit;
    }

    public function deleteCategory() {

        if(!isset($_GET["id"])) {
            $_SESSION["flash"] = "Id não enviado!";
            Functions::Redirect("notices", true);
            exit;
        }

        $id = filter_input(INPUT_GET, "id");
        $result = CategoryService::getCategoryById($id);

        if($result->id) {
            CategoryService::deleteCategoryInDatabase($result->id);

            $_SESSION["success"] = "Categoria deletada com sucesso!";
            Functions::Redirect("notices", true);
            exit;
        } else {
            $_SESSION["flash"] = "Id não encontrado!";
            Functions::Redirect("notices", true);
            exit;
        }
    }

    public function newPost() {

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
            "activeMenu" => "blog",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,
            "flash" => $flash,
            "success" => $success,

            "categories" => CategoryService::getAllCategories()
        ];

        // Apresentar a view de adicionar post
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/blog/newPost",
            "partials/footer",
        ], $data);
    }

    public function newPostSubmit() {

        // echo "<pre>";
        // print_r($_POST);exit;

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido!";
            Functions::Redirect("newPost", true);
            exit;
        }

        if(isset($_POST["category"]) && empty($_POST["category"])) {
            $_SESSION["flash"] = "Categoria não enviada!";
            Functions::Redirect("newPost", true);
            exit;
        } elseif (isset($_POST["title"]) && empty($_POST["title"])) {
            $_SESSION["flash"] = "Envie o título do post!";
            Functions::Redirect("newPost", true);
            exit;
        } elseif (isset($_POST["body"]) && empty($_POST["body"])) {
            $_SESSION["flash"] = "Envie o corpo do post!";
            Functions::Redirect("newPost", true);
            exit;
        }

        // Verificar se a categoria existe
        $categoryExists = CategoryService::getCategoryById($_POST["category"]);
        if(!$categoryExists) {
            $_SESSION["flash"] = "Categoria não existe!";
            Functions::Redirect("newPost", true);
            exit;
        }

        $slug = Functions::createSlug($_POST["title"]);

        $fields = [
            "categoryId" => $_POST["category"],
            "title" => $_POST["title"],
            "slug" => $slug,
            "body" => $_POST["body"],
            "authorId" => $this->loggedAdmin->id
        ];

        // print_r($_FILES);exit;
        if(isset($_FILES["thumbnail"]) && !empty($_FILES["thumbnail"]["tmp_name"])) {

            $thumbnail = $_FILES["thumbnail"];
            if(in_array($thumbnail["type"], ["image/jpeg", "image/jpg", "image/png"])) {

                $folder = "../../public/assets/images/posts";
                $thumbnailName = Functions::cutImage($thumbnail, 1280, 720, $folder);

                $fields["thumbnail"] = $thumbnailName;

                NoticeService::addNewNoticeInDatabase($fields);

                $_SESSION["success"] = "Post adicionado com sucesso!";
                Functions::Redirect("notices", true);
                exit;
            } else {
                $_SESSION["flash"] = "Imagem inválida!";
                Functions::Redirect("newPost", true);
                exit;
            }
        }

        $fields["thumbnail"] = "default.jpg";
        NoticeService::addNewNoticeInDatabase($fields);
        $_SESSION["success"] = "Post adicionado com sucesso!";
        Functions::Redirect("notices", true);
    }

    public function singleNotice() {

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

        if(!isset($_GET["slug"]) || empty($_GET["slug"])) {
            Functions::Redirect("notices", true);
            exit;
        }

        $slug = filter_input(INPUT_GET, "slug");
        $notice = NoticeService::getNoticeBySlug($slug);

        if(!$notice) {
            Functions::Redirect("notices", true);
            exit;
        }

        $data = [
            "activeMenu" => "blog",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,

            "flash" => $flash,
            "success" => $success,

            "notice" => $notice,
            "categories" => CategoryService::getAllCategories()
        ];

        // Apresentar a view do admin
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/blog/singleNotice",
            "partials/footer",
        ], $data);
    }

    public function editPostSubmit() {

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido!";
            Functions::Redirect("notices", true);
            exit;
        }

        // Verificar id
        if(!isset($_POST["id"]) || empty($_POST["id"])) {
            $_SESSION["flash"] = "Id não existe!";
            Functions::Redirect("notices", true);
            exit;
        }

        if(!isset($_POST["title"]) || empty($_POST["title"])) {
            $_SESSION["flash"] = "Envie um título para o post!";
            Functions::Redirect("notices", true);
            exit;
        }

        if(!isset($_POST["body"]) || empty($_POST["body"])) {
            $_SESSION["flash"] = "Envie o texto da postagem!";
            Functions::Redirect("notices", true);
            exit;
        }


        $id = filter_input(INPUT_POST, "id");
        $title = filter_input(INPUT_POST, "title");
        $body = filter_input(INPUT_POST, "body");
        $slug = Functions::createSlug($title);


        $idExists = NoticeService::verifyIdExistsInDatabase($id);
        if($idExists) {
            // Atualizar post no banco de dados
            NoticeService::updateTitleAndBody($id, $title, $body, $slug);

            $_SESSION["success"] = "Post atualizado com sucesso!";
            Functions::Redirect("notices", true);
            exit;
        } else {
            $_SESSION["flash"] = "Id não existe!";
            Functions::Redirect("notices", true);
            exit;
        }
    }

    public function updateThumbandCategory() {

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido!";
            Functions::Redirect("notices", true);
            exit;
        }

        if(!isset($_POST["id"]) || empty($_POST["id"])) {
            $_SESSION["flash"] = "Id não enviado!";
            Functions::Redirect("notices", true);
            exit;
        }

        if(!isset($_POST["category"]) || empty($_POST["category"])) {
            $_SESSION["flash"] = "Envie uma categoria válida!";
            Functions::Redirect("notices", true);
            exit;
        }

        $id = filter_input(INPUT_POST, "id");
        // Verificar se o id existe
        $idExists = NoticeService::verifyIdExistsInDatabase($id);
        if(!$idExists) {
            $_SESSION["flash"] = "Id não existe!";
            Functions::Redirect("notices", true);
            exit;
        }

        $category = filter_input(INPUT_POST, "category");
        // Verificar se a categoria existe
        $categoryExists = CategoryService::getCategoryById($category);
        if(!$categoryExists) {
            $_SESSION["flash"] = "Categoria não existe!";
            Functions::Redirect("notices", true);
            exit;
        }

        if(isset($_FILES["thumbnail"]) && !empty($_FILES["thumbnail"]["tmp_name"])) {

            $thumbnail = $_FILES["thumbnail"];
            if(in_array($thumbnail["type"], ["image/jpeg", "image/jpg", "image/png"])) {

                $folder = "../../public/assets/images/posts";
                $thumbnailName = Functions::cutImage($thumbnail, 1280, 720, $folder);

                NoticeService::updateThumbAndCategory($thumbnailName, $category, $id);

                if(isset($_POST["oldImage"]) && !empty($_POST["oldImage"])) {
                    if($_POST["oldImage"] !== "default.jpg") {
                        $imageOldFolder = $folder . "/" . $_POST["oldImage"];
                        unlink($imageOldFolder);
                    }
                }

                $_SESSION["success"] = "Imagem e categoria atualizados com sucesso!";
                Functions::Redirect("notices", true);
                exit;

            } else {

                $_SESSION["flash"] = "Escolha uma imagem válida!";
                Functions::Redirect("notices", true);
                exit;
            }
        } else {

            NoticeService::updateThumbAndCategory($_POST["oldImage"], $category, $id);
            $_SESSION["success"] = "Categoria do post atualizada com sucesso!";
            Functions::Redirect("notices", true);
            exit;           

        }

    }

    public function deletePost() {

        if(!isset($_GET["id"])) {
            $_SESSION["flash"] = "Id não enviado!";
            Functions::Redirect("notices", true);
            exit;
        }

        // Verificar se não veio o parâmetro oldImage
        if(!isset($_GET["oldImage"])) {
            $_SESSION["flash"] = "Imagem não enviada!";
            Functions::Redirect("notices", true);
            exit;
        }

        // Verificar encriptação
        if(strlen($_GET["id"]) != 32) {
            Functions::Redirect("notices", true);
            exit;
        } else {
            $id = Functions::aesDescrypt($_GET["id"]);
            if(empty($id)) {
                Functions::Redirect("notices", true);
                exit;
            }
        }

        // Verificar se existe no banco de dados
        if(!NoticeService::verifyIdExistsInDatabase($id)) {
            $_SESSION["flash"] = "Não existe post com este id!";
            Functions::Redirect("notices", true);
            exit;
        }

        if(!NoticeService::verifyIfPostIsLoggedUserAdmin($id, $this->loggedAdmin->id)) {
            $_SESSION["flash"] = "Você não pode excluir um post que não é seu!";
            Functions::Redirect("notices", true);
            exit;
        }

        // Deletando a thumb do post
        $oldImage = $_GET["oldImage"];
        if($oldImage !== "default.jpg") {
            $folder = "../../public/assets/images/posts/".$oldImage;
            if(file_exists($folder)) {
                unlink($folder);  
            }
        }

        // Deletando post do banco de dados
        NoticeService::deletePost($id);
        $_SESSION["success"] = "Post deletado com sucesso!";
        Functions::Redirect("notices", true);
        exit;
        
    }

}

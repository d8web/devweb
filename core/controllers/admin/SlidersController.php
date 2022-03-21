<?php

namespace core\controllers\admin;

use core\helpers\Functions;
use core\services\AdminService;
use core\services\ServiceService;
use core\services\SliderService;

class SlidersController {

    private $loggedAdmin;
    private $permission;

    public function __construct() {

        $this->loggedAdmin = AdminService::checkAdminLogin();
        if($this->loggedAdmin === false) {
            Functions::Redirect("signin", true);
            exit;
        } else {
            $this->permission = Functions::verifyPermission($this->loggedAdmin->adminField);
            if($this->permission !== "adminstrador" && $this->permission !== "sub adminstrador") {
                Functions::Redirect("", true);
                exit;
            }
        }

    }

    public function sliders() {

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
            "activeMenu" => "sliders",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,

            "flash" => $flash,
            "success" => $success,

            "sliders" => SliderService::getAllSliders()
        ];

        // Apresentar a view do admin
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/sliders/sliders",
            "partials/footer",
        ], $data);
    }

    public function newslide() {

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
            "activeMenu" => "sliders",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,

            "flash" => $flash,
            "success" => $success
        ];

        // Apresentar a view do admin
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/sliders/newslide",
            "partials/footer",
        ], $data);

    }

    public function newslideSubmit() {

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido!";
            Functions::Redirect("sliders", true);
            exit;
        }

        if(isset($_FILES["slide"]) && !empty($_FILES["slide"]["tmp_name"])) {
            $slide = $_FILES["slide"];

            if(in_array($slide["type"], ["image/jpeg", "image/jpg", "image/png"])) {

                $folder = "../../public/assets/images/sliders";
                $slideName = Functions::cutImage($slide, 1920, 1080, $folder);

                SliderService::addNewSlide($slideName);
                
                $_SESSION["success"] = "Slide cadastrado com sucesso!";
                Functions::Redirect("sliders", true);
                exit;

            } else {
                $_SESSION["flash"] = "Escolha uma imagem válida!";
                Functions::Redirect("sliders", true);
                exit;
            }

        }

    }

    public function getSlidebyId() {

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido!";
            Functions::Redirect("slides", true);
            exit;
        }

        $post = json_decode(file_get_contents("php://input"), true);

        $id = $post["id"];
        $data = [];
        
        if($id) {

            $result = SliderService::getSlideByIdInDatabase($id);
            if($result) {
                $data["result"] = $result;
            } else {
                $data["error"] = true;
            }

        }

        echo json_encode($data);

    }

    public function editslideSubmit() {

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido!";
            Functions::Redirect("sliders", true);
            exit;
        }

        if(isset($_FILES["slide"]) && !empty($_FILES["slide"]["tmp_name"])) {

            $slide = $_FILES["slide"];
            if(in_array($slide["type"], ["image/jpeg", "image/jpg", "image/png"])) {

                $folder = "../../public/assets/images/sliders";
                $slideName = Functions::cutImage($slide, 1920, 1080, $folder);

                $id = filter_input(INPUT_POST, "id");
                SliderService::updateSlide($slideName, $id);

                if(isset($_POST["oldImage"]) && !empty($_POST["oldImage"])) {
                    $imageOldFolder = $folder."/".$_POST["oldImage"];
                    unlink($imageOldFolder);
                }

                $_SESSION["success"] = "Slide atualizado com sucesso!";
                Functions::Redirect("sliders", true);
                exit;

            } else {
                $_SESSION["flash"] = "Escolha uma imagem válida!";
                Functions::Redirect("sliders", true);
                exit;
            }

        }

        $_SESSION["flash"] = "Slide não enviado!";
        Functions::Redirect("sliders", true);
        exit;

    }

    public function deleteSlide() {

        if(!isset($_GET["id"])) {
            $_SESSION["flash"] = "Id não enviado!";
            Functions::Redirect("sliders", true);
            exit;
        }

        $id = filter_input(INPUT_GET, "id");
        $result = SliderService::getSlideByIdInDatabase($id);

        if($result->id) {

            // Deletar imagem do sistema
            $folder = "../../public/assets/images/sliders";
            $imageFolder = $folder."/".$result->url;
            unlink($imageFolder);

            // Deletar registro do banco de dados
            SliderService::deleteSlideInDatabase($result->id);

            // Redirecionar para a página lista de sliders, sucesso!
            $_SESSION["success"] = "Slide deletado com sucesso!";
            Functions::Redirect("sliders", true);
            exit;

        } else {
            $_SESSION["flash"] = "Id não encontrado!";
            Functions::Redirect("sliders", true);
            exit;
        }

    }

}
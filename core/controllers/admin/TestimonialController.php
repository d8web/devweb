<?php

namespace core\controllers\admin;

use core\helpers\Functions;
use core\services\AdminService;
use core\services\TestimonialService;

class TestimonialController {

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

    public function testimonialsList() {

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
            "activeMenu" => "testimonials",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,

            "testimonials" => TestimonialService::getTestimonials(),
            "flash" => $flash,
            "success" => $success
        ];

        // Apresentar a view do admin
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/testimonials/testimonials",
            "partials/footer",
        ], $data);
    }

    public function newtestimonial() {
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
            "activeMenu" => "testimonials",
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
            "pages/testimonials/newtestimonial",
            "partials/footer",
        ], $data);
    }

    public function newtestimonialSubmit() {

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido!";
            Functions::Redirect("newtestimonial", true);
            exit;
        }

        if(
            isset($_POST["author"]) && empty($_POST["author"]) || 
            isset($_POST["body"]) && empty($_POST["body"]))
        {
            $_SESSION["flash"] = "Preencha os dados corretamente!";
            Functions::Redirect("newtestimonial", true);
            exit;
        }

        $author = filter_input(INPUT_POST, "author");
        $body = filter_input(INPUT_POST, "body");

        TestimonialService::addNewTestimonial($author, $body);

        $_SESSION["success"] = "Cadastrado com sucesso!";
        Functions::Redirect("testimonials", true);
        exit;
    }

    public function getTestimonialById() {

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido!";
            Functions::Redirect("testimonials", true);
            exit;
        }

        $post = json_decode(file_get_contents("php://input"), true);

        $id = $post["id"];
        $data = [];
        
        if($id) {

            $result = TestimonialService::getTestimonialByIdInDatabase($id);
            if($result) {
                $data["result"] = $result;
            } else {
                $data["error"] = true;
            }

        }

        echo json_encode($data);

    }

    public function editTestimonial() {
        
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido!";
            Functions::Redirect("testimonials", true);
            exit;
        }

        if(
            isset($_POST["id"]) && empty($_POST["id"]) ||
            isset($_POST["author"]) && empty($_POST["author"]) || 
            isset($_POST["body"]) && empty($_POST["body"]))
        {
            $_SESSION["flash"] = "Preencha os dados corretamente!";
            Functions::Redirect("testimonials", true);
            exit;
        }

        $id = filter_input(INPUT_POST, "id");
        $author = filter_input(INPUT_POST, "author");
        $body = filter_input(INPUT_POST, "body");

        TestimonialService::updateTestimonial($id, $author, $body);

        $_SESSION["success"] = "Depoimento atualizado com sucesso!";
        Functions::Redirect("testimonials", true);
        exit;
    }

    public function deleteTestimonial() {

        if(!isset($_GET["id"])) {
            $_SESSION["flash"] = "Id não enviado!";
            Functions::Redirect("testimonials", true);
            exit;
        }

        $id = filter_input(INPUT_GET, "id");
        $result = TestimonialService::getTestimonialByIdInDatabase($id);

        if($result->id) {
            TestimonialService::deleteTestimonialInDatabase($result->id);

            $_SESSION["success"] = "Depoimento deletado com sucesso!";
            Functions::Redirect("testimonials", true);
            exit;

        } else {
            $_SESSION["flash"] = "Id não encontrado!";
            Functions::Redirect("testimonials", true);
            exit;
        }

    }

}
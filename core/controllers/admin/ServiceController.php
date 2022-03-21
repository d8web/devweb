<?php

namespace core\controllers\admin;

use core\helpers\Functions;
use core\services\AdminService;
use core\services\ServiceService;

class ServiceController {

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

    public function services() {

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
            "activeMenu" => "services",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,

            "flash" => $flash,
            "success" => $success,

            "services" => ServiceService::getAllServices()
        ];

        // Apresentar a view do admin
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/services/services",
            "partials/footer",
        ], $data);
    }

    public function newservice() {
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
            "activeMenu" => "services",
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
            "pages/services/newservice",
            "partials/footer",
        ], $data);
    }

    public function newserviceSubmit() {

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido!";
            Functions::Redirect("newservice", true);
            exit;
        }

        if(
            isset($_POST["title"]) && empty($_POST["title"]) || 
            isset($_POST["icon"]) && empty($_POST["icon"]) || 
            isset($_POST["body"]) && empty($_POST["body"]))
        {
            $_SESSION["flash"] = "Preencha os dados corretamente!";
            Functions::Redirect("newservice", true);
            exit;
        }

        $title = filter_input(INPUT_POST, "title");
        $icon = filter_input(INPUT_POST, "icon");
        $body = filter_input(INPUT_POST, "body");

        ServiceService::addNewService($title, $icon, $body);

        $_SESSION["success"] = "Serviço cadastrado com sucesso!";
        Functions::Redirect("services", true);
        exit;

    }

    public function getServiceById() {

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido!";
            Functions::Redirect("services", true);
            exit;
        }

        $post = json_decode(file_get_contents("php://input"), true);

        $id = $post["id"];
        $data = [];
        
        if($id) {

            $result = ServiceService::getServiceByIdInDatabase($id);
            if($result) {
                $data["result"] = $result;
            } else {
                $data["error"] = true;
            }

        }

        echo json_encode($data);

    }

    public function editServiceSubmit() {

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido!";
            Functions::Redirect("services", true);
            exit;
        }

        if(
            isset($_POST["id"]) && empty($_POST["id"]) ||
            isset($_POST["title"]) && empty($_POST["title"]) || 
            isset($_POST["icon"]) && empty($_POST["icon"]) || 
            isset($_POST["body"]) && empty($_POST["body"]))
        {
            $_SESSION["flash"] = "Preencha os dados corretamente!";
            Functions::Redirect("services", true);
            exit;
        }

        $id = filter_input(INPUT_POST, "id");
        $title = filter_input(INPUT_POST, "title");
        $icon = filter_input(INPUT_POST, "icon");
        $body = filter_input(INPUT_POST, "body");

        ServiceService::updateService($id, $title, $icon, $body);

        $_SESSION["success"] = "Serviço atualizado com sucesso!";
        Functions::Redirect("services", true);
        exit;

    }

    public function deleteService() {

        if(!isset($_GET["id"])) {
            $_SESSION["flash"] = "Id não enviado!";
            Functions::Redirect("services", true);
            exit;
        }

        $id = filter_input(INPUT_GET, "id");
        $result = ServiceService::getServiceByIdInDatabase($id);

        if($result->id) {
            ServiceService::deleteServiceInDatabase($result->id);

            $_SESSION["success"] = "Serviço deletado com sucesso!";
            Functions::Redirect("services", true);
            exit;

        } else {
            $_SESSION["flash"] = "Id não encontrado!";
            Functions::Redirect("services", true);
            exit;
        }

    }

}
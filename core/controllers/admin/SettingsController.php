<?php

namespace core\controllers\admin;

use core\helpers\Functions;
use core\services\AdminService;
use core\services\ConfigServices;
use core\services\SliderService;

class SettingsController {

    private $loggedAdmin;
    private $permission;

    public function __construct() {

        $this->loggedAdmin = AdminService::checkAdminLogin();
        if($this->loggedAdmin === false) {
            Functions::Redirect("signin", true);
            exit;
        } else {
            $this->permission = Functions::verifyPermission($this->loggedAdmin->adminField);
            if(
                $this->permission === "normal" && 
                $this->permission !== "adminstrador" && 
                $this->permission !== "sub adminstrador"
            ) {
                Functions::Redirect("", true);
                exit;
            }
        }

    }

    public function config() {

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
            "activeMenu" => "config",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,

            "flash" => $flash,
            "success" => $success,
            "config" => ConfigServices::getListConfig()
        ];

        // Apresentar a view das configurações
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/config",
            "partials/footer",
        ], $data);
    }

    public function updateConfig() {

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido!";
            Functions::Redirect("config", true);
            exit;
        }

        $updateFields = [];

        if(isset($_POST["name"]) && !empty($_POST["name"])) {
            $updateFields["name"] = trim($_POST["name"]);
        }

        if(isset($_POST["description"]) && !empty($_POST["description"])) {
            $updateFields["description"] = $_POST["description"];
        }

        if(!isset($_POST["id"]) && empty($_POST["id"])) {
            $_SESSION["flash"] = "Id não enviado!";
            Functions::Redirect("config", true);
            exit;
        }

        $updateFields["id"] = trim($_POST["id"]);
        $result = ConfigServices::verifyIdExists($updateFields["id"]);

        if(!$result) {
            $_SESSION["flash"] = "Ocorreu um erro!";
            Functions::Redirect("config", true);
            exit;
        }

        if(isset($_FILES['imageConfig']) && !empty($_FILES['imageConfig']['tmp_name'])) {
            $imageConfig = $_FILES['imageConfig'];

            if(in_array($imageConfig['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {

                $folder = "../../public/assets/images/about";
                $imgName = Functions::cutImage($imageConfig, 800, 1200, $folder);
                $updateFields['image'] = $imgName;

                // Não está apagando a imagem antiga
                if(isset($_POST["oldImage"]) && !empty($_POST["oldImage"])) {
                    unlink($folder."/".$_POST["oldImage"]);
                }
            }
        } else {
            $updateFields["image"] = $_POST["oldImage"];
        }

        // Atualizando no banco de dados
        ConfigServices::updateConfigInDatabase($updateFields);
        
        $_SESSION["success"] = "Configurações atualizadas!";
        Functions::Redirect("config", true);
        exit;
        
    }

}
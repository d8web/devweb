<?php

namespace core\controllers\admin;

use core\helpers\Functions;
use core\services\AdminService;
use core\services\UserService;

class UserController {

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

    public function users() {

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
            "activeMenu" => "users",
            "loggedAdmin" => $this->loggedAdmin,
            "flash" => $flash,
            "success" => $success,
            "permission" => $this->permission
        ];

        // Apresentar a view do admin
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/users/users",
            "partials/footer",
        ], $data);
    }

    public function newuser() {

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
            "activeMenu" => "users",
            "loggedAdmin" => $this->loggedAdmin,
            "flash" => $flash,
            "success" => $success,
            "permission" => $this->permission
        ];

        // Apresentar a view do admin
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/users/newuser",
            "partials/footer",
        ], $data);

    }

    public function newuserSubmit() {
        
        // Verificar se veio todos os parâmetros [name, email, password, password_confirm, admin]
        if(
            isset($_POST["name"]) && empty($_POST["name"]) || 
            isset($_POST["email"]) && empty($_POST["email"]) ||
            isset($_POST["password"]) && empty($_POST["password"]) ||
            isset($_POST["password_confirm"]) && empty($_POST["password_confirm"]) ||
            !isset($_POST["admin"])
        ) {
            $_SESSION["flash"] = "Preencha os dados corretamente!";
            Functions::Redirect("newuser", true);
            exit;
        }

        // Verificar se veio o arquivo avatar e se a chave [tmp_name] não está vazio
        if($_FILES["avatar"] && !empty($_FILES["avatar"]["tmp_name"])) {

            $avatar = $_FILES["avatar"];
            // Verificar se o arquivo é do tipo jpeg,jpg,png
            if(in_array($avatar["type"], ["image/jpeg", "image/jpg", "image/png"])) {
                $folder = $_SERVER['DOCUMENT_ROOT'] . "/project/public/admin/assets/images";
                $avatarName = Functions::cutImage($avatar, 400, 400, $folder);
            } else {
                $_SESSION["flash"] = "Imagem não é válida!";
                Functions::Redirect("newuser", true);
                exit;
            }

        } else {
            $avatarName = "avatar.jpg";
        }

        $name = filter_input(INPUT_POST, "name");
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, "password");
        $passwordConfirm = filter_input(INPUT_POST, "password_confirm");
        $admin = intval(filter_input(INPUT_POST, "admin"));

        // Verificar se a permissão não é válida
        if(!key_exists($admin, PERMISSIONS)) {
            $_SESSION["flash"] = "Permissão não existe!";
            Functions::Redirect("newuser", true);
            exit;
        }

        if(UserService::emailExists($email)) {
            $_SESSION["flash"] = "Email já existe!";
            Functions::Redirect("newuser", true);
            exit;
        }

        if($password !== $passwordConfirm) {
            $_SESSION["flash"] = "As senhas precisam ser iguais!";
            Functions::Redirect("newuser", true);
            exit;
        }

        UserService::addnewUserInDatabase($name, $email, $password, $admin, $avatarName);
        
        $_SESSION["success"] = "Usuário adicionado com sucesso!";
        Functions::Redirect("newuser", true);
        exit;
    }

    public function updateUser() {
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            Functions::Redirect("users", true);
            exit;
        }

        $name = filter_input(INPUT_POST, "name");
        $password = filter_input(INPUT_POST, "password");
        $passwordConfirm = filter_input(INPUT_POST, "password_confirm");
        $avatar = $_FILES["avatar"];

        $updateFields = [];

        if(empty($name)) {
            $_SESSION["flash"] = "Preencha seu nome!";
            Functions::Redirect("users", true);
            exit;
        }

        if(empty($password)) {
            $_SESSION["flash"] = "Preencha a senha!";
            Functions::Redirect("users", true);
            exit;
        }

        if($password !== $passwordConfirm) {
            $_SESSION["flash"] = "As senhas não batem!";
            Functions::Redirect("users", true);
            exit;
        }

        if(!empty($avatar["tmp_name"])) {

            if(in_array($avatar["type"], ["image/jpeg", "image/jpg", "image/png"])) {

                $folder = $_SERVER['DOCUMENT_ROOT'] . "/project/public/admin/assets/images";
                $avatarName = Functions::cutImage($avatar, 400, 400, $folder);
                $updateFields["avatar"] = $avatarName;
    
                if(isset($_POST["oldImage"]) && !empty($_POST["oldImage"])) {
                    if($_POST["oldImage"] !== "avatar.jpg") {
                        $imageOldFolder = $folder."/".$_POST["oldImage"];
                        unlink($imageOldFolder);
                    }
                }

            } else {
                $_SESSION["flash"] = "Escolha uma imagem válida!";
                Functions::Redirect("users", true);
                exit;
            }

        } else {
            $updateFields["avatar"] = $_POST["oldImage"];
        }

        $updateFields["name"] = $name;
        $updateFields["password"] = $password;
        $updateFields["token"] = $_SESSION["token"];

        UserService::updateUserDatabase($updateFields);

        $_SESSION["success"] = "Usuário alterado com sucesso!";
        Functions::Redirect("users", true);
    }
}
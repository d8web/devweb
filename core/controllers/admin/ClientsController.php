<?php

namespace core\controllers\admin;

use core\helpers\Functions;
use core\services\AdminService;
use core\services\ClientService;
use core\services\FinancialService;

class ClientsController {

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

    public function clients() {

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
            "activeMenu" => "clients",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,
            "flash" => $flash,
            "success" => $success,
            "clients" => ClientService::getAllClientsFromDatabase()
        ];

        // Apresentar a view do client
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/clients/clients",
            "partials/footer",
        ], $data);

    }

    public function newClient() {

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
            "activeMenu" => "clients",
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
            "pages/clients/newClient",
            "partials/footer",
        ], $data);

    }

    public function newClientSubmit() {

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido!";
            Functions::Redirect("services", true);
            exit;
        }

        if(isset($_POST["name"]) && empty($_POST["name"])) {
            $_SESSION["flash"] = "Nome não enviado!";
            Functions::Redirect("clients", true);
            exit;
        }

        if(isset($_POST["email"]) && empty($_POST["email"])) {
            $_SESSION["flash"] = "Envie um email!";
            Functions::Redirect("clients", true);
            exit;
        }

        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["flash"] = "E-mail inválido!";
            Functions::Redirect("clients", true);
            exit;
        }

        if(isset($_POST["type"]) && !empty($_POST["type"])) {
            $type = filter_input(INPUT_POST, "type");
            if($type == "fisica") {
                if(isset($_POST["cpf"]) && empty($_POST["cpf"])) {
                    $_SESSION["flash"] = "Envie um cpf!";
                    Functions::Redirect("clients", true);
                    exit;
                }

                if(strlen(filter_input(INPUT_POST, "cpf")) != 14) {
                    $_SESSION["flash"] = "Cpf precisa ter 11 caracteres!";
                    Functions::Redirect("clients", true);
                    exit;
                }
            } else {
                if(isset($_POST["cnpj"]) && empty($_POST["cnpj"])) {
                    $_SESSION["flash"] = "Envie um cnpj!";
                    Functions::Redirect("clients", true);
                    exit;
                }
                
                if(strlen(filter_input(INPUT_POST, "cnpj")) != 18) {
                    $_SESSION["flash"] = "Cnpj precisa ter 14 caracteres!";
                    Functions::Redirect("clients", true);
                    exit;
                }
            }
        } else {
            $_SESSION["flash"] = "Envie um o tipo do cliente!";
            Functions::Redirect("clients", true);
            exit;
        }

        $avatarClientName = null;
        if(isset($_FILES["avatar"]) && !empty($_FILES["avatar"]["tmp_name"])) {

            $avatar = $_FILES["avatar"];

            if(in_array($avatar["type"], ["image/jpeg", "image/jpg", "image/png"])) {

                $folder = "../../public/admin/assets/images/clients";
                $avatarClientName = Functions::cutImage($avatar, 520, 520, $folder);

            } else {
                $_SESSION["flash"] = "Imagem inválida!";
                Functions::Redirect("clients", true);
                exit;
            }

        } else {
            $avatarClientName = "default.jpg";
        }

        $name = filter_input(INPUT_POST, "name");
        $email = filter_input(INPUT_POST, "email");
        $type = filter_input(INPUT_POST, "type");

        $number = null;
        if($type == "fisica") {
            $number = filter_input(INPUT_POST, "cpf");
        } else {
            $number = filter_input(INPUT_POST, "cnpj");
        }

        ClientService::addClientInDatabase($name, $email, $type, $number, $avatarClientName);
        $_SESSION["success"] = "Cliente cadastrado com sucesso!";
        Functions::Redirect("clients", true);
        exit;

    }

    public function editClientForm() {

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

        if(strlen($_GET["id"]) != 32) {
            Functions::Redirect("clients", true);
            exit;
        }

        $id = Functions::aesDescrypt($_GET["id"]);
        if(empty($id)) {
            Functions::Redirect("clients", true);
            exit;
        }

        $clientObject = ClientService::verifyClientExistsInDatabase($id);
        if(!$clientObject) {
            $_SESSION["error"] = "Cliente não existe!";
            Functions::Redirect("clients", true);
            exit;
        }

        $data = [
            "activeMenu" => "clients",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,
            "flash" => $flash,
            "success" => $success,
            "client" => $clientObject,
            "paymentsPendingClient" => FinancialService::getListPaymentFromClient($id, 0),
            "paymentsConcludedClient" => FinancialService::getListPaymentFromClient($id, 1)
        ];

        // Apresentar a view do admin
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/clients/editClientForm",
            "partials/footer",
        ], $data);

    }

    public function editClientSubmit() {

        if(isset($_POST["id"]) && empty($_POST["id"])) {
            $_SESSION["flash"] = "Id não enviado/permitido";
            Functions::Redirect("clients", true);
            exit;
        }

        if(strlen($_POST["id"]) != 32) {
            $_SESSION["flash"] = "Id não encriptado!";
            Functions::Redirect("clients", true);
            exit;
        }

        $id = Functions::aesDescrypt($_POST["id"]);
        if(empty($id)) {
            $_SESSION["flash"] = "Id vazio ou não permitido!";
            Functions::Redirect("clients", true);
            exit;
        }

        $clientObject = ClientService::verifyClientExistsInDatabase($id);
        if(!$clientObject) {
            $_SESSION["error"] = "Cliente não existe!";
            Functions::Redirect("clients", true);
            exit;
        }

        $name = filter_input(INPUT_POST, "name");
        $email = filter_input(INPUT_POST, "email");
        $type = filter_input(INPUT_POST, "type");

        $number = null;
        if($type === "fisica") {
            $number = filter_input(INPUT_POST, "cpf");
            if(strlen($number) != 14) {
                $_SESSION["flash"] = "O campo cpf precisa ter pelo menos 11 números!";
                Functions::Redirect("clients", true);
                exit;
            }
        } else {
            $number = filter_input(INPUT_POST, "cnpj");
            if(strlen($number) <= 17) {
                $_SESSION["flash"] = "O campo cnpj precisa ter pelo menos 14 números!";
                Functions::Redirect("clients", true);
                exit;
            }
        }

        if(strlen($name) <= 2) {
            $_SESSION["flash"] = "O nome precisa ter pelo menos 2 caracteres!";
            Functions::Redirect("clients", true);
            exit;
        }

        // if($name == $clientObject->name) {
        //     $_SESSION["flash"] = "Escolha um nome diferente do atual!";
        //     Functions::Redirect("editClient?id=".Functions::aesEncrypt($clientObject->id), true);
        //     exit;
        // }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["flash"] = "Email inválido!";
            Functions::Redirect("editClient?id=".Functions::aesEncrypt($clientObject->id), true);
            exit;
        }

        // Verificar se o email já existe
        if(ClientService::verifyEmailClientExistsInDatabase($email) !== false) {
            $_SESSION["flash"] = "Email já existe!";
            Functions::Redirect("editClient?id=".Functions::aesEncrypt($clientObject->id), true);
            exit;
        }

        if(isset($_FILES["avatar"]) && !empty($_FILES["avatar"]["tmp_name"])) {

            $avatar = $_FILES["avatar"];
            if(in_array($avatar["type"], ["image/jpeg", "image/jpg", "image/png"])) {

                $folder = "../../public/admin/assets/images/clients";
                $avatarClientName = Functions::cutImage($avatar, 520, 520, $folder);

                if(isset($_POST["oldImage"]) && !empty($_POST["oldImage"])) {
                    if($_POST["oldImage"] !== "default.jpg") {
                        $imageDelete = $folder."/".$_POST["oldImage"];
                        unlink($imageDelete);
                    }
                }

            } else {
                $_SESSION["flash"] = "Imagem inválida!";
                Functions::Redirect("editClient?id=".Functions::aesEncrypt($clientObject->id), true);
                exit;
            }

        } else {
            $avatarClientName = $_POST["oldImage"];
        }

        // Atualizar cliente
        ClientService::updateClientInDatabase($id, $name, $email, $type, $number, $avatarClientName);
        $_SESSION["success"] = "Cliente atualizado com sucesso!";
        Functions::Redirect("clients", true);
        exit;

    }

    public function searchClient() {

        if(isset($_POST["search"]) && empty($_POST["search"])) {
            $_SESSION["flash"] = "Digite um termo para buscar!";
            Functions::Redirect("clients", true);
            exit;
        }

        $search = filter_input(INPUT_POST, "search");
        
        $data =  [
            "activeMenu" => "clients",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,
            "clients" => ClientService::searchClientsInDatabase($search),
            "searchTerm" => $search
        ];

        // Apresentar a view do client
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/clients",
            "partials/footer",
        ], $data);

    }

    public function deleteClient() {

        if(strlen($_GET["id"]) != 32) {
            Functions::Redirect("clients");
            exit;
        }

        $id = Functions::aesDescrypt($_GET["id"]);
        if(empty($id)) {
            Functions::Redirect("clients");
            exit;
        }

        $clientObject = ClientService::verifyClientExistsInDatabase($id);
        if(!$clientObject) {
            $_SESSION["error"] = "Cliente não existe!";
            Functions::Redirect("clients", true);
            exit;
        }

        // Deletar imagem
        if($clientObject->avatar !== "default.jpg") {
            $folder = "../../public/admin/assets/images/clients/".$clientObject->avatar;
            // $urlImageClient = $_SERVER["DOCUMENT_ROOT"]."/project/public/admin/assets/images/clients/".$clientObject->avatar;
            unlink($folder);
        }

        ClientService::deleteClient($id);
        $_SESSION["success"] = "Cliente deletado com sucesso!";
        Functions::Redirect("clients", true);
        exit;

    }

}
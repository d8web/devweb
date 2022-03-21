<?php

namespace core\controllers\admin;

use core\helpers\Email;
use core\helpers\Functions;
use core\services\AdminService;
use core\services\ClientService;
use core\services\FinancialService;

class FinancialController {

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

    public function financial() {

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
            "activeMenu" => "financial",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,
            "flash" => $flash,
            "success" => $success,
            "paymentsPendingClient" => FinancialService::getListPaymentsFromStatus(0),
            "paymentsPaidClient" => FinancialService::getListPaymentsFromStatus(1)
        ];

        // Apresentar a view do financeiro
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/financial/financial",
            "partials/footer",
        ], $data);

    }

    public function addPaymentClient() {

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION["flash"] = "Método não permitido!";
            Functions::Redirect("financial", true);
            exit;
        }

        switch(true) {
            case (isset($_POST["namePayment"]) && empty($_POST["namePayment"])):
                $_SESSION["flash"] = "Envie o nome do pagamento!";
                Functions::Redirect("financial", true);
                exit;
            break;
            case (isset($_POST["paymentValue"]) && empty($_POST["paymentValue"])):
                $_SESSION["flash"] = "Envie o valor do pagamento!";
                Functions::Redirect("financial", true);
                exit;
            break;
            case (isset($_POST["numberPlots"]) && empty($_POST["numberPlots"])):
                $_SESSION["flash"] = "Envie o número de parcelas!";
                Functions::Redirect("financial", true);
                exit;
            break;
            case (isset($_POST["interval"]) && empty($_POST["interval"])):
                $_SESSION["flash"] = "Envie o intervalo!";
                Functions::Redirect("financial", true);
                exit;
            break;
            case (isset($_POST["expired"]) && empty($_POST["expired"])):
                $_SESSION["flash"] = "Envie a data de vencimento!";
                Functions::Redirect("financial", true);
                exit;
            break;
        }

        // Verificar se o id foi enviado e encriptação
        if($_POST["id"] && !empty($_POST["id"])) {

            $id = filter_input(INPUT_POST, "id");
            if(strlen($id) != 32) {
                $_SESSION["flash"] = "Id não tem 32 caracteres!";
                Functions::Redirect("financial", true);
                exit;
            }
    
            $idClient = Functions::aesDescrypt($id);
            if(empty($id)) {
                $_SESSION["flash"] = "Id vazio!";
                Functions::Redirect("financial", true);
                exit;
            }

            // Verificar se existe o cliente com o id enviado
            $clientObject = ClientService::verifyClientExistsInDatabase($idClient);
            if(!$clientObject) {
                $_SESSION["flash"] = "Cliente não existe!";
                Functions::Redirect("financial", true);
                exit;
            }

        } else {
            $_SESSION["flash"] = "Id não enviado ou vazio!";
            Functions::Redirect("financial", true);
            exit;
        }

        $expired = filter_input(INPUT_POST, "expired");
        $expired = explode('/', $expired);

        if(count($expired) != 3) {
            $_SESSION["flash"] = "Data inválida!";
            Functions::Redirect("financial", true);
            exit;
        }

        $expired = $expired[2].'-'.$expired[1].'-'.$expired[0];
        if(strtotime($expired) === false) {
            $_SESSION["flash"] = "Data inválida!";
            Functions::Redirect("financial", true);
            exit;
        }

        $today = date("Y-m-d");
        if(strtotime($expired) < strtotime($today)) {
            $_SESSION["flash"] = "Insira uma data maior que o data atual!";
            Functions::Redirect("financial", true);
            exit;
        }

        $namePayment = filter_input(INPUT_POST, "namePayment");
        $paymentValue = filter_input(INPUT_POST, "paymentValue");
        $numberPlots = filter_input(INPUT_POST, "numberPlots");
        $interval = filter_input(INPUT_POST, "interval");
        $status = 0; // default status

        for($i=0;$i<$numberPlots;$i++) {
            $newExpired = strtotime($expired) + (($i * $interval) * (60 * 60 * 24));
            // Adicionar pagamento no banco de dados
            FinancialService::addFinancialInDatabase($idClient, $namePayment, $paymentValue, date("Y-m-d", $newExpired), $status);
        }

        $_SESSION["success"] = "Pagamento inserido com sucesso!";
        Functions::Redirect("clients", true);
        exit;

    }

    public function alterStatusPaid() {

        if(isset($_GET["id"]) && empty($_GET["id"])) {
            $_SESSION["flash"] = "Id não enviado!";
            Functions::Redirect("clients", true);
            exit;
        }

        $id = filter_input(INPUT_GET, "id");
        if(strlen($id) != 32) {
            $_SESSION["flash"] = "Id não tem 32 caracteres!";
            Functions::Redirect("clients", true);
            exit;
        }

        $idFinance = Functions::aesDescrypt($id);
        if(empty($idFinance)) {
            $_SESSION["flash"] = "Id vazio!";
            Functions::Redirect("clients", true);
            exit;
        }

        if(isset($_GET["clientId"]) && empty($_GET["clientId"])) {
            $_SESSION["flash"] = "Id do cliente não enviado!";
            Functions::Redirect("clients", true);
            exit;
        }

        $idClient = filter_input(INPUT_GET, "clientId");
        if(strlen($idClient) != 32) {
            $_SESSION["flash"] = "Id do cliente não tem 32 caracteres!";
            Functions::Redirect("clients", true);
            exit;
        }

        $finalIdClient = Functions::aesDescrypt($idClient);
        if(empty($finalIdClient)) {
            $_SESSION["flash"] = "Id do cliente vazio!";
            Functions::Redirect("clients", true);
            exit;
        }

        // Verificar se existe o registro no banco de dados
        $financial = FinancialService::verifyIdAndClientIdInDatabase($idFinance, $finalIdClient);
        if(!$financial) {
            $_SESSION["flash"] = "Nenhum resultado encontrado!";
            Functions::Redirect("clients", true);
            exit;
        }
        
        // Alterar o status
        FinancialService::alterStatusPaidInDatabase($idFinance, $finalIdClient);
        $_SESSION["success"] = "Status atualizado com sucesso!";
        Functions::Redirect("editClient?id=".$idClient, true);
        exit;

    }

    public function alterStatus() {

        if(isset($_GET["id"]) && empty($_GET["id"])) {
            $_SESSION["flash"] = "Id não enviado!";
            Functions::Redirect("financial", true);
            exit;
        }

        $id = filter_input(INPUT_GET, "id");
        if(strlen($id) != 32) {
            $_SESSION["flash"] = "Id não tem 32 caracteres!";
            Functions::Redirect("financial", true);
            exit;
        }

        $idFinance = Functions::aesDescrypt($id);
        if(empty($idFinance)) {
            $_SESSION["flash"] = "Id vazio!";
            Functions::Redirect("financial", true);
            exit;
        }

        // Verificar se existe o registro no banco de dados
        $financial = FinancialService::verifyIdInDatabase($idFinance);
        if(!$financial) {
            $_SESSION["flash"] = "Nenhum resultado encontrado!";
            Functions::Redirect("financial", true);
            exit;
        }
        
        // Alterar o status
        FinancialService::alterAnotherStatusPaidInDatabase($idFinance);
        $_SESSION["success"] = "Status atualizado com sucesso!";
        Functions::Redirect("financial", true);
        exit;

    }

    public function pdf() {

        if(isset($_GET["payment"]) && empty($_GET["payment"])) {
            $_SESSION["flash"] = "Parâmetro não definido para gerar pdf!";
            Functions::Redirect("financial", true);
            exit;
        }

        $payment = filter_input(INPUT_GET, "payment");
        if($payment !== "pending" && $payment !== "concluded") {
            $_SESSION["flash"] = "Parâmetro só pode ser concluído ou pendente!";
            Functions::Redirect("financial", true);
            exit;
        }

        $data = [];
        if($payment === "pending") {
            $data["paymentsClient"] = FinancialService::getListPaymentsFromStatus(0);
            $data["type"] = "pendentes";
        } else {
            $data["paymentsClient"] = FinancialService::getListPaymentsFromStatus(1);
            $data["type"] = "concluídos";
        }

        // Apresentar a view do client
        Functions::RenderAdmin([
            "pages/pdf"
        ], $data);

    }

    public function sendEmailPaymentPending() {

        if(!isset($_GET["email"]) && empty($_GET["email"])) {
            $_SESSION["flash"] = "Id não enviado!";
            Functions::Redirect("financial", true);
            exit;
        }
        if(!isset($_GET["portion"]) && empty($_GET["portion"])) {
            $_SESSION["flash"] = "Parcela não enviada!";
            Functions::Redirect("financial", true);
            exit;
        }

        $id = filter_input(INPUT_GET, "email");
        if(strlen($id) != 32) {
            $_SESSION["flash"] = "Id não tem 32 caracteres!";
            Functions::Redirect("financial", true);
            exit;
        }

        $idClient = Functions::aesDescrypt($id);
        if(empty($idClient)) {
            $_SESSION["flash"] = "Id vazio!";
            Functions::Redirect("financial", true);
            exit;
        }

        $portion = filter_input(INPUT_GET, "portion");
        if(strlen($portion) != 32) {
            $_SESSION["flash"] = "Id não tem 32 caracteres!";
            Functions::Redirect("financial", true);
            exit;
        }

        $idPortion = Functions::aesDescrypt($portion);
        if(empty($idPortion)) {
            $_SESSION["flash"] = "Parcela está vazia!";
            Functions::Redirect("financial", true);
            exit;
        }

        if(isset($_COOKIE["client_".$idClient])) {
            $_SESSION["flash"] = "Você já enviou um email para este cliente. Aguarde 7 dias para enviar outra cobrança!";
            Functions::Redirect("financial", true);
            exit;
        } else {

            // Pegar as parcelas
            $info = FinancialService::getPortionsFromId($idPortion);
            $client = ClientService::verifyClientExistsInDatabase($idClient);

            $bodyEmail = "Olá $client->name, você está com um saldo pendente de $info->value com vencimento na data $info->expired. Entre em contato conosco para quitar sua parcela!";

            // Enviar o email
            $result = Email::sendEmailFromClientInfoStatusPending($client->email, $bodyEmail);
            if($result) {
                // Setando cookie para n enviar outro email
                setcookie("client_".$idClient, true, time() + (60* 60 * 24 * 7), "/");

                $_SESSION["success"] = "Email enviado com sucesso!";
                Functions::Redirect("financial", true);
                exit;
            } else {
                $_SESSION["flash"] = "Ocorreu um erro ao enviar o email!";
                Functions::Redirect("financial", true);
                exit;
            }

            // echo "<pre>";
            // print_r([$info, $client, $bodyEmail]);

            // setcookie("client_".$idClient, true, time() + (60* 60 * 24 * 7), "/");
        }

    }

}
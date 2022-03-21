<?php
namespace core\controllers\site;

use core\helpers\Functions;
use core\helpers\Email;
use core\services\ConfigServices;
use core\services\ServiceService;
use core\services\SliderService;
use core\services\TestimonialService;

class homeController {

    public function index() {

        $flash = "";
        $error = "";

        if(!empty($_SESSION["success"])) {
            $flash = $_SESSION["success"];
            unset($_SESSION["success"]);
        }

        if(!empty($_SESSION["error"])) {
            $error = $_SESSION["error"];
            unset($_SESSION["error"]);
        }

        $data = [
            "flash" => $flash,
            "error" => $error,
            "about" => ConfigServices::getListConfig(),
            "sliders" => SliderService::getAllSliders(),
            "services" => ServiceService::getAllServices(),
            "testimonials" => TestimonialService::getTestimonials()
        ];

        Functions::Render([
            "partials/header",
            "partials/navbar",
            "pages/home",
            "partials/bottom",
            "partials/footer",
        ], $data);
    }

    public function send() {
        
        // Verificar se o método é POST
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            Functions::Redirect("/");
            exit;
        }

        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        if($email) {

            $newMailer = new Email();
            $result = $newMailer->sendEmail($email);
            if($result) {
                $_SESSION["success"] = "Email enviado com sucesso!";
            } else {
                $_SESSION["error"] = "Ocorreu um erro ao enviar o email!";
            }

            Functions::Redirect("/");
            exit;
        }

    }

    public function contact() {
        Functions::Render([
            "partials/header",
            "partials/navbar",
            "pages/contact",
            "partials/bottom",
            "partials/footer",
        ]);
    }

    public function contactFormSubmit() {

         // Verificar se o método é POST
         if($_SERVER["REQUEST_METHOD"] !== "POST") {
            Functions::Redirect("/");
            exit;
        }

        $name = filter_input(INPUT_POST, "name");
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $phone = filter_input(INPUT_POST, "phone");
        $message = filter_input(INPUT_POST, "message");

        if($name && $email && $phone && $message) {

            $result = Email::sendEmailContactPage($name, $email, $phone, $message);
            if($result) {
                $_SESSION["success"] = "Email enviado com sucesso!";
            } else {
                $_SESSION["error"] = "Ocorreu um erro!";
            }

            Functions::Redirect("/");
            exit;

        } else {
            $_SESSION["error"] = "Prencha todos os campos!";
        }

        Functions::Redirect("/");
        exit;

    }

    public function sendByJavascript() {

        // Verificar se o método é POST
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            Functions::Redirect("/");
            exit;
        }

        $post = json_decode(file_get_contents("php://input"), true);

        $email = $post['email'];
        $data = [];
        
        if($email) {

            $newMailer = new Email();
            $result = $newMailer->sendEmail($email);
            if($result) {
                $data["success"] = true;
            } else {
                $data["error"] = true;
            }

        }

        echo json_encode($data);

    }

}
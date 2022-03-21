<?php

namespace core\controllers\admin;

use core\helpers\Functions;
use core\services\AdminService;

class AuthController {

    public function signIn() {
        
        $flash = '';
        if(!empty($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }

        $data = [ "flash" => $flash ];

        // Aprensentar a página de admin
        Functions::RenderAdmin([
            "pages/signin"
        ], $data);

    }

    public function signInSubmit() {
        
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        if($email && $password) {

            $token = AdminService::validateLoginAdmin($email, $password);
            if($token) {
                $_SESSION['token'] = $token;
                Functions::Redirect("", true);
                exit;
            } else {
                $_SESSION['flash'] = 'Email e/ou senha inválidos!';
                Functions::Redirect("signin", true);
                exit;
            }

        } else {
            $_SESSION['flash'] = 'Preencha todos os campos!';
            Functions::Redirect("signin", true);
            exit;
        }
    }

    public function LogoutAdmin() {
        // Destruindo cookie
        setcookie("token", true, time() - 1, "/");

        // Destruindo a sessão
        unset($_SESSION["token"]);
        Functions::Redirect("admin", true);
        exit;
    }

}
<?php

namespace core\controllers\site;

use core\helpers\Functions;
use core\services\UserSiteService;

class AuthController {

    public function signIn() {

        if(isset($_GET["slug"]) && !empty($_GET["slug"])) {
            $slug = filter_input(INPUT_GET, "slug");
        } else {
            $slug = "";
        }

        $flash = '';
        if(!empty($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }

        $data = [ 
            "flash" => $flash,
            "slug" => $slug
        ];

        // Aprensentar a página de admin
        Functions::Render([
            "pages/signin"
        ], $data);

    }

    public function signInSubmit() {

        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        if($email && $password) {

            $token = UserSiteService::validateLoginSite($email, $password);
            if($token) {
                $_SESSION['userSiteToken'] = $token;

                if(isset($_POST["slug"]) && !empty($_POST["slug"])) {
                    Functions::Redirect("post?slug=".$_POST["slug"]);
                    exit;
                } else {
                    $_SESSION['flash'] = 'Email e/ou senha inválidos!';
                    Functions::Redirect("blog");
                    exit;
                }

            } else {
                $_SESSION['flash'] = 'Email e/ou senha inválidos!';
                Functions::Redirect("signIn");
                exit;
            }

        } else {
            $_SESSION['flash'] = 'Preencha todos os campos!';
            Functions::Redirect("signIn");
            exit;
        }

    }

}
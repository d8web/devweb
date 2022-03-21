<?php

namespace core\services;

use core\helpers\Database;

class AdminService {

    public static function checkAdminLogin() {
        $db = new Database();
        if(!empty($_SESSION["token"])) {
            $token = $_SESSION["token"];
            $params = [ ":token" => $token ];

            $results = $db->select("SELECT * FROM users WHERE token = :token",$params)[0];

            if($results) {
                return $results;
            }

        } elseif(!empty($_COOKIE["token"])) {
            $token = $_COOKIE["token"];
            $params = [ ":token" => $token ];

            $results = $db->select("SELECT * FROM users WHERE token = :token",$params)[0];

            if($results) {
                return $results;
            }
        } else {
            return false;
        }

    }

    /**
     * @param string $email
     * @param string $password
     * @return string
    */
    public static function validateLoginAdmin(string $email, string $password): string {

        // Verificar se o login é válido
        $params = [ ":email" => $email ];

        $db = new Database();
        $results = $db->select("
            SELECT * FROM users WHERE email = :email",
            $params
        );

        if($results[0]) {
            if(password_verify($password, $results[0]->password)) {
                
                $token = md5(time().rand(0,9999));

                $params = [
                    ":token" => $token,
                    ":email" => $email
                ];

                $db->update("
                    UPDATE users SET token = :token WHERE email = :email",
                    $params
                );

                if(isset($_POST["remember"]) && $_POST["remember"] === "on") {
                    setcookie("token", $token, time() + (60 * 60 * 24), "/");
                }

                return $token;
            }
        }

        return false;
    }

}
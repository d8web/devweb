<?php

namespace core\services;

use core\helpers\Database;

class UserSiteService {

    public static function checkLoginSiteUser() {

        $db = new Database();

        if(!empty($_SESSION["userSiteToken"])) {
            $token = $_SESSION["userSiteToken"];
            $params = [ ":token" => $token ];

            $results = $db->select("SELECT * FROM users_site WHERE token = :token",$params)[0];

            if($results) {
                return $results;
            }            
        }
        
        return false;
    }

    public static function validateLoginSite($email, $password) {

        // Verificar se o login é válido
        $params = [ ":email" => $email ];

        $db = new Database();
        $results = $db->select("
            SELECT * FROM users_site WHERE email = :email",
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
                    UPDATE users_site SET token = :token WHERE email = :email",
                    $params
                );

                return $token;
            }
        }

        return false;

    }

    public static function verifyIfUserExists($id) {

        $params = [ ":id" => $id ];

        $db = new Database();
        $result = $db->select("SELECT * FROM users_site WHERE id = :id", $params);

        if($result) {
            return $result;
        }

        return false;

    }

}
<?php

namespace core\services;

use core\helpers\Database;

class SiteService {

    public static function updateUserOn() {
        
        if(isset($_SESSION["online"])) {
            $db = new Database();

            $token = $_SESSION["online"];
            $hour = date("Y-m-d H:i:s");

            $params = [ ":token" => $token ];
            $check = $db->select("SELECT id FROM online WHERE token = :token", $params);

            if(count($check) > 0) {
                $params = [
                    ":lastaction" => $hour,
                    ":token" => $token
                ];
                
                $db->update("UPDATE online SET lastaction = :lastaction WHERE token = :token", $params);
            } else {
                $ip = $_SERVER["REMOTE_ADDR"];
                $token = $_SESSION["online"];
                $hour = date("Y-m-d H:i:s");

                $params = [
                    ":ip" => $ip,
                    ":lastaction" => $hour,
                    ":token" => $token
                ];

                $db = new Database();
                $db->insert("INSERT INTO online VALUES (0, :ip, :lastaction, :token)", $params);
            }

        } else {
            $_SESSION["online"] = uniqid();
            $ip = $_SERVER["REMOTE_ADDR"];
            $token = $_SESSION["online"];
            $hour = date("Y-m-d H:i:s");

            $params = [
                ":ip" => $ip,
                ":lastaction" => $hour,
                ":token" => $token
            ];

            $db = new Database();
            $db->insert("INSERT INTO online VALUES (0, :ip, :lastaction, :token)", $params);
        }

    }

    public static function accountant() {
        if(!isset($_COOKIE["visit"])) {
            setcookie("visit", true, time() + (60 * 60 * 24 * 7));

            $params = [
                ":ip" => $_SERVER["REMOTE_ADDR"],
                ":visitday" => date("Y-m-d")
            ];

            $db = new Database();
            $db->insert("INSERT INTO visits VALUES (0, :ip, :visitday)", $params);
        }
    }

}
<?php

namespace core\services;

use core\helpers\Database;

class VisitsService {

    public static function getTotalAccountantUsers() {
        $db = new Database();
        return $db->select("SELECT * FROM visits");
    }

    public static function getTotalAccountantUsersToday() {
        $params = [ ":visitday" => date("Y-m-d") ];
        
        $db = new Database();
        return $db->select("SELECT * FROM visits WHERE visitday = :visitday", $params);
    }

}
<?php

namespace core\services;

use core\helpers\Database;

class OnlineService {

    public static function getListUsers() {
        self::clearUsersOn();

        $db = new Database();
        return $db->select("SELECT * FROM online");
    }

    public static function clearUsersOn() {
        $date = date("Y-m-d H:i:s");

        $db = new Database();
        return $db->delete("DELETE FROM online WHERE lastaction < '$date' - INTERVAL 1 MINUTE");
    }

}
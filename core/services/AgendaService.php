<?php

namespace core\services;

use core\helpers\Database;

class AgendaService {

    public static function getTodosToday($dayToday) {

        $params = [ ":date" => $dayToday ];

        $db = new Database();
        return $db->select("SELECT * FROM agenda WHERE date = :date ORDER BY id DESC", $params);

    }

    public static function newTodo($todo, $date) {

        $params = [ ":todo" => $todo, ":date" => $date ];

        $db = new Database();
        $db->insert("INSERT INTO agenda VALUES (0, :todo, :date)", $params);

    }

}
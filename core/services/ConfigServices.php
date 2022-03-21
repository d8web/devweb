<?php

namespace core\services;

use core\helpers\Database;

class ConfigServices {

    /**
     * @return object 
    */
    public static function getListConfig(): object {

        $db = new Database();
        $results = $db->select("SELECT * FROM config");
        return $results[0];

    }

    /**
     * @param int $id 
    */
    public static function verifyIdExists($id) {

        $params = [ ":id" => $id ];

        $db = new Database();
        return $db->select("SELECT * FROM config WHERE id = :id", $params)[0];

    }

    /**
     * @param array $updateFields
     * @return void
    */
    public static function updateConfigInDatabase(array $updateFields): void {

        $params = [
            ":id" => $updateFields["id"],
            ":name" => $updateFields["name"],
            ":description" => $updateFields["description"],
            ":image" => $updateFields["image"]
        ];

        $db = new Database();
        $db->update("UPDATE config SET nameAuthor = :name, description = :description, image = :image WHERE id = :id", $params);

    }

}
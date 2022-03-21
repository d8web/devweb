<?php

namespace core\services;

use core\helpers\Database;

class CategoryService {

    /**
     * @return array 
    */
    public static function getAllCategories(): array {

        $db = new Database();
        return $db->select("SELECT * FROM categories");

    }

    /**
     * @param int $id
    */
    public static function getCategoryById(int $id): object | false {

        $params = [ ":id" => $id ];

        $db = new Database();
        $results = $db->select("SELECT * FROM categories WHERE id = :id", $params)[0];

        if($results) {
            return $results;
        }

        return false;

    }

    /**
     * @param int $id
     * @param string $name
     * @return void 
    */
    public static function updateCategory(int $id, string $name):void {

        $params = [
            ":id" => $id,
            ":name" => $name,
        ];

        $db = new Database();
        $db->update("UPDATE categories SET name = :name WHERE id = :id", $params);

    }

    /**
     * @param string $name
     * @return void 
    */
    public static function addCategory(string $name): void {

        $params = [ ":name" => $name ];

        $db = new Database();
        $db->insert("INSERT INTO categories VALUES (0, :name)", $params);

    }

    /**
     * @param int $id
     * @return void 
    */
    public static function deleteCategoryInDatabase(int $id): void {

        $params = [ ":id" => $id ];

        $db = new Database();
        $db->delete("DELETE FROM categories WHERE id = :id", $params);

    }

}
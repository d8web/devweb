<?php

namespace core\services;

use core\helpers\Database;

class PropertyService {

    public static function getListProperties($page) {

        $perPage = 10;
        $startFrom = ($page - 1) * $perPage;

        $db = new Database();
        $result = $db->select("SELECT * FROM properties LIMIT $startFrom, $perPage");

        $res = $db->select("SELECT * FROM properties");

        $total = count($res);
        $pageCount = ceil($total / $perPage);

        return [
            "list" => $result,
            "pageCount" => $pageCount,
            "currentPage" => $page,
            "total" => $total
        ];

    }

    public static function addPropertyInDatabase($fields) {

        $params = [
            ":name"  => $fields["name"],
            ":type"  => $fields["type"],
            ":price" => $fields["price"],
            ":image" => $fields["image"]
        ];

        $db = new Database();
        $db->insert("INSERT INTO properties VALUES (0, :name, :type, :price, :image)", $params);

    }

    public static function updatePropertyInDatabase($fields) {

        $params = [
            "id" => $fields["id"],
            ":name"  => $fields["name"],
            ":type"  => $fields["type"],
            ":price" => $fields["price"],
            ":image" => $fields["image"]
        ];

        $db = new Database();
        $db->update("UPDATE properties SET name = :name, type = :type, price = :price, image = :image WHERE id = :id", $params);

    }

    public static function searchPropertiesInDatabase($search, $page) {

        $perPage = 10;
        $startFrom = ($page - 1) * $perPage;

        $db = new Database();
        $result = $db->select("SELECT * FROM properties WHERE name LIKE '%$search%' LIMIT $startFrom, $perPage");

        $res = $db->select("SELECT * FROM properties WHERE name LIKE '%$search%'");

        $total = count($res);
        $pageCount = ceil($total / $perPage);

        return [
            "list" => $result,
            "pageCount" => $pageCount,
            "currentPage" => $page,
            "total" => $total
        ];

    }

    public static function verifyIfPropertyExistsInDatabase($id) {

        $params = [ ":id" => $id ];

        $db = new Database();
        $result = $db->select("SELECT * FROM properties WHERE id = :id", $params)[0];

        if($result) {
            return $result;
        }

        return false;

    }

    public static function deleteProperty($id) {

        $params = [ ":id" => $id ];
        
        $db = new Database();
        $db->delete("DELETE FROM properties WHERE id = :id", $params);

    }

}
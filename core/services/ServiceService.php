<?php

namespace core\services;

use core\helpers\Database;

class ServiceService {

    public static function getAllServices()  {
        $db = new Database();
        return $db->select("SELECT * FROM services");
    }

    /**
     * @param int $id
     * PHP 8+ multiple returns
    */
    public static function getServiceByIdInDatabase($id): object | false {

        $params = [ ":id" => $id ];

        $db = new Database();
        $results = $db->select("SELECT * FROM services WHERE id = :id", $params)[0];

        if($results) {
            return $results;
        }

        return false;

    }

    /**
     * @param int $id
     * @param string $title
     * @param string $icon
     * @param string $body
     * @return void
    */
    public static function updateService(int $id, string $title, string $icon, string $body): void {

        $params = [
            ":id" => $id,
            ":title" => $title,
            ":icon" => $icon,
            ":body" => $body
        ];

        $db = new Database();
        $db->update("UPDATE services SET title = :title, icon = :icon, body = :body WHERE id = :id", $params);

    }

    /**
     * @param string $title
     * @param string $icon
     * @param string $body
     * @return void 
    */
    public static function addNewService(string $title, string $icon, string $body): void {

        $params = [
            ":title" => $title,
            ":icon" => $icon,
            ":body" => $body
        ];

        $db = new Database();
        $db->insert("INSERT INTO services VALUES (0, :title, :icon, :body)", $params);

    }

    /**
     * @param int $id
     * @return void 
    */
    public static function deleteServiceInDatabase($id): void {

        $params = [ ":id" => $id ];

        $db = new Database();
        $db->delete("DELETE FROM services WHERE id = :id", $params);

    }

}
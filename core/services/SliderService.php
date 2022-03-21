<?php

namespace core\services;

use core\helpers\Database;

class SliderService {

    public static function getAllSliders() {

        $db = new Database();
        return $db->select("SELECT * FROM slides");

    }

    /**
     * @param int $id 
    */
    public static function getSlideByIdInDatabase(int $id): object | false {

        $params = [ ":id" => $id ];

        $db = new Database();
        $results = $db->select("SELECT * FROM slides WHERE id = :id", $params)[0];

        if($results) {
            return $results;
        }

        return false;

    }

    /**
     * @param string $url
     * @return void 
    */
    public static function addNewSlide($url): void {

        $params = [ ":url" => $url ];

        $db = new Database();
        $db->insert("INSERT INTO slides VALUES (0, :url)", $params);

    }

    /**
     * @param string $url
     * @param int $id
     * @return void
    */
    public static function updateSlide(string $url, int $id): void {

        $params = [
            ":id" => $id,
            ":url" => $url
        ];

        $db = new Database();
        $db->update("UPDATE slides SET url = :url WHERE id = :id", $params);

    }

    public static function deleteSlideInDatabase($id) {

        $params = [ ":id" => $id ];

        $db = new Database();
        $db->delete("DELETE FROM slides WHERE id = :id", $params);

    }

}
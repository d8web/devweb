<?php

namespace core\services;

use core\helpers\Database;

class TestimonialService {

    /**
     * @return array 
    */
    public static function getTestimonials(): array {

        $db = new Database();
        return $db->select("SELECT * FROM testimonials");

    }

    /**
     * @param int $id
     * PHP 8+ multiple returns
    */
    public static function getTestimonialByIdInDatabase($id): object | false {

        $params = [ ":id" => $id ];

        $db = new Database();
        $results = $db->select("SELECT * FROM testimonials WHERE id = :id", $params)[0];

        if($results) {
            return $results;
        }

        return false;

    }

    /**
     * @param string $author
     * @param string $body
     * @return void
    */
    public static function addNewTestimonial(string $author, string $body): void {

        $params = [
            ":author" => $author,
            ":body" => $body
        ];

        $db = new Database();
        $db->insert("INSERT INTO testimonials VALUES (0, :author, :body)", $params);

    }

    /**
     * @param int $id
     * @param string $author
     * @param string $body
     * @return void
    */
    public static function updateTestimonial(int $id, string $author, string $body): void {

        $params = [
            ":id" => $id,
            ":author" => $author,
            ":body" => $body
        ];

        $db = new Database();
        $db->update("UPDATE testimonials SET author = :author, body = :body WHERE id = :id", $params);

    }

    /**
     * @param int $id
     * @return void 
    */
    public static function deleteTestimonialInDatabase(int $id): void {

        $params = [ ":id" => $id ];

        $db = new Database();
        $db->delete("DELETE FROM testimonials WHERE id = :id", $params);

    }

}
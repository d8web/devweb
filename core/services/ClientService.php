<?php

namespace core\services;

use core\helpers\Database;

class ClientService {
    
    public static function getAllClientsFromDatabase() {

        $db = new Database();
        return $db->select("SELECT * FROM clients");

    }

    public static function addClientInDatabase($name, $email, $type, $number, $avatarClientName) {

        $params = [
            ":name" => $name,
            ":email" => $email,
            ":type" => $type,
            ":number" => $number,
            ":avatar" => $avatarClientName
        ];

        $db = new Database();
        $db->insert("INSERT INTO clients VALUES (0, :name, :email, :type, :number, :avatar)", $params);

    }

    public static function verifyClientExistsInDatabase(int $id) {

        $params = [ ":id" => $id ];

        $db = new Database();
        $result = $db->select("SELECT * FROM clients WHERE id = :id", $params)[0];

        if($result) {
            return $result;
        }

        return false;

    }

    public static function verifyEmailClientExistsInDatabase(string $email) {

        $params = [ ":email" => $email ];

        $db = new Database();
        $result = $db->select("SELECT * FROM clients WHERE email = :email", $params)[0];

        if($result) {
            return $result;
        }

        return false;

    }

    public static function updateClientInDatabase($id, $name, $email, $type, $number, $avatarClientName) {

        $params = [
            ":id" => $id,
            ":name" => $name,
            ":email" => $email,
            ":type" => $type,
            ":number" => $number,
            ":avatar" => $avatarClientName
        ];

        $db = new Database();
        $db->update("
            UPDATE clients SET
            name = :name,
            email = :email,
            type = :type,
            number = :number,
            avatar = :avatar
            WHERE id = :id",
        $params);

    }

    public static function searchClientsInDatabase(string $search) {

        $db = new Database();
        $results = $db->select("SELECT * FROM clients WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR number LIKE '%$search%'");

        return $results;

    }

    public static function deleteClient($id) {

        $params = [ ":id" => $id ];

        $db = new Database();
        // Deletar os registros do cliente
        $db->delete("DELETE FROM clients WHERE id = :id", $params);

        self::deleteFinancialWhereIdClient($id);

    }

    public static function deleteFinancialWhereIdClient($id) {

        $params = [ ":id" => $id ];

        $db = new Database();

        // Deletar os registros do financeiro
        $db->delete("DELETE FROM financial WHERE clientId = :id", $params);

    }

}
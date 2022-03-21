<?php

namespace core\services;

use core\helpers\Database;

class UserService {

    public static function getListUsers() {

        $db = new Database();
        return $db->select("SELECT * FROM users");

    }

     /**
     * @param string $email
     * @return bool
    */
    public static function emailExists(string $email): bool {
        // Verificar se o email existe no banco de dados
        $db = new Database();
        $params = [ ":email" => strtolower(trim($email)) ];
        $results = $db->select("SELECT email FROM users WHERE email = :email", $params);

        return count($results) != 0 ? true : false;
    }

    /**
     * @param array $updateFields
     * @return void
    */
    public static function updateUserDatabase(array $updateFields): void {

        $params = [
            ":name" => $updateFields["name"],
            ":password" => password_hash($updateFields["password"], PASSWORD_DEFAULT),
            ":avatar" => $updateFields["avatar"],
            ":token" => $updateFields["token"]
        ];

        $db = new Database();
        $db->update("UPDATE users SET name = :name, password = :password, avatar = :avatar WHERE token = :token", $params);
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param int $admin
     * @param string $avatarName
     * @return void
    */
    public static function addnewUserInDatabase(string $name, string $email, string $password, int $admin, string $avatarName): void {

        // echo "$name | $email | $password | $admin | $avatarName";exit;

        $params = [
            ":name" => $name,
            ":email" => $email,
            ":password" => password_hash($password, PASSWORD_DEFAULT),
            ":avatar" => $avatarName,
            ":token" => null,
            ":adminField" => $admin,
        ];

        // print_r($params);exit;

        $db = new Database();
        $db->insert("INSERT INTO users VALUES (0, :name, :email, :password, :avatar, :token, :adminField)", $params);

    }

}
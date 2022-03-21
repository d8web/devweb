<?php

namespace core\services;

use core\helpers\Database;

class HousingService {

    public static function addHousingInDatabase($fields) {

        $params = [
            ":propertyId" => $fields["idProperty"],
            ":name" => $fields["name"],
            ":price" => $fields["price"],
            ":area" => $fields["area"]
        ];

        $db = new Database();
        $res = $db->insert("
            INSERT INTO housing VALUES (
                0,
                :propertyId,
                :name,
                :price,
                :area
            )",$params);

        return $res;

    }

    public static function addImagesFromHousing($housingId, $image) {

        $params = [
            ":housingId" => $housingId,
            ":image" => $image,
        ];

        $db = new Database();
        $db->insert("INSERT INTO housing_images VALUES (0, :housingId, :image)", $params);

    }

    public static function getHousingsFromPropertyId($propertyId) {

        $params = [ ":propertyId" => $propertyId ];

        $db = new Database();
        return $db->select("SELECT * FROM housing WHERE propertyId = :propertyId", $params);

    }

    public static function verifyIfHousingExistsInDatabase($id) {

        $params = [ ":id" => $id ];

        $db = new Database();
        $result = $db->select("SELECT * FROM housing WHERE id = :id", $params)[0];

        if($result) {

            $list = [
                "housing" => $result,
                "images" => self::getImagesFromHousing($result->id)
            ];

            return $list;
            
        }

        return false;

    }

    public static function getImagesFromHousing($id) {

        $params = [ ":housingId" => $id ];

        $db = new Database();
        return $db->select("SELECT id, image FROM housing_images WHERE housingId = :housingId", $params);

    }

    public static function updateSingleHousing($fields) {

        $params = [
            ":id" => $fields["id"],
            ":propertyId" => $fields["propertyId"],
            ":name" => $fields["name"],
            ":price" => $fields["price"],
            ":area" => $fields["area"]
        ];

        $db = new Database();
        $db->update("
            UPDATE housing SET
            name = :name,
            price = :price,
            area = :area
            WHERE id = :id
            AND propertyId = :propertyId",
        $params);

    }

    public static function deleteSingleImage($image, $id) {

        $params = [
            ":housingId" => $id,
            ":image" => $image
        ];

        $db = new Database();
        $db->delete("DELETE FROM housing_images WHERE housingId = :housingId AND image = :image", $params);

    }

    public static function deleteSingleImageByIdAndImage($image, $id) {

        $params = [
            ":id" => $id,
            ":image" => $image
        ];

        $db = new Database();
        $db->delete("DELETE FROM housing_images WHERE id = :id AND image = :image", $params);

    }

    public static function addImageHousing($id, $image) {

        $params = [
            ":housingId" => $id,
            ":image" => $image,
        ];

        $db = new Database();
        $db->insert("INSERT INTO housing_images VALUES (0, :housingId, :image)", $params);


    }

    public static function getHousingsByIdProperty($propertyId) {

        $params = [
            ":propertyId" => $propertyId
        ];

        $db = new Database();
        $housings = $db->select("SELECT * FROM housing WHERE propertyId = :propertyId", $params);

        $list = [];

        if(count($housings) > 0) {
            foreach($housings as $key => $item) {
                $list["housing"] = $item;
                $list["images"] = self::getImagesFromHousing($item->id);
            }
        }

        return $list;

    }

    public static function deleteHousing($id) {

        $params = [ ":id" => $id ];

        $db = new Database();
        $db->delete("DELETE FROM housing WHERE id = :id", $params);

    }

}
<?php

namespace core\services;

use core\helpers\Database;

class ProductService {

    public static function getListProducts($page) {

        $perPage = 10;
        $startFrom = ($page - 1) * $perPage;

        $list = [];

        $db = new Database();
        $result = $db->select("SELECT id, name, price, stock FROM products LIMIT $startFrom, $perPage");

        foreach($result as $key => $product) {
            $params = [ ":productId" => $product->id ];
            $list[] = $product;
            // Corrigir depois este erro, não existe o index 0
            $images = $db->select("SELECT url FROM images WHERE productId = :productId", $params);
            if(count($images) > 0) {
                $list[$key]->image = $images[0]->url;
            } else {
                $list[$key]->image = "default.jpg";
            }

            // Example all images return
            // $list[$key]->images = $db->select("SELECT url FROM images WHERE productId = :productId", $params);
        }

        $res = $db->select("SELECT * FROM products");

        $total = count($res);
        $pageCount = ceil($total / $perPage);

        return [
            "list" => $list,
            "pageCount" => $pageCount,
            "currentPage" => $page,
            "total" => $total
        ];

    }

    public static function addProductInDatabase($fields) {

        $params = [
            ":name" => $fields["name"],
            ":description" => $fields["description"],
            ":price" => $fields["price"],
            ":width" => $fields["width"],
            ":height" => $fields["height"],
            ":length" => $fields["length"],
            ":weight" => $fields["weight"],
            ":stock" => $fields["stock"]
        ];

        $db = new Database();
        $res = $db->insert("
            INSERT INTO products VALUES (
                0,
                :name,
                :description,
                :price,
                :width,
                :height,
                :length,
                :weight,
                :stock
            )",$params);

        return $res;
    }

    public static function updateProductInDatabase($fields) {

        $params = [
            ":id" => $fields["id"],
            ":name" => $fields["name"],
            ":description" => $fields["description"],
            ":price" => $fields["price"],
            ":width" => $fields["width"],
            ":height" => $fields["height"],
            ":length" => $fields["length"],
            ":weight" => $fields["weight"],
            ":stock" => $fields["stock"]
        ];

        $db = new Database();
        $db->update("UPDATE products SET name = :name, description = :description, price = :price, width = :width, height = :height, length = :length, weight = :weight, stock = :stock WHERE id = :id", $params);

    }

    public static function addImageProduct($productId, $url) {

        $params = [
            ":productId" => $productId,
            ":url" => $url,
        ];

        $db = new Database();
        $db->insert("INSERT INTO images VALUES (0, :productId, :url)", $params);

    }

    public static function verifyIfProductExistsInDatabase($id) {

        $params = [ ":id" => $id ];

        $db = new Database();
        $result = $db->select("SELECT * FROM products WHERE id = :id", $params)[0];

        if($result) {
            return $result;
        }

        return false;

    }

    public static function getImagesFromProductById($id) {

        $params = [ ":id" => $id ];
        $db = new Database();
        return $db->select("SELECT url FROM images WHERE productId = :id", $params);

    }

    public static function deleteSingleImage($url) {

        $params = [ ":url" => $url ];

        $db = new Database();
        $db->delete("DELETE FROM images WHERE url = :url", $params);

    }

    public static function searchProductsInDatabase($search, $page) {

        $perPage = 10;
        $startFrom = ($page - 1) * $perPage;

        $list = [];

        $db = new Database();
        $result = $db->select("SELECT id, name, price, stock FROM products WHERE name LIKE '%$search%' OR description LIKE '%$search%' LIMIT $startFrom, $perPage");

        foreach($result as $key => $product) {

            $params = [ ":productId" => $product->id ];
            $list[] = $product;
            // Corrigir depois este erro, não existe o index 0
            $images = $db->select("SELECT url FROM images WHERE productId = :productId", $params);
            if(count($images) > 0) {
                $list[$key]->image = $images[0]->url;
            } else {
                $list[$key]->image = "default.jpg";
            }

        }

        $res = $db->select("SELECT * FROM products WHERE name LIKE '%$search%' OR description LIKE '%$search%'");
        
        $total = count($res);
        $pageCount = ceil($total / $perPage);

        return [
            "list" => $list,
            "pageCount" => $pageCount,
            "currentPage" => $page,
            "total" => $total
        ];

    }

    public static function getAllImagesFromProductId($productId) {

        $params = [ ":productId" => $productId ];
        $db = new Database();

        $res = $db->select("SELECT url FROM images WHERE productId = :productId", $params);

        if($res) {
            return $res;
        }

        return false;

    }

    public static function getProductsEnding() {

        $db = new Database();
        $result = $db->select("SELECT id, name, price, stock FROM products WHERE stock <= 5 AND stock > 0");

        return count($result) > 0 ? true : false;

    }

    public static function getProductsWhereNotStock() {

        $db = new Database();
        $result = $db->select("SELECT id, name, price, stock FROM products WHERE stock = 0");

        return count($result) > 0 ? true : false;

    }

    public static function getListProductFromType($type, $page) {

        $perPage = 10;
        $startFrom = ($page - 1) * $perPage;

        $list = [];

        $db = new Database();
        if($type === "ending") {
            $result = $db->select("SELECT id, name, price, stock FROM products WHERE stock <= 5 LIMIT $startFrom, $perPage");
            $res = $db->select("SELECT * FROM products WHERE stock <= 5");
        } else {
            $result = $db->select("SELECT id, name, price, stock FROM products WHERE stock = 0 LIMIT $startFrom, $perPage");
            $res = $db->select("SELECT * FROM products WHERE stock = 0");
        }

        foreach($result as $key => $product) {

            $params = [ ":productId" => $product->id ];
            $list[] = $product;

            $images = $db->select("SELECT url FROM images WHERE productId = :productId", $params);
            if(count($images) > 0) {
                $list[$key]->image = $images[0]->url;
            } else {
                $list[$key]->image = "default.jpg";
            }

        }

        $total = count($res);
        $pageCount = ceil($total / $perPage);

        return [
            "list" => $list,
            "pageCount" => $pageCount,
            "currentPage" => $page
        ];

    }

    public static function deleteProduct($id) {

        $params = [ ":id" => $id ];
        $db = new Database();
        $db->delete("DELETE FROM products WHERE id = :id", $params);

        self::deleteImagesFromProductId($id);

    }

    public static function deleteImagesFromProductId($productId) {

        $params = [ ":productId" => $productId ];
        $db = new Database();
        $db->delete("DELETE FROM images WHERE productId = :productId", $params);

    }

}
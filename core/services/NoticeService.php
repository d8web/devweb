<?php

namespace core\services;

use core\helpers\Database;
use LDAP\Result;

class NoticeService {

    /**
     * @return array 
    */
    public static function getAllNotices(int | bool $categoryId = false, int $page): array {

        $perPage = 6;
        $startFrom = ($page - 1) * $perPage;
        
        $db = new Database();

        if(!$categoryId) {
            $result = $db->select("
                SELECT categories.name as categoryName, users.name as userName, notices.*
                FROM categories, users, notices
                WHERE categories.id = notices.categoryId
                AND users.id = notices.authorId
                ORDER BY created_at DESC
                LIMIT $startFrom, $perPage
            ");
            $res = $db->select("SELECT * FROM notices");
        } else {
            $result = $db->select("
                SELECT categories.name as categoryName, users.name as userName, notices.*
                FROM categories, users, notices
                WHERE categories.id = notices.categoryId
                AND users.id = notices.authorId
                AND notices.categoryId = $categoryId
                ORDER BY created_at DESC
                LIMIT $startFrom, $perPage
            ");

            $params = [ ":categoryId" => $categoryId ];
            $res = $db->select("SELECT * FROM notices WHERE categoryId = :categoryId", $params);
        }

        $total = count($res);
        $pageCount = ceil($total / $perPage);

        return [
            "posts" => $result,
            "pageCount" => $pageCount,
            "currentPage" => $page
        ];

    }

    public static function getAllNoticesFromAdmin() {

        $db = new Database();

        return $db->select("
            SELECT categories.name as categoryName, users.name as userName, notices.*
            FROM categories, users, notices
            WHERE categories.id = notices.categoryId
            AND users.id = notices.authorId
            ORDER BY created_at DESC
        ");

    }

    public static function getNoticeFromSearchTerm(string $searchTerm, $page) {

        $perPage = 6;
        $startFrom = ($page - 1) * $perPage;

        $db = new Database();

        $result = $db->select("
            SELECT categories.name as categoryName, users.name as userName, notices.*
            FROM categories, users, notices
            WHERE notices.title LIKE '%$searchTerm%'
            AND categories.id = notices.categoryId
            AND users.id = notices.authorId
            ORDER BY created_at DESC
            LIMIT $startFrom, $perPage
        ");

        $res = $db->select("SELECT * FROM notices WHERE title LIKE '%$searchTerm%'");
        
        $total = count($res);
        $pageCount = ceil($total / $perPage);

        return [
            "posts" => $result,
            "pageCount" => $pageCount,
            "currentPage" => $page
        ];

    }

    // /**
    //  * @param int $id 
    // */
    // public static function getAuthorInfo(int $id) {

    //     $params = [ ":id" => $id ];

    //     $db = new Database();
    //     return $db->select("SELECT * FROM users WHERE id = :id", $params)[0];

    // }

    // public static function getCategoryName($id) {

    //     $params = [ ":id" => $id ];

    //     $db = new Database();
    //     return $db->select("SELECT name FROM categories WHERE id = :id", $params)[0];

    // }

    /**
     * @param array $fields
     * @return void 
    */
    public static function addNewNoticeInDatabase($fields): void {

        // echo "<pre>";
        // print_r($fields);die();

        $params = [
            ":categoryId" => $fields["categoryId"],
            ":thumbnail" => $fields["thumbnail"],
            ":title" => $fields["title"],
            ":slug" => $fields["slug"],
            ":body" => $fields["body"],
            ":authorId" => $fields["authorId"]
        ];

        $db = new Database();
        $db->insert("INSERT INTO notices VALUES (0, :categoryId, :thumbnail, :title, :slug, :body, :authorId, NOW())", $params);

    }

    /**
     * @param string $slug
    */
    public static function getNoticeBySlug(string $slug): array | false {

        $params = [ ":slug" => $slug ];

        $db = new Database();
        $result = $db->select("
            SELECT categories.name as categoryName, users.name as userName, notices.*
            FROM categories, users, notices
            WHERE notices.slug = :slug
            AND categories.id = notices.categoryId
            AND users.id = notices.authorId
        ", $params)[0];

        if($result) {

            $params = [ ":noticeId" => $result->id ];
            $post = $result;

            $comments = $db->select("
                SELECT users_site.avatar as userAvatar, users_site.name as userName, notice_comments.*
                FROM users_site, notice_comments
                WHERE noticeId = :noticeId",
            $params);

            $list = [
                "item" => $post,
                "comments" => $comments
            ];
            
            return $list;
        }

        return false;

    }

    /**
     * @param int $id
    */
    public static function verifyIdExistsInDatabase($id): object | false {

        $params = [ ":id" => $id ];

        $db = new Database();
        $result = $db->select("SELECT id, title, body FROM notices WHERE id = :id", $params)[0];

        if($result) {
            return $result;
        }

        return false;

    }

    /**
     * @param int $id
    */
    public static function verifyIfPostIsLoggedUserAdmin($id, $authorId): object | false {

        $params = [
            ":id" => $id,
            ":authorId" => $authorId
        ];

        $db = new Database();
        $result = $db->select("SELECT * FROM notices WHERE id = :id AND authorId = :authorId", $params)[0];

        if($result) {
            return $result;
        }

        return false;

    }

    /**
     * @param int $title
     * @return bool
    */
    public static function verifyTitleExistsInDatabase($title): bool {

        $params = [ ":title" => $title ];

        $db = new Database();
        $result = $db->select("SELECT title FROM notices WHERE title = :title", $params)[0];


        return $result ? true : false;

    }

    /**
     * @param int $id
     * @param string $title
     * @param string $slug
     * @param string $body
     * @return void
    */
    public static function updateTitleAndBody(int $id, string $title, string $body, string $slug): void {

        $params = [
            ":id" => $id,
            ":title" => $title,
            ":slug" => $slug,
            ":body" => $body
        ];

        $db = new Database();
        $db->update("UPDATE notices SET title = :title, slug = :slug, body = :body WHERE id = :id", $params);

    }

    public static function updateThumbAndCategory(string $thumbnailName, int $category, int $id): void {

        $params = [
            ":id" => $id,
            ":categoryId" => $category,
            ":thumbnail" => $thumbnailName
        ];

        $db = new Database();
        $db->update("UPDATE notices SET categoryId = :categoryId, thumbnail = :thumbnail WHERE id = :id", $params);

    }

    /**
     * @param int $id
     * @return void 
    */
    public static function deletePost(int $id): void {

        $params = [
            ":id" => $id
        ];

        $db = new Database();
        $db->delete("DELETE FROM notices WHERE id = :id", $params);

    }

}
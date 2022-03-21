<?php

namespace core\controllers\site;

use core\helpers\Functions;
use core\services\CategoryService;
use core\services\CommentService;
use core\services\ConfigServices;
use core\services\NoticeService;
use core\services\UserSiteService;

class BlogController {

    private $loggedUserSite;

    public function __construct() {
        $this->loggedUserSite = UserSiteService::checkLoginSiteUser();
    }

    public function blog() {

        $data = [];

        if(isset($_GET["page"]) && !empty($_GET["page"])) {
            $page = intval(filter_input(INPUT_GET, 'page'));
        } else {
            $page = 1;
        }
        
        if(isset($_GET["category"]) && !empty($_GET["category"])) {

            if(strlen($_GET["category"]) != 32) {
                Functions::Redirect("blog");
                exit;
            }

            $category = Functions::aesDescrypt($_GET["category"]);
            if(empty($category)) {
                Functions::Redirect("notices");
                exit;
            }

            $category = CategoryService::getCategoryById($category);
            if(!$category) {
                Functions::Redirect("notices");
                exit;
            }

            $data["posts"] = NoticeService::getAllNotices($category->id, $page);
            $data["categories"] = CategoryService::getAllCategories();
            $data["info"] = ConfigServices::getListConfig();
            $data["categorySelected"] = $category->name;
            $data["categoryUrl"] = true;
            $data["searchTerm"] = false;
            $data["blog"] = false;

            Functions::Render([
                "partials/header",
                "partials/navbar",
                "pages/blog",
                "partials/bottom",
                "partials/footer",
            ], $data);
            exit;
            
        }

        $category = false;

        $data = [
            "posts" => NoticeService::getAllNotices($category, $page),
            "categories" => CategoryService::getAllCategories(),
            "info" => ConfigServices::getListConfig(),
            "categorySelected" => "",
            "categoryUrl" => false,
            "searchTerm" => false,
            "blog" => true
        ];

        if(isset($_GET["search"]) && !empty($_GET["search"])) {
            $search = filter_input(INPUT_GET, "search");

            $data["posts"] = NoticeService::getNoticeFromSearchTerm($search, $page);
            $data["categoryUrl"] = false;
            $data["searchTerm"] = true;
            $data["blog"] = false;
            $data["search"] = $search;

            Functions::Render([
                "partials/header",
                "partials/navbar",
                "pages/blog",
                "partials/bottom",
                "partials/footer",
            ], $data);
            exit;
        }

        // echo "<pre>";
        // print_r($data["posts"]);exit;

        Functions::Render([
            "partials/header",
            "partials/navbar",
            "pages/blog",
            "partials/bottom",
            "partials/footer",
        ], $data);
        
    }

    public function singlePost() {

        if(!isset($_GET["slug"])) {
            Functions::Redirect("blog");
            exit;
        }

        // Verificar se o post existe com o slug
        $slug = $_GET["slug"];
        $post = NoticeService::getNoticeBySlug($slug);

        if(!$post) {
            Functions::Redirect("blog");
            exit;
        }

        $data = [
            "post" => $post["item"],
            "comments" => $post["comments"],
            "isLogged" => $this->loggedUserSite
        ];

        Functions::Render([
            "partials/header",
            "partials/navbar",
            "pages/post",
            "partials/bottom",
            "partials/footer",
        ], $data);

    }

    public function contact() {
        Functions::Render([
            "partials/header",
            "partials/navbar",
            "pages/contact",
            "partials/bottom",
            "partials/footer",
        ]);
    }

    public function newComment() {

        $data = [];

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $data["error"] = true;
            $data["message"] = "Método não permitido!";
            return;
        }

        $post = json_decode(file_get_contents("php://input"), true);

        $userId = $post["userId"];
        $noticeId = $post["noticeId"];
        $comment = $post["comment"];

        if(strlen($userId) != 32 && strlen($noticeId) != 32) {
            $data["error"] = true;
            $data["message"] = "Id do post e/ou id do usuário precisam ter 32 caracteres!";
            echo json_encode($data);
            exit;
        }

        $idUser = Functions::aesDescrypt($userId);
        $idNotice = Functions::aesDescrypt($noticeId);
        if(empty($idUser) || empty($idNotice)) {
            $data["error"] = true;
            $data["message"] = "Id do post e/ou id do usuário estão vazios!";
            echo json_encode($data);
            exit;
        }

        // Verificar se o post e se o usuário existe
        $userExists = UserSiteService::verifyIfUserExists($idUser);
        if(!$userExists) {
            $data["error"] = true;
            $data["message"] = "Usuário não existe, não pode comentar!";
            echo json_encode($data);
            exit;
        }

        $postExists = NoticeService::verifyIdExistsInDatabase($idNotice);
        if(!$postExists) {
            $data["error"] = true;
            $data["message"] = "Post não existe, não pode comentar!";
            echo json_encode($data);
            exit;
        }

        $fields = [
            "userId" => $idUser,
            "noticeId" => $idNotice,
            "comment" => $comment
        ];

        CommentService::addCommentInDatabase($fields);
        $data["success"] = true;

        echo json_encode($data);

    }

}
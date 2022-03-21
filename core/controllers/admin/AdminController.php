<?php

namespace core\controllers\admin;

use core\helpers\Functions;
use core\services\AdminService;
use core\services\OnlineService;
use core\services\UserService;
use core\services\VisitsService;

class AdminController {

    private $loggedAdmin;
    private $permission;

    public function __construct() {
        $this->loggedAdmin = AdminService::checkAdminLogin();
        if($this->loggedAdmin === false) {
            Functions::Redirect("signin", true);
        } else {
            $this->permission = Functions::verifyPermission($this->loggedAdmin->adminField);
        }
    }

    public function index() {

        $data = [
            "activeMenu" => "home",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,
            
            "listUsersOnline" => OnlineService::getListUsers(),
            "usersList" => UserService::getListUsers(),
            "totalAccountantUsersVisits" => VisitsService::getTotalAccountantUsers(),
            "totalAccountantUsersVisitsToday" => VisitsService::getTotalAccountantUsersToday(),
        ];

        // Apresentar a view do admin
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/home",
            "partials/footer",
        ], $data);

    }

    public function sliders() {

        $data = [
            "activeMenu" => "sliders",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission
        ];

        // Apresentar a view do admin
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/sliders",
            "partials/footer",
        ], $data);
    }


}
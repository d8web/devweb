<?php

namespace core\controllers\admin;

use core\helpers\Functions;
use core\services\AdminService;
use core\services\AgendaService;

class CalendarController {

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

        $flash = "";
        $success = "";

        if(!empty($_SESSION["flash"])) {
            $flash = $_SESSION["flash"];
            unset($_SESSION["flash"]);
        }

        if(!empty($_SESSION["success"])) {
            $success = $_SESSION["success"];
            unset($_SESSION["success"]);
        }

        $month = isset($_GET["month"]) ? intval(filter_input(INPUT_GET, "month")) : date("m", time());
        $year = isset($_GET["year"]) ? intval(filter_input(INPUT_GET, "year")) : date("Y", time());

        // $month = intval(date("m", time()));
        // $year = intval(date("Y", time()));

        if($month > 12) {
            $month = 12;
        }

        if($month < 1) {
            $month = 1;
        }

        // if($month < 10) {
        //     $month = str_pad($month, strlen($month) + 1, "0", STR_PAD_LEFT);
        // }

        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $dayOneFromMonth = date("N", strtotime("$year-$month-01"));

        $dayToday = date("d", time());
        $today = "$year-$month-$dayToday";

        $monthList = [
            "Janeiro",
            "Fevereiro",
            "Março",
            "Abril",
            "Maio",
            "Junho",
            "Julho",
            "Agosto",
            "Setembro",
            "Outubro",
            "Novembro",
            "Dezembro"
        ];

        $data = [
            "activeMenu" => "calendar",
            "loggedAdmin" => $this->loggedAdmin,
            "permission" => $this->permission,

            "flash" => $flash,
            "success" => $success,

            "year" => $year,
            "month" => $month,
            "numberOfDays" => $numberOfDays,
            "dayOneFromMonth" => $dayOneFromMonth,
            "today" => $today,
            "monthList" => $monthList,
            "todosToday" => AgendaService::getTodosToday($today)
        ];

        // Apresentar a view do blog
        Functions::RenderAdmin([
            "partials/header",
            "partials/main",
            "partials/aside",
            "pages/calendar",
            "partials/footer",
        ], $data);

    }

    public function getTodosByDate() {

        $data = [];

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $data["error"] = true;
            return;
        }

        $post = json_decode(file_get_contents("php://input"), true);

        $data["error"] = false;
        $data["todos"] = AgendaService::getTodosToday($post["dateNotFormated"]);
        
        echo json_encode($data);

    }

    public function newTodo() {

        $data = [];

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            $data["error"] = true;
            $data["message"] = "Método não permitido!";
            return;
        }

        $post = json_decode(file_get_contents("php://input"), true);

        $todo = $post["todo"];
        $date = $post["date"];

        if(!strtotime($date)) {
            $data["error"] = true;
            $data["message"] = "Data inválida!";
            echo json_encode($data);
            exit;
        }

        $currentDate = date("Y-m-d");
        if(strtotime($date) < strtotime($currentDate)) {
            $data["error"] = true;
            $data["message"] = "Você não pode adicionar tarefas a datas inferiores a hoje!";
            echo json_encode($data);
            exit;
        }

        AgendaService::newTodo($todo, $date);
        $data["error"] = false;
        
        echo json_encode($data);

    }

}
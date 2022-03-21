<?php

session_start();

require_once("../vendor/autoload.php");

use core\services\SiteService;
SiteService::accountant();
SiteService::updateUserOn();

require_once("../core/routes.php");
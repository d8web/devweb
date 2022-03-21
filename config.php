<?php

date_default_timezone_set("America/Sao_Paulo");

define("APP_NAME",          "Dev LP");
define("APP_VERSION",       "1.0.0");
define("BASE_URL",          "http://localhost/devweb/public/");

// MYSQL DADOS
define("MYSQL_SERVER",      "localhost");
define("MYSQL_DATABASE",    "system_web");
define("MYSQL_USER",        "root");
define("MYSQL_PASS",        "");
define("MYSQL_CHARSET",     "utf8");

// AES ENCRIPT
define("AES_KEY",           "muf4YDYMw3KeNv7rFkLFRJhkRwapBDVF");
define("AES_IV",            "NjWA3sg3vyk6yVk2");

// EMAIL
define("EMAIL_HOST",        "smtp.gmail.com");
define("EMAIL_FROM",        "");
define("EMAIL_PASS",        "");
define("EMAIL_PORT",        00);

define("PERMISSIONS",       [ 0 => "normal", 1 => "sub adminstrador", 2 => "adminstrador" ]);
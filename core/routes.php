<?php

// Array de rotas
$routes = [
    "home" => "homeController@index",
    "send" => "homeController@send",
    "sendByJs" => "homeController@sendByJavascript",

    "signIn" => "authController@signIn",
    "clientSignInSubmit" => "authController@signInSubmit",
    
    // Blog
    "blog" => "blogController@blog",
    "post" => "blogController@singlePost",
    // Adicionar comentário ao post
    "newComment" => "blogController@newComment",

    "contact" => "homeController@contact",
    "contactFormSubmit" => "homeController@contactFormSubmit",
];

// Action padrão
$action = "home";

// Verificar se existe uma action na query string
if(isset($_GET["url"])) {
    // Verificar se existe a action no array de rotas
    if(!key_exists($_GET["url"], $routes)) {
        $action = "home";
    } else {
        $action = $_GET["url"];
    }
}

// Definindo as rotas
$parts = explode("@", $routes[$action]);
$controller = "core\\controllers\\site\\".ucfirst($parts[0]);
$method = $parts[1];

$ctr = new $controller();
$ctr->$method();
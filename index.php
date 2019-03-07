<?php

ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

spl_autoload_register(function ($class) {
    $class = str_replace('\\',DIRECTORY_SEPARATOR,$class).'.php';
    require_once __DIR__ . DIRECTORY_SEPARATOR . $class;
});

define("DB_HOST",'127.0.0.1');
define("DB_NAME",'nastop');
define("DB_USER",'root');
define("DB_pass",'');

$GLOBALS["PDO"] = new PDO("mysql:host=".DB_HOST.":3306;dbname=".DB_NAME,DB_USER);

session_start();

$fileNotFound = false;

$controllerName = isset($_GET['target']) ? $_GET['target'] : 'base';
$methodName = isset($_GET['action']) ? $_GET['action'] : 'index';

$controllerClassName = '\\controller\\' . ucfirst($controllerName) . 'Controller';

if(class_exists($controllerClassName)) {
    $controller = new $controllerClassName();
    if (method_exists($controller,$methodName)) {
        if (!($controllerName) == "user" && in_array($methodName, array("login", "register"))) {
            if (!isset($_SESSION["username"])) {
                header("HTTP/1.1 401 Unauthorized");
                die();
            }
        }
        try {
            $controller->$methodName();
        } catch (\Exception $e) {
            header("HTTP/1.1 500");
            echo $e->getMessage();
            die();
        }
    }
    else {
        $fileNotFound = true;
    }
}
else{
    $fileNotFound = true;
}

if($fileNotFound){
    require "view/pageNotFound.html";
}

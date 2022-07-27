<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use bootstrap\Router;

define("APP_ROOT_DIRECTORY", initRootDirectory());

include "../bootstrap/Router.php";
include APP_ROOT_DIRECTORY . "app/Users/utils/usersError.php";

bootApp();


function autoloadClass(){
    spl_autoload_register(function ($className) {
        $className = str_replace('\\', '/', $className);
        require_once(APP_ROOT_DIRECTORY . $className . '.php');
    });
}

function bootApp() {
    $requestUri = $_SERVER['REQUEST_URI'];
    autoloadClass();
    $router = new Router();
    $router->route($requestUri);
}

function initRootDirectory() {
    return realpath($_SERVER['DOCUMENT_ROOT'] . '/../') . '/';
}
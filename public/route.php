<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$segments = explode('/', trim($uri, '/'));

$file = "";

if (count($segments) == 1)
    switch ($uri) {
        case '/':
            $file = 'login.php';
            break;
        case '/login':
            $file = 'login.php';
            break;
        case '/register':
            $file = 'signup.php';
            break;
        case '/users':
            $file = 'table/table.php';
            break;
        case '/profile':
            $file = 'profile.php';
            break;
    }

if (count($segments) > 1) {

    $uriPage = $segments[0];
    switch ($uriPage) {
        case 'login':
            $file = 'login.php';
            break;
        case 'register':
            $file = 'signup.php';
            break;
        case 'users':
            $file = 'table/table.php';
            break;
        case 'profile':
            $file = 'profile.php';
            break;
    }
}


if ($file != "") {
    require_once "$root/src/page/$file";
} else {
    require_once "$root/src/page/404.html";
}


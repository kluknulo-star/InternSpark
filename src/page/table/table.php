<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once "$root/classes/Entity/UserRecord.php";
require_once "$root/src/constant/tableActionAlert.php";
require_once "$root/includes/session/session.php";
require_once "$root/classes/Helper/UserHelper.php";



if (empty($_SESSION) || !isset($_SESSION["uid"])) {
    $_SESSION["error"] = "session_not_found";
    header("location: /login");
    exit();
}

$userInSystem = UserHelper::findUser($_SESSION["uid"]);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!--     JavaScript Bundle with Popper -->

    <!-- Подключаем необходимые файлы для работы Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <!-- JS Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
            crossorigin="anonymous"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/e9d088fdef.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="container-fluid">

    <!--    Alert window-->
    <?php
    if (isset($_SESSION["error"]) && isset(ALL_TABLE_ARRAY[$_SESSION["error"]])) { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><?php echo ALL_TABLE_ARRAY[$_SESSION["error"]] ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
        $_SESSION["error"] = "";
    } elseif (isset($_SESSION["success"]) && isset(ALL_TABLE_ARRAY[$_SESSION["success"]])) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><?php echo ALL_TABLE_ARRAY[$_SESSION["success"]] ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
        unset($_SESSION["success"]);
    }
    ?>
    <!--    Alert window-->

    <form class="container-fluid">
        <span class="navbar-text ">
            User in system <b>Name:</b> <?php echo " " . $userInSystem->getNameFirst() . " " ?>  <b>Type_user:</b> <?php echo " " . $userInSystem->getRole() . " " ?>
        </span>

        <a href="../../../includes/logoutInclude.php" class="btn btn-danger">LOGOUT</a>
        <a href="/profile" class="btn btn-primary">Profile</a>
    </form>

    <?php
    if ($userInSystem->getRole() == "admin") {
        require_once "$root/src/page/table/adminTable.php";
    } else {
        require_once "$root/src/page/table/userTable.php";
    }

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $segments = explode('/', trim($uri, '/'));

    if (count($segments) > 1) {
        require_once "$root/src/page/table/restTable.php";
    }
    ?>




</div>
</body>
</html>
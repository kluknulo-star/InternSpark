<?php
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once "$root/includes/session/session.php";
?>

<!doctype html>
<html>
<head>
    <title>Регистрация и авторизация пользователей</title>
    <!-- Подключаем необходимые файлы для работы Bootstrap 4 -->
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />
    <link rel="stylesheet" href="styles/homepage.css">

    <!-- jQuery -->
    <script src="https://yastatic.net/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://yastatic.net/jquery/3.3.1/jquery.min.js"></script>
    <!-- JS Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</head>
<body>


    <?php
    if (empty($_SESSION["uid"]))
    {
        header('location: /InternSpark/src/page/login.php');
    }
    else{
        header("location: /InternSpark/src/page/table.php");
    }

    ?>



</body>
</html>
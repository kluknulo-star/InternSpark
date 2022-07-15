<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/includes/profileInclude.php";
require_once "$root/includes/session/session.php";
require_once "$root/classes/Helper/UserHelper.php";

if (empty($_SESSION) || !isset($_SESSION["uid"])) {
    $_SESSION["error"] = "session_not_found";
    header("location: /InternSpark/src/page/login.php");
    exit();
}

$userInSystem = UserHelper::findUser($_SESSION["uid"]);

if (isset($_SESSION["error"])){
    var_dump($_SESSION["error"]);
    unset($_SESSION["error"]);
}

$source = "image/";
if ($userInSystem->getAvatar() != "" && file_exists($source . $userInSystem->getAvatar()))
{
    $source .= $userInSystem->getAvatar();
} else{
    $source .= "default.svg";
}


?>


<!doctype html>
<html>
<head>
    <title>Profile</title>

    <!-- Подключаем необходимые файлы для работы Bootstrap 5 -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet"
          crossorigin="anonymous">
    <link href="../../styles/profile.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- JS Bootstrap 5 -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>

    <!-- jQuery -->
    <!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<body>
<div class="container d-flex justify-content-center mt-5">

    <form method="post" enctype="multipart/form-data">

        <div class="card">

            <div class="top-container">
                <div class="ml-3" align="center">

                    <div class="form-group">
                            <img src="<?php echo $source ?>" alt="Avatar" class="img-fluid my-3"
                                 style="width: 150px; "/>
                    </div>

                    <div class="form-group">
                        <input type="file" id="fileToUpload" name="fileToUpload">
                    </div>
                    <div class="form-group">
                        <small>Имя</small>
                        <input type="text" class="form-control" name="firstName"
                               value="<?php echo $userInSystem->getNameFirst() ?>">
                    </div>

                    <div class="form-group">
                        <small>Почта</small>
                        <input type="email" class="form-control" name="email" aria-describedby="emailHelp"
                               value="<?php echo $userInSystem->getEmail() ?>">
                    </div>
                    <div class="form-group">
                        <small>Пароль</small>
                        <input type="password" class="form-control" name="pwd">
                    </div>
                    <div class="form-group">
                        <small>Повторите пароль</small>
                        <input type="password" class="form-control" name="pwdRepeat">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="updateMyself">Обновить данные профиля
                        </button>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger" name="deleteMyselfAvatar">Удалить аватарку
                        </button>
                    </div>
                    <div class="form-group">
                        <a href="login.php" class="btn btn-light" name="table">Таблица</a>
                    </div>
                </div>
            </div>

        </div>

    </form>

</div>

</body>
</html>
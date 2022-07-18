<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/includes/profileInclude.php";
require_once "$root/includes/session/session.php";
require_once "$root/classes/Helper/UserHelper.php";
require_once "$root/src/constant/tableActionAlert.php";

if (empty($_SESSION) || !isset($_SESSION["uid"])) {
    $_SESSION["error"] = "session_not_found";
    header("location: /login");
    exit();
}

$userInSystem = UserHelper::findUser($_SESSION["uid"]);

$source = "/src/page/image/";
$root_source = "$root/src/page/image/";

if ($userInSystem->getAvatar() != "" && file_exists($root_source . $userInSystem->getAvatar()))
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
    <link href="../styles/profile.css" rel="stylesheet">
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

</head>
<body>
<!--    Alert window-->
<?php
if (isset($_SESSION["error"]) && isset(ALL_TABLE_ARRAY[$_SESSION["error"]])) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><?php echo ALL_TABLE_ARRAY[$_SESSION["error"]] ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
    $_SESSION["error"] = "";
} elseif (isset($_SESSION["success"])) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><?php echo$_SESSION["success"] ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
    unset($_SESSION["success"]);
}
?>
<!--    Alert window-->
<div class="container d-flex justify-content-center mt-5">



    <form method="post" enctype="multipart/form-data">

        <div class="card">

            <div class="top-container">
                <div class="ml-3" align="center">

                    <div class="form-group">
                            <img src="<?php echo $source ?>" alt="Avatar" class="img-fluid my-3"
                                 style="width: 220px; "/>
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
                    <?php if ($userInSystem->getAvatar()) { ?>
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger" name="deleteMyselfAvatar">Удалить аватарку
                        </button>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                        <a href="login" class="btn btn-light" name="table">Таблица</a>
                    </div>
                </div>
            </div>

        </div>

    </form>

</div>

</body>
</html>
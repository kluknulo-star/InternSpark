<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/src/constant/verificationError.php";
require_once "$root/includes/session/session.php";
?>

<!doctype html>
<html>
<head>
    <title>Регистрация и авторизация пользователей</title>

    <!-- Подключаем необходимые файлы для работы Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <!-- JS Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
            crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://yastatic.net/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://yastatic.net/jquery/3.3.1/jquery.min.js"></script>

</head>
<body>
<br>
<?php


if (isset($_SESSION["uid"]) ) {
        header("location: /users");
        exit();
} else {
    ?>

    <div align="center">
        <a href="login" class="btn btn-success">Вход</a>
        <a href="register" class="btn btn-light">Регистрация</a>
    </div>

    <?php
}
?>
<br>


<div class="container-fluid container-lg">
    <section>
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">

                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">

<!--                            Alert Error-->
                        <?php
                        if (isset($_SESSION["error"]) && isset(ALL_VERIFICATION_ARRAY[$_SESSION["error"]])) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong><?php echo ALL_VERIFICATION_ARRAY[$_SESSION["error"]] ?></strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                            </div>
                            <?php
                            unset($_SESSION["error"]);
                        } ?>
<!--                            Alert Error-->

<!--                            Card view-->
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Войти в аккаунт</h2>

                                <form action="../../includes/loginInclude.php" method="post">

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form3Example3cg">Email или имя</label>
                                        <input type="text" name="uid_login" class="form-control form-control-lg"
                                               value="<?php
                                               if (isset($_SESSION["try_login_uid"])) {
                                                   echo $_SESSION["try_login_uid"];
                                               }
                                               ?>"/>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="form3Example4cg">Пароль</label>
                                        <input type="password" name="pwd_login"
                                               class="form-control form-control-lg"/>
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <button type="submit" name="submit"
                                                class="btn btn-success btn-block btn-lg">Войти
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>
<!--                            Card view-->
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>


</body>
</html>
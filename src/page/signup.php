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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <!-- JS Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>


    <!-- jQuery -->
    <script src="https://yastatic.net/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://yastatic.net/jquery/3.3.1/jquery.min.js"></script>
    <!-- JS Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</head>
<body>

<br>
<?php
if (isset($_SESSION["uid"]))
{
    header("location: /InternSpark/src/page/table/table.php");
    exit();
}
else
{
    ?>

    <div align="center">
        <a href="login.php" class="btn btn-light">Вход</a>
        <a href="signup.php" class="btn btn-success">Регистрация</a>
    </div>

    <?php
}
?>
<br>

<main>
    <div class="container-fluid container-lg">

        <section>
            <div class="mask d-flex align-items-center h-100 gradient-custom-3">
                <div class="container h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-12 col-md-9 col-lg-7 col-xl-6">

<!--                            Alert Error-->
                            <?php
                            if (isset($_SESSION["error"]) && isset(ALL_VERIFICATION_ARRAY[$_SESSION["error"]])) {?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong><?php echo ALL_VERIFICATION_ARRAY[$_SESSION["error"]]?></strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php
                                unset($_SESSION["error"]);
                            } ?>
<!--                            Alert Error-->

<!--                            Card SignUp-->
                            <div class="card" style="border-radius: 15px;">
                                <div class="card-body p-5">
                                    <h2 class="text-uppercase text-center mb-5">Создать аккаунт</h2>

                                    <form action="../../includes/signupInclude.php" method="post">

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form3Example1cg">Имя</label>
                                            <input type="text" name="uid" class="form-control form-control-lg"
                                             value= "<?php
                                             if (isset($_SESSION["try_signup_name_first"]))
                                             {
                                                 echo $_SESSION["try_signup_name_first"];
                                             }
                                             ?>"
                                             />

                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form3Example3cg">Email</label>
                                            <input type="email" name="email" class="form-control form-control-lg"
                                                value="<?php
                                                if (isset($_SESSION["try_signup_email"]))
                                                {
                                                    echo $_SESSION["try_signup_email"];
                                                }
                                                ?>"
                                            />
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form3Example4cg">Пароль</label>
                                            <input type="password" name="pwd" class="form-control form-control-lg" />
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form3Example4cdg">Повторите пароль</label>
                                            <input type="password" name="pwdRepeat" class="form-control form-control-lg" />
                                        </div>


                                        <div class="d-flex justify-content-center">
                                            <button type="submit" name="submit"
                                                    class="btn btn-success btn-block btn-lg">Зарегестрироваться</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
<!--                            Card SignUp-->
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</main>



</body>
</html>
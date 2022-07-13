<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/includes/crudInclude.php";
require_once "$root/classes/utils/Pagination.php";
require_once "$root/src/constant/tableActionAlert.php";

if (empty($_SESSION) || !isset($_SESSION["uid"])) {
    header("location: /InternSpark/src/page/login.php?error=session_not_found");
}

$session_uid = $_SESSION["uid"];
$session_role_name = $_SESSION["role_name"];

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
    <!--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">-->
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

    <!--    Alert error else success-->
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
        $_SESSION["success"] = $_SESSION["success_two"];
        $_SESSION["success_two"] = "";
    }

    ?>

    <!--    Button add -->
    <form class="container-fluid">
        <span class="navbar-text ">
            User in system <b>Name:</b> <?php echo " " . $session_uid . " " ?>  <b>Type_user:</b> <?php echo " " . $session_role_name . " " ?>
        </span>

        <a href="../../includes/logoutInclude.php" class="btn btn-danger">LOGOUT</a>
    </form>
    <?php
    if ($session_role_name == "admin") {

        echo '<button class="btn btn-success mt-2" data-toggle="modal" data-target="#create">';
        echo '<i class="fa fa-plus"></i> </button>';
    }
    ?>


    <table class="table table-striped table-hover mt-2">
        <thead class="thead-dark">
        <tr>
            <th scope="col">id</th>
            <th scope="col">nameFirst</th>
            <th scope="col">email</th>
            <th scope="col">password</th>
            <th scope="col">deleted_at</th>
            <th scope="col">role_name</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php

        $UserData = new UserData();

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        //    here is Table


        $page = $_GET['page'] ?? 1;
        $per_page = 10;
        $total = $UserData->getCountTableRecords();

        $pagination = new Pagination((int)$page, $per_page, $total);
        $start = $pagination->get_start();


        $sliceUserData = $UserData->sliceRead($start, $per_page, $session_role_name);

        foreach ($sliceUserData as $row) {
            ?>
            <?php

            if (!$row->isDeleted() || ($row->isDeleted() && $session_role_name == "admin")) {

                ?>
                <tr>
                    <!--            here is rows-->
                    <!--            -->
                    <?php echo $row; ?>


                    <td>
                        <a href="?id=<?php echo $row->getId() ?>" class="btn btn-light btn-sm"
                           data-toggle="modal" data-target="#view<?php echo $row->getId(); ?>"><i class="fa fa-eye"></i></a>

                        <?php
                        if ($session_role_name == "admin" && !($session_uid == $row->getEmail() || $session_uid == $row->getNameFirst())) {

                             if ($row->isDeleted()) {?>


                            <a href="?id=<?php echo $row->getId() ?>" class="btn btn-dark btn-sm"

                               data-toggle="modal" data-target="#recover<?php echo $row->getId(); ?>">
                                <i class="fa-solid fa-hammer"></i></a>
                        <?php }
                            else
                            {?>
                                <a href="?id=<?php echo $row->getId() ?>" class="btn btn-success btn-sm"
                                   data-toggle="modal" data-target="#edit<?php echo $row->getId(); ?>"><i
                                            class="fa fa-edit"></i></a>
                                <a href="?id=<?php echo $row->getId() ?>" class="btn btn-danger btn-sm"

                                   data-toggle="modal" data-target="#delete<?php echo $row->getId(); ?>"><i
                                            class="fa fa-trash"></i></a>

                            <?php }

                        } ?>

                    </td>


                </tr>
            <?php } ?>
            <!-- Modal edit-->
            <div class="modal fade" id="edit<?php echo $row->getId() ?>" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Изменение данных пользователя</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="?page=<?php echo $page ?>&id=<?php echo $row->getId() ?>" method="post">
                                <div class="form-group">
                                    <small>Почта</small>
                                    <input type="email" class="form-control" name="email" aria-describedby="emailHelp"
                                           value="<?php echo $row->getEmail() ?>">
                                </div>
                                <div class="form-group">
                                    <small>Имя</small>
                                    <input type="text" class="form-control" name="firstName"
                                           value="<?php echo $row->getNameFirst() ?>">
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" name="setAdmin" type="checkbox" checked>
                                        <label class="form-check-label" for="flexCheckChecked">
                                            назначить Администратором
                                        </label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть
                                    </button>
                                    <button type="submit" class="btn btn-primary" name="edit">Сохранить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal edit-->

            <!-- Modal delete-->
            <div class="modal fade" id="delete<?php echo $row->getId() ?>" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Удаление пользователя
                                № <?php echo $row->getId() ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-footer">
                            <form action="?page=<?php echo $page ?>&id=<?php echo $row->getId() ?>" method="post">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                <button type="submit" class="btn btn-danger" name="delete">Удалить</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal delete-->

            <!-- Modal recover-->
            <div class="modal fade" id="recover<?php echo $row->getId() ?>" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Восстановление пользователя
                                № <?php echo $row->getId() ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-footer">
                            <form action="?page=<?php echo $page ?>&id=<?php echo $row->getId() ?>" method="post">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                <button type="submit" class="btn btn-success" name="recover">Восстановить</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal recover-->

            <!-- Modal view-->
            <div class="modal fade" id="view<?php echo $row->getId() ?>" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> Просмотр записи
                                № <?php echo $row->getId() ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Имя: <?php echo $row->getNameFirst() ?></p>
                            <p>Почта: <?php echo $row->getEmail() ?></p>
                        </div>
                        <div class="modal-footer">
                            <form action="?id=<?php echo $row->getId() ?>" method="post">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal view-->
        <?php } ?>

        </tbody>
    </table>


    <!-- Modal create-->
    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Создание пользователя</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <small>Имя</small>
                            <input type="text" class="form-control" name="uid"
                                   value="<?php
                                   if (isset($_SESSION["try_create_name_first"])) {
                                       echo $_SESSION["try_create_name_first"];
                                   }
                                   ?>">
                        </div>
                        <div class="form-group">
                            <small>Почта</small>
                            <input type="text" class="form-control" name="email" aria-describedby="emailHelp"
                                   value="<?php
                                   if (isset($_SESSION["try_create_email"])) {
                                       echo $_SESSION["try_create_email"];
                                   }
                                   ?>">
                        </div>
                        <div class="form-group">
                            <small>Пароль</small>
                            <input type="password" class="form-control" name="pwd">
                        </div>
                        <div class="form-group">
                            <small>Повторите пароль</small>
                            <input type="password" class="form-control" name="pwdRepeat">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            <button type="submit" class="btn btn-primary" name="add">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <?php echo $pagination; ?>
    </div>
</div>
</body>
</html>
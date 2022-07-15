<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/includes/session/session.php";
require_once "$root/classes/Helper/UserHelper.php";
require_once "$root/includes/crudInclude.php";
require_once "$root/classes/utils/Pagination.php";
$userInSystem = UserHelper::findUser($_SESSION["uid"]);


if ($userInSystem->getRole() != "admin")
{
    header("location: table.php");
    exit();
}

if ($userInSystem->getRole() == "admin") {
//        Button add
    echo '<button class="btn btn-success mt-2" data-toggle="modal" data-target="#create">';
    echo '<i class="fa fa-plus"></i> </button>';
}

$UserData = new UserData();

?>


<table class="table table-striped table-hover mt-2">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Avatar</th>
        <th scope="col">id</th>
        <th scope="col">nameFirst</th>
        <th scope="col">email</th>
        <th scope="col">deleted_at</th>
        <th scope="col">role_name</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php


    //    here is Table


    $page = $_GET['page'] ?? 1;
    $per_page = 10;
    $total = $UserData->getCountTableRecords();

    $pagination = new Pagination((int)$page, $per_page, $total);
    $start = $pagination->get_start();


    $sliceUserData = $UserData->sliceRead($start, $per_page, $userInSystem->getRole());


    foreach ($sliceUserData as $row) {
        ?>
            <tr>
                <!--            here is rows-->

                <?php
                $source = "../image/";
                if ($row->getAvatar() != "" && file_exists($source . $row->getAvatar()))
                {
                $source .= $row->getAvatar();
                } else{
                $source .= "default.svg";
                } ?>

                <td>
                    <img src="<?php echo $source ?>" alt="Avatar" class="img-fluid my-3"
                                                      style="width: 50px; "/>
                </td>
                <?php echo $row;
                ?>

                <td>
                    <a href="?id=<?php echo $row->getId() ?>" class="btn btn-light btn-sm"
                       data-toggle="modal" data-target="#view<?php echo $row->getId(); ?>"><i class="fa fa-eye"></i></a>

                    <?php
                        if ($row->isDeleted()) { ?>

                            <a href="?id=<?php echo $row->getId() ?>" class="btn btn-dark btn-sm"

                               data-toggle="modal" data-target="#recover<?php echo $row->getId(); ?>">
                                <i class="fa-solid fa-hammer"></i></a>
                        <?php } elseif ($row->getId() != $userInSystem->getId()) {
                            ?>
                            <a href="?id=<?php echo $row->getId() ?>" class="btn btn-success btn-sm"
                               data-toggle="modal" data-target="#edit<?php echo $row->getId(); ?>"><i
                                        class="fa fa-edit"></i></a>
                            <a href="?id=<?php echo $row->getId() ?>" class="btn btn-danger btn-sm"

                               data-toggle="modal" data-target="#delete<?php echo $row->getId(); ?>"><i
                                        class="fa fa-trash"></i></a>
                        <?php }
                            ?>
                </td>
            </tr>

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
                                <small>Пароль</small>
                                <input type="password" class="form-control" name="pwd">
                            </div>
                            <div class="form-group">
                                <small>Повторите пароль</small>
                                <input type="password" class="form-control" name="pwdRepeat">
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" name="setAdmin" type="checkbox">
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
                        <!--                            <img class="rounded-circle" alt="default.svg" src="http://simpleicon.com/wp-content/uploads/user1.png"  data-holder-rendered="true">-->
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
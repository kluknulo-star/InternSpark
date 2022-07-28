<!doctype html>
<html lang="en">
<head>
    <?php require_once APP_ROOT_DIRECTORY . "app/Courses/views/utils/header.php" ?>
</head>
<body>

<div class="container-fluid">

    <!--    Alert window-->
    <?php require_once APP_ROOT_DIRECTORY . "app/Courses/views/utils/alertWindow.php" ?>
    <!--    Alert window-->

    <!-- Unset Session Variable -->
    <?php require_once APP_ROOT_DIRECTORY . "app/Courses/views/utils/unsetSessionVariable.php" ?>
    <!-- Unset Session Variable -->

    <form class="container-fluid">
        <span class="navbar-text ">
            User in system <b>Name:</b> <?php echo " " . $userInSystem->getNameFirst() . " " ?>  <b>Type_user:</b> <?php echo " " . $userInSystem->getRole() . " " ?>
        </span>

        <a href="/logout" class="btn btn-danger">LOGOUT</a>
        <a href="/profile" class="btn btn-primary">Profile</a>
        <a href="/courses" class="btn btn-dark">Мои курсы</a>
        <a href="/users" class="btn btn-light">Пользователи</a>
    </form>

    <a class="btn btn-success mt-2" href="/courses/create">
        <i class="fa fa-plus"></i> </a>

    <table class="table table-hover table-bordered mt-2">
        <thead class="thead-light">
        <tr>
            <th scope="col">Course id</th>
            <th scope="col">Title course</th>
            <th scope="col">Author Name</th>
            <th scope="col">deleted_at</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($sliceCourseData as $row) {
            ?>
            <tr>

                <?php echo $row;
                //                var_dump($row);
                ?>

                <td>
                    <a href="/courses/<?php echo $row->getIdCourse() ?>/view" class="btn btn-light btn-sm"><i
                                class="fa fa-eye"></i></a>

                    <?php
                    if ($userInSystem->getNameFirst()  == $row->getAuthorName()) {
                        if ($row->isDeleted()) { ?>
                            <a href="" class="btn btn-dark btn-sm"
                               data-toggle="modal" data-target="#recover<?php echo $row->getIdCourse(); ?>">
                                <i class="fa-solid fa-hammer"></i></a>
                        <?php } else {
                            ?>
                            <a href="/courses/<?php echo $row->getIdCourse() ?>/content" class="btn btn-success btn-sm">
                                <i class="fa fa-edit"></i></a>
                            <a href="" class="btn btn-danger btn-sm"
                               data-toggle="modal" data-target="#delete<?php echo $row->getIdCourse(); ?>">
                                <i class="fa fa-trash"></i></a>
                        <?php }
                    }
                    ?>
                </td>
            </tr>


            <!-- Modal delete-->
            <div class="modal fade" id="delete<?php echo $row->getIdCourse() ?>" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Удаление курса
                                № <?php echo $row->getIdCourse() ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-footer">
                            <form action="/courses/<?php echo $row->getIdCourse() ?>/delete" method="post">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                <button type="submit" class="btn btn-danger" name="delete">Удалить</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal delete-->

            <!-- Modal recover-->
            <div class="modal fade" id="recover<?php echo $row->getIdCourse() ?>" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Восстановление пользователя
                                № <?php echo $row->getIdCourse() ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-footer">
                            <form action="/courses/<?php echo $row->getIdCourse() ?>/restore" method="post">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                <button type="submit" class="btn btn-success" name="recover">Восстановить</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal recover-->

        <?php } ?>
        </tbody>
    </table>


    <div class="d-flex justify-content-center">
        <?php echo $pagination; ?>
    </div>
</div>
</body>
</html>
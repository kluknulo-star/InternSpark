<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/includes/session/session.php";
require_once "$root/classes/Helper/UserHelper.php";
require_once "$root/includes/crudCourses/crudInclude.php";
require_once "$root/classes/utils/Pagination.php";
$userInSystem = UserHelper::findUser($_SESSION["uid"]);


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($uri, '/'));

$userFromURI = $segments[1];
//ToDo: userFromURI

if ($userInSystem->getId() != $userFromURI)
{
    header("location: /users");
    exit();
}

//if ($userInSystem->getId() == $userFromURI) {
////        Button add
//    echo '<button class="btn btn-success mt-2" data-toggle="modal" data-target="#create">';
//    echo '<i class="fa fa-plus"></i> </button>';
//}

$CourseData = new CourseData();

?>


<table class="table table-striped table-hover mt-2">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Course id</th>
        <th scope="col">Title course</th>
        <th scope="col">Author Name</th>
        <th scope="col">Content</th>
        <th scope="col">deleted_at</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php


    //    here is Table


    $page = $_GET['view'] ?? 1;
    $per_page = 10;
    $total = $CourseData->getCountCourseRecords($userFromURI);

    $pagination = new Pagination((int)$page, $per_page, $total);
    $start = $pagination->get_start();

    $sliceCourseData = $CourseData->sliceRead($userFromURI,$start, $per_page);

    foreach ($sliceCourseData as $row) {
        ?>
            <tr>

                <?php echo $row;
//                var_dump($row);
                ?>

                <td>
                    <a href="?id=<?php echo $row->getIdCourse() ?>" class="btn btn-light btn-sm"
                       data-toggle="modal" data-target="#view<?php echo $row->getIdCourse(); ?>"><i class="fa fa-eye"></i></a>

                    <?php
                        if ($row->isDeleted()) { ?>

                            <a href="?id=<?php echo $row->getIdCourse() ?>" class="btn btn-dark btn-sm"

                               data-toggle="modal" data-target="#recover<?php echo $row->getIdCourse(); ?>">
                                <i class="fa-solid fa-hammer"></i></a>
                        <?php } else {
                            ?>
                            <a href="?id=<?php echo $row->getIdCourse() ?>" class="btn btn-success btn-sm"
                               data-toggle="modal" data-target="#edit<?php echo $row->getIdCourse(); ?>"><i
                                        class="fa fa-edit"></i></a>
                            <a href="?id=<?php echo $row->getIdCourse() ?>" class="btn btn-danger btn-sm"

                               data-toggle="modal" data-target="#delete<?php echo $row->getIdCourse(); ?>"><i
                                        class="fa fa-trash"></i></a>
                        <?php }
                            ?>
                </td>
            </tr>

        <!-- Modal edit-->
        <div class="modal fade" id="edit<?php echo $row->getIdCourse() ?>" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Изменение данных курса</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="?page=<?php echo $page ?>&id=<?php echo $row->getIdCourse() ?>" method="post">
                            <div class="form-group">
                                <small>Title</small>
                                <input type="text" class="form-control" name="title"
                                       value="<?php echo $row->getTitle() ?>">
                            </div>
                            <div class="form-group">
                                <small>Content</small>
                                <input type="text" class="form-control" name="content"
                                       value="<?php echo $row->getContent() ?>">
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
                        <form action="?page=<?php echo $page ?>&id=<?php echo $row->getIdCourse() ?>" method="post">
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
                        <form action="?page=<?php echo $page ?>&id=<?php echo $row->getIdCourse() ?>" method="post">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            <button type="submit" class="btn btn-success" name="recover">Восстановить</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal recover-->

        <!-- Modal view-->
        <div class="modal fade" id="view<?php echo $row->getIdCourse() ?>" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Просмотр записи
                            № <?php echo $row->getIdCourse() ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <p>Контент: <?php echo $row->getContent() ?></p>
                    </div>
                    <div class="modal-footer">
                        <form action="?id=<?php echo $row->getIdCourse() ?>" method="post">
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
<!--    --><?php //echo $pagination; ?>
</div>
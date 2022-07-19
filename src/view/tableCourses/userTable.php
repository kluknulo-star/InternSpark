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

//if ($userInSystem->getId() != $userFromURI)
//{
//    header("location: /users");
//    exit();
//}

if ($userInSystem->getId() == $userFromURI) {
//        Button add
    echo '<button class="btn btn-success mt-2" data-toggle="modal" data-target="#create">';
    echo '<i class="fa fa-plus"></i> </button>';
}

$CourseData = new CourseData();

?>


<table class="table table-striped table-hover mt-2">
    <thead class="thead-info">
    <tr>
        <th scope="col">Course id</th>
        <th scope="col">Title Course</th>
        <th scope="col">Author Name</th>
        <th scope="col">Content</th>
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

    $sliceCourseData = $CourseData->sliceRead($userFromURI, $start, $per_page, "user");

    foreach ($sliceCourseData as $row) {
        ?>
        <tr>

            <?php echo $row->userToString();
            //                var_dump($row);
            ?>

            <td>
                <a href="?id=<?php echo $row->getIdCourse() ?>" class="btn btn-light btn-sm"
                   data-toggle="modal" data-target="#view<?php echo $row->getIdCourse(); ?>"><i class="fa fa-eye"></i></a>
            </td>
        </tr>

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

<div class="d-flex justify-content-center">
    <!--    --><?php //echo $pagination; ?>
</div>
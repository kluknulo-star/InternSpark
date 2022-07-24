<?php

$userInSystem = $UsersTableService->getUserInSystem();


if ($userInSystem->getRole() != "admin")
{
    header("location: /users");
    exit();
}


?>

<a class="btn btn-success mt-2" href="/users/create">
<i class="fa fa-plus"></i> </a>

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
    $total = $UsersTableService->getCountTableRecords();

    $pagination = $UsersTableService->createPagination((int)$page, $per_page, $total);
//    $pagination = new Pagination((int)$page, $per_page, $total);
    $start = $pagination->get_start();


    $sliceUserData = $UsersTableService->sliceRead($start, $per_page, $userInSystem->getRole());


    foreach ($sliceUserData as $row) {
        ?>
        <tr>
            <!--            here is rows-->
            <td>
                <img src="<?= $row->getFullAvatar() ?>" alt="Avatar" class="img-fluid my-3"
                     style="width: 50px; "/>
            </td>
            <?php echo $row;
            ?>

            <td>
                <a href="users/<?php echo $row->getId() ?>/view" class="btn btn-light btn-sm"><i class="fa fa-eye"></i></a>

                <?php
                if ($row->isDeleted()) { ?>

                    <a href="?id=<?php echo $row->getId() ?>" class="btn btn-dark btn-sm"

                       data-toggle="modal" data-target="#recover<?php echo $row->getId(); ?>">
                        <i class="fa-solid fa-hammer"></i></a>
                <?php } elseif ($row->getId() != $userInSystem->getId()) {
                    ?>
                    <a href="users/<?php echo $row->getId() ?>/edit" class="btn btn-success btn-sm"?><i
                            class="fa fa-edit"></i></a>
                    <a href="?id=<?php echo $row->getId() ?>" class="btn btn-danger btn-sm"

                       data-toggle="modal" data-target="#delete<?php echo $row->getId(); ?>"><i
                            class="fa fa-trash"></i></a>
                <?php }
                ?>
            </td>
        </tr>



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
                            <a href="users/<?php echo $row->getId() ?>/delete" type="submit" class="btn btn-danger">Удалить</a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal delete-->

        <!-- Modal restore-->
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
                            <a href="users/<?php echo $row->getId() ?>/restore" type="submit" class="btn btn-success" >Восстановить</a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal restore-->

    <?php } ?>
    </tbody>
</table>

<div class="d-flex justify-content-center">
    <?php echo $pagination; ?>
</div>
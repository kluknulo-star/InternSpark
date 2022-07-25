<?php

$userInSystem = $UsersTableService->getUserInSystem();


if ($userInSystem->getRole() == "admin")
{
    header("location: /users");
    exit();
}


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
    $total = $UsersTableService->getCountTableRecords($userInSystem->getRole());

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

            </td>
        </tr>


    <?php } ?>
    </tbody>
</table>

<div class="d-flex justify-content-center">
    <?php echo $pagination; ?>
</div>
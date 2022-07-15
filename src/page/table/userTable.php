<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/includes/crudInclude.php";
require_once "$root/classes/utils/Pagination.php";
require_once "$root/includes/session/session.php";
require_once "$root/classes/Helper/UserHelper.php";

$userInSystem = UserHelper::findUser($_SESSION["uid"]);

$UserData = new UserData();

if ($userInSystem->getRole() == "admin")
{
    header("location: table.php");
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
            <?php

            if (!$row->isDeleted() || ($row->isDeleted())) {

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

                    <?php echo $row->userToString();
                    ?>

                    <td>
                        <a href="?id=<?php echo $row->getId() ?>" class="btn btn-light btn-sm"
                           data-toggle="modal" data-target="#view<?php echo $row->getId(); ?>"><i class="fa fa-eye"></i></a>
                    </td>

                </tr>
            <?php }

            ?>

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




    <div class="d-flex justify-content-center">
        <?php echo $pagination; ?>
    </div>
</div>
</body>
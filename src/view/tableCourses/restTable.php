<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($uri, '/'));
$uriIdTry = $segments[0];

function showModal($id, $action)
{
    var_dump($action, $id);
    $commandRun = '#' . $action . $id;

    ?>
    <?php echo $commandRun?>
    <script>
        $(window).on('load',function(){
            $('<?php echo $commandRun?>').modal('show');
        });
    </script>
    <?php
}


if (count($segments) > 1) {

    $uriId = $segments[1];

    if (ctype_digit($uriId) && UserHelper::isExistId($uriId)) {

        $UserRest = UserHelper::findUserFromId($uriId);
        $userInSystem = UserHelper::findUser($_SESSION["uid"]);
        createModal($UserRest);

        if(count($segments) == 4)
        {
            $action = $segments[3];
            if ((in_array( $action, ['view', 'delete', 'edit', 'recover']) && $userInSystem->getRole() == "admin") ||
                $action == 'view' && $userInSystem->getRole() == "user")
            {
                showModal($uriId, $action);
            }
        }


    } elseif (count($segments) == 3 && $uriId == 'create'){
        showModal('', 'create');
        }

} ?>



<?php
 function createModal($UserRest){
     $page = $_GET['view'] ?? 1;
?>
<!-- Modal edit-->
<div class="modal fade" id="edit<?php echo $UserRest->getId() ?>" tabindex="-1" role="dialog"
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
                <form action="?page=<?php echo $page ?>&id=<?php echo $UserRest->getId() ?>" method="post">
                    <div class="form-group">
                        <small>Почта</small>
                        <input type="email" class="form-control" name="email" aria-describedby="emailHelp"
                               value="<?php echo $UserRest->getEmail() ?>">
                    </div>
                    <div class="form-group">
                        <small>Имя</small>
                        <input type="text" class="form-control" name="firstName"
                               value="<?php echo $UserRest->getNameFirst() ?>">
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
<div class="modal fade" id="delete<?php echo $UserRest->getId() ?>" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Удаление пользователя
                    № <?php echo $UserRest->getId() ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <form action="?page=<?php echo $page ?>&id=<?php echo $UserRest->getId() ?>" method="post">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-danger" name="delete">Удалить</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal delete-->

<!-- Modal recover-->
<div class="modal fade" id="recover<?php echo $UserRest->getId() ?>" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Восстановление пользователя
                    № <?php echo $UserRest->getId() ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <form action="?page=<?php echo $page ?>&id=<?php echo $UserRest->getId() ?>" method="post">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-success" name="recover">Восстановить</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal recover-->

<!-- Modal view-->
<div class="modal fade" id="view<?php echo $UserRest->getId()?>" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Просмотр записи
                    № <?php echo $UserRest->getId() ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--                            <img class="rounded-circle" alt="default.svg" src="http://simpleicon.com/wp-content/uploads/user1.png"  data-holder-rendered="true">-->
                <p>Имя: <?php echo $UserRest->getNameFirst() ?></p>
                <p>Почта: <?php echo $UserRest->getEmail() ?></p>
            </div>
            <div class="modal-footer">
                <form action="?id=<?php echo $UserRest->getId() ?>" method="post">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal view-->

<?php
 }
?>

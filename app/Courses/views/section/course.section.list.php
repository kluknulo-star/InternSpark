<?php

?>
<!doctype html>
<html lang="en">
<head>
    <?php require_once APP_ROOT_DIRECTORY . "app/Courses/views/utils/header.php" ?>
</head>
<body>
<br>

<div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100 w-75">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6">

                <div class="card" style="border-radius: 15px;">
                    <div align="center" class="card-body p-4">

                        <div>
                            <div class="mb-3">
                                <h2 align="center"> Курс </h2>
                            </div>

                            <div class="mb-3">
                                <p class="fs-5"><b>Название:</b> <?php echo $courseRecord->getTitle() ?></p>
                            </div>
                            <div class="mb-3">
                                <p class="fs-5"><b>Описание:</b> <?php echo $courseRecord->getDescription() ?></p>
                            </div>
                            <div class="mb-3">

                                <a class="btn btn-primary mt-2" href="/courses/<?= $courseId ?>/edit"> Редактировать курс</a>
                                <a class="btn btn-success mt-2" href="/courses/<?= $courseId ?>/content/create">
                                    <i class="fa fa-plus"></i> </a>
                            </div>
                            <?php
                            if ($sectionCourseDump) {
                            foreach ($sectionCourseDump as $section) { ?>
                            <div class="mb-3">
                                <div class="card" style="width: 30rem;">

                                    <div class="card-body">

                                        <p class="card-title"><b><?= $section['type'] ?> </b></p>
                                        <p class="card-text"><?= $section['content'] ?></p>

                                        <a href="/courses/<?= $courseId ?>/content/<?= $section['sectionId'] ?>/edit" class="btn btn-success btn-sm">
                                            <i class="fa fa-edit"></i></a>
                                        <a href="" class="btn btn-danger btn-sm"
                                           data-toggle="modal" data-target="#delete<?= $section['sectionId'] ?>">
                                            <i class="fa fa-trash"></i></a>

                                        <!-- Modal delete-->
                                        <div class="modal fade" id="delete<?= $section['sectionId'] ?>"
                                             tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">

                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Подтвердить удаление контента
                                                            № <?= $section['sectionId'] ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="/courses/<?= $courseId ?>/content/<?= $section['sectionId'] ?>/delete"
                                                              method="post">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Закрыть
                                                            </button>
                                                            <button type="submit" class="btn btn-danger" name="delete">
                                                                Удалить
                                                            </button>
                                                    </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal delete-->

        </div>
    </div>
</div>
<?php }
} ?>

<div class="d-flex justify-content-center">
    <div class="mb-3 form-check">
        <a href="/courses/" type="submit"
           class="btn btn-light btn-block btn-lg">Вернуться</a>
    </div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>

</body>
</html>


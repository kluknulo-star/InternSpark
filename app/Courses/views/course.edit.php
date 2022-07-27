<?php

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Edit</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
            crossorigin="anonymous"></script>
</head>
<body>
<br>

<div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100 w-70">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6">

                <div class="card" style="border-radius: 15px;">
                    <div class="card-body p-4">

                        <form action="/courses/<?= $userId ?>/view" method="post">
                            <div class="mb-3">
                                <h2 align="center"> Курс </h2>
                            </div>

                            <div class="mb-3">
                                <p class="fs-5"><b>Название:</b> <?php echo $CourseRecord->getTitle() ?></p>
                                <!--                                <h5 for="exampleInputEmail1" class="form-label">Имя: -->
                                <?php //echo $row->getEmail() ?><!--</h5>-->
                            </div>
                            <div class="mb-3">
                                <p class="fs-5"><b>Описание:</b> <?php echo $CourseRecord->getDescription() ?></p>
                                <!--                                <h5 for="exampleInputEmail1" class="form-label">Почта: -->
                                <?php //echo $row->getNameFirst() ?><!--</h5>-->
                            </div>

                            <div class="mb-3">
                                <div class="card" style="width: 35rem;">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text">Some quick example text to build on the card title and make
                                            up the bulk of the card's content.</p>
                                        <a href="#" class="btn btn-dark">Удалить</a>
                                        <a href="#" class="btn btn-danger">Обновть</a>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="card" style="width: 35rem;">
                                    <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text">Some quick example text to build on the card title and make
                                            up the bulk of the card's content.</p>
                                        <a href="#" class="btn btn-dark">Удалить</a>
                                        <a href="#" class="btn btn-danger">Обновть</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="mb-3 form-check">
                                    <a href="/courses" type="submit"
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


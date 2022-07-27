<?php
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Create</title>
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
    <div class="container h-100 w-50">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6">

                <!--    Alert window-->
                <?php require_once APP_ROOT_DIRECTORY . "app/Users/views/utils/alertWindow.php" ?>
                <!--    Alert window-->

                <div class="card" style="border-radius: 15px;">
                    <div class="card-body p-4">

                        <form action="/courses/<?=$courseId?>/content/create" method="post">
                            <div class="mb-3">
                                <h3 align="center">Обновление курса</h3>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Вид контента</label>
                                <select class="form-select" aria-label="Пример выбора по умолчанию" name="selectType">
                                    <option value="text" selected>Text</option>
                                    <option value="link">Link</option>
                                    <option value="photo">Photo</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Контент</label>
                                <textarea type="textarea" class="form-control" name="textbox"
                                       value="<?php
                                       if (isset($_SESSION["try_title"])) {
                                           echo $_SESSION["try_title"];
                                       }
                                       ?>"></textarea>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="mb-3 form-check">
                                    <button type="submit" class="btn btn-success btn-block btn-lg" name="submit">
                                        Создать
                                    </button>
                                    <a href="/courses/<?= $courseId?>/content" type="submit" class="btn btn-light btn-block btn-lg">Вернуться</a>
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


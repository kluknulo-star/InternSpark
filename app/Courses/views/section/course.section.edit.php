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
    <div class="container h-100 w-50">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6">

                <!--    Alert window-->
                <?php require_once APP_ROOT_DIRECTORY . "app/Users/views/utils/alertWindow.php" ?>
                <!--    Alert window-->

                <div class="card" style="border-radius: 15px;">
                    <div class="card-body p-4">

                        <form method="post">
                            <div class="mb-3">
                                <h3 align="center">Обновление контента</h3>
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
                                <textarea type="textarea" class="form-control" name="textbox"><?php echo $sectionContent;?></textarea>

                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="mb-3 form-check">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg" name="submit">
                                        Обновить
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


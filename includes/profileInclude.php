<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/classes/Validator/ProfileValidator.php";
require_once "$root/classes/Entity/UserData.php";
require_once "$root/includes/session/session.php";
require_once "$root/classes/Helper/UserHelper.php";

//function showSuccessAction($success_code)
//{
//
//    $_SESSION["success"] = $success_code;
//    $_SESSION["success_two"] = $success_code;
////    header("location: table.php.old");
//}
//
//function can_upload($file)
//{
//    // если имя пустое, значит файл не выбран
//    if ($file['name'] == '')
//        return 'Вы не выбрали файл.';
//
//    if ($file['size'] == 0)
//        return 'Файл слишком большой.';
//
//    $getMime = explode('.', $file['name']);
//
//    $mime = strtolower(end($getMime));
//
//    $types = ['jpg', 'png', 'gif', 'bmp', 'jpeg'];
//
//    // если расширение не входит в список допустимых - return
//    if (!in_array($mime, $types))
//        return 'Недопустимый тип файла.';
//
//    return true;
//}
//
//function make_upload($file)
//{
//    // формируем уникальное имя картинки: случайное число и name
//    $name = mt_rand(0, 10000) . uniqid();
//    var_dump($name);
//    copy($file['tmp_name'], 'img/' . $name);
//    $target = 'uploads/';
//    move_uploaded_file($_FILES['file']['name'], $target);
//}
//if (isset($_FILES['file'])) {
//    // проверяем, можно ли загружать изображение
//
//    var_dump($_FILES);
//    $check = can_upload($_FILES['file']);
//
//    if ($check === true) {
//        // загружаем изображение на сервер
//        make_upload($_FILES['file']);
//        echo "<strong>Файл успешно загружен!</strong>";
//    } else {
//            // выводим сообщение об ошибке
//            echo "<strong>$check</strong>";
//        }
//    }

function CheckImage($target_file, $imageFileType, $uploadOk, $target_dir)
{
// Check if file already exists
    if (file_exists($target_file)) {
        $_SESSION["error"] = "Sorry, file already exists.";
        $uploadOk = 0;
    }

// Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $_SESSION["error"] = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $_SESSION["error"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $_SESSION["fatal_error"] = "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $_SESSION["error"] = "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";

            $userInSystem = UserHelper::findUser($_SESSION["uid"]);

            if ($userInSystem->getAvatar()) {
                unlink($target_dir . $userInSystem->getAvatar());
            }
            UserHelper::addAvatar($_SESSION["uid"], $_FILES["fileToUpload"]["name"]);
        } else {
            $_SESSION["error"] = "Sorry, there was an error uploading your file.";
        }
    }
}


if (isset($_POST["updateMyself"])) {

    var_dump($_FILES);
    if ($_FILES["fileToUpload"]["tmp_name"]) {
        $target_dir = "image/";
        $_FILES["fileToUpload"]["name"] = uniqid().$_FILES["fileToUpload"]["name"];
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);


        if (!$check) {
            $_SESSION["error"] = "File is not an image";
            $uploadOk = 0;
        }

        CheckImage($target_file, $imageFileType, $uploadOk, $target_dir);
        unset($FILE);

    $location = '/InternSpark/src/page/profile.php';
    header("location: $location");
        exit();
    }

    $userInSystem = UserHelper::findUser($_SESSION["uid"]);
    $email = $_POST["email"];
    $nameFirst = $_POST["firstName"];
    $getId = $userInSystem->getId();
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwdRepeat"];

    $editUser = new ProfileValidator($getId, $nameFirst, $email, $password, $passwordRepeat);

    $_SESSION["uid"] = $nameFirst;
    $editUser->updateProfileUser();

//    showSuccessAction("success_edit");

}

if (isset($_POST["deleteMyselfAvatar"])) {
    $userInSystem = UserHelper::findUser($_SESSION["uid"]);

    $target_dir = "image/";
    if ($userInSystem->getAvatar()) {
        unlink($target_dir . $userInSystem->getAvatar());
    }
    UserHelper::addAvatar($_SESSION["uid"], "");


}


//if (isset($_POST['updateMyself'])) {
//
//    $userInSystem = UserHelper::findUser($_SESSION["uid"]);
//
//
//    $email = $_POST["email"];
//    $nameFirst = $_POST["firstName"];
//    $getId = $userInSystem->getId();
//    $password = $_POST["pwd"];
//    $passwordRepeat = $_POST["pwdRepeat"];
//
//
//
//    $editUser = new ProfileValidator($getId, $nameFirst, $email, $password, $passwordRepeat);
//
//    $_SESSION["uid"] = $nameFirst;
//    $editUser->updateProfileUser();
//
//
//    showSuccessAction("success_edit");
//
//
//}
?>
<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/classes/Validator/ProfileValidator.php";
require_once "$root/classes/Entity/UserData.php";
require_once "$root/includes/session/session.php";
require_once "$root/classes/Helper/UserHelper.php";

function CheckImage($target_file, $imageFileType, $uploadOk, $target_dir)
{
// Check if file already exists
    if (file_exists($target_file)) {
        $_SESSION["error"] = "file_exist";
        $uploadOk = 0;
    }

// Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $_SESSION["error"] = "file_large";
        $uploadOk = 0;
    }

// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $_SESSION["error"] = "file_incorrect";
        $uploadOk = 0;
    }

// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $_SESSION["error"] = "fatal_error";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $_SESSION["success"] = "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
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
        $target_dir = "$root/src/page/image/";
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

    $location = '/profile';
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

    showSuccessAction("success_edit");

}

if (isset($_POST["deleteMyselfAvatar"])) {
    $userInSystem = UserHelper::findUser($_SESSION["uid"]);

//    $target_dir = "/src/page/image/";
    $root_source = "$root/src/page/image/";
    if ($userInSystem->getAvatar()) {
        unlink($root_source . $userInSystem->getAvatar());
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
<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once "$root/includes/signupInclude.php";
require_once "$root/classes/EntityCourses/EditCourse.php";
require_once "$root/includes/session/session.php";
require_once "$root/classes/Helper/UserHelper.php";
require_once "$root/classes/Entity/CourseData.php";


function checkAccessAction($error_code)
{
    if (isset($_SESSION["uid"]) && $_SESSION["role_name"] != "admin") {
            $_SESSION["error"] = $error_code;
            header("location: /users");
            exit();
        } elseif (!isset($_SESSION["uid"])){
            $_SESSION["error"] = $error_code;
            header("location: /users");
            exit();
        }
}

//function showSuccessAction($success_code)
//{
//
//    $_SESSION["success"] = $success_code;
//    $_SESSION["success_two"] = $success_code;
//    //ToDo: Check location to work;
//    header("location: /users");
//}
//
//function checkMyselfAction($error_code)
//{
//    $userInSystem = UserHelper::findUser($_SESSION["uid"]);
//    if ($_GET["id"] == $userInSystem->getId())
//    {
//        $_SESSION["error"] = $error_code;
//        header("location: /users");
//        exit();
//    }
//}

if (isset($_POST['edit'])) {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $id = $_GET["id"];

    $editUser = new EditCourse();

    $editUser->updateCourse($title, $content, $id);
//    $UserData->update($get_id, $nameFirst, $email,$role_set);
//    showSuccessAction("success_edit");
}


if (isset($_POST["add"])) {
    //Grabbing the data
    $nameFirst = $_POST["uid"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwdRepeat"];
    $email = $_POST["email"];

    checkAccessAction("access_denied");

    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    // Instantiate SignupValidator class
    require_once "$root/classes/config/DataBasePDO.php";
    require_once "$root/classes/Entity/Signup.php";
    require_once "$root/classes/Validator/AddValidator.php";
    $signup = new AddValidator($nameFirst, $password, $passwordRepeat, $email);

    //Running error handlers and user signup
    $signup->addUser();

    $_SESSION["try_create_name_first"] = "";
    $_SESSION["try_create_email"] = "";

    showSuccessAction("success_add");
}

if (isset($_POST['delete'])) {

//    checkAccessAction("access_denied");
//    checkMyselfAction("access_myself_denied");
    $id = $_GET["id"];

    $editUser = new EditCourse();

    $editUser->deleteCourse($id);
//    showSuccessAction("success_delete");
}

if (isset($_POST['recover'])) {

//    checkAccessAction("access_denied");

    $id = $_GET["id"];
//    $UserData->recover($get_id);
    $editUser = new EditCourse();

    $editUser->recoverCourse($id);
//    showSuccessAction("success_recover");
}
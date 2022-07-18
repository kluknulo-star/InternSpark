<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once "$root/includes/signupInclude.php";
require_once "$root/classes/Validator/EditValidator.php";
require_once "$root/includes/session/session.php";
require_once "$root/classes/Helper/UserHelper.php";

$UserData = new UserData();


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

function showSuccessAction($success_code)
{

    $_SESSION["success"] = $success_code;
    $_SESSION["success_two"] = $success_code;
    //ToDo: Check location to work;
    header("location: /users");
}

function checkMyselfAction($error_code)
{
    $userInSystem = UserHelper::findUser($_SESSION["uid"]);
    if ($_GET["id"] == $userInSystem->getId())
    {
        $_SESSION["error"] = $error_code;
        header("location: /users");
        exit();
    }
}

if (isset($_POST['edit'])) {
    $email = $_POST["email"];
    $nameFirst = $_POST["firstName"];
    $get_id = $_GET["id"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwdRepeat"];

    if (isset($_POST["setAdmin"])){
        $role_set = 2;
    } else{
        $role_set = 1;
    }

    checkAccessAction("access_denied");

    checkMyselfAction("access_myself_denied");

    $editUser = new EditValidator($get_id, $nameFirst, $email, $password, $passwordRepeat, $role_set);

    $editUser->editUser();
//    $UserData->update($get_id, $nameFirst, $email,$role_set);
    showSuccessAction("success_edit");
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
    require_once "$root/classes/DataBaseConnection/DataBasePDO.php";
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

    checkAccessAction("access_denied");
    checkMyselfAction("access_myself_denied");
    $get_id = $_GET["id"];
    $UserData->delete($get_id);
    showSuccessAction("success_delete");
}

if (isset($_POST['recover'])) {

    checkAccessAction("access_denied");

    $get_id = $_GET["id"];
    $UserData->recover($get_id);
    showSuccessAction("success_recover");
}
<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once "$root/classes/Entity/UserData.php";
require_once "$root/includes/signupInclude.php";
require_once "$root/classes/Validator/Validation.php";
$UserData = new UserData();

function checkAccessAction($error_code)
{
    if (isset($_SESSION["uid"]) && $_SESSION["role_name"] != "admin") {
            $_SESSION["error"] = $error_code;
            header("location: /InternSpark/src/page/table.php");
            exit();
        } elseif (!isset($_SESSION["uid"])){
            header("location: /InternSpark/src/page/login.php?error=$error_code");
            exit();
        }
}

function showSuccessAction($success_code)
{

    $_SESSION["success"] = $success_code;
    $_SESSION["success_two"] = $success_code;
    header("location: table.php");
}


if (isset($_POST['edit'])) {
    $email = $_POST["email"];
    $nameFirst = $_POST["firstName"];
    $get_id = $_GET["id"];

    if (isset($_POST["setAdmin"])){
        $role_set = 2;
    } else{
        $role_set = 1;
    }

    checkAccessAction("access_denied");


    $location='/InternSpark/src/page/table.php';
    if(!Validation::isValidNameFirst($nameFirst)) {
        // echo "Invalid NameFirst";
        $_SESSION["error"] = "invalid_uid";
        header("location: $location");
        exit(); //check
    }

    if(!Validation::isValidEmail($email)) {
        // echo "Invalid email";
        $_SESSION["error"] = "invalid_uid";
        header("location: $location");
        exit();
    }

    $UserData->update($get_id, $nameFirst, $email,$role_set);
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
    echo "here is delete";
//    var_dump($get_id);
    checkAccessAction("access_denied");

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
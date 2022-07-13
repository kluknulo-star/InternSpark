<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (isset($_POST["submit"]))
{
    //Grabbing the data
    $nameFirst = $_POST["uid"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwdRepeat"];
    $email = $_POST["email"];

    if (isset($_SESSION["uid"])) {
        header("location: /InternSpark/src/page/table.php?error=in_system");
        exit();
    }

    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    // Instantiate SignupValidator class
    require_once "$root/classes/DataBaseConnection/DataBasePDO.php";
    require_once "$root/classes/Entity/Signup.php";
    require_once "$root/classes/Validator/SignupValidator.php";
    $signup = new SignupValidator($nameFirst, $password, $passwordRepeat, $email);


    //Running error handlers and user signup
    $signup->signupUser();
    unset ($_SESSION["try_signup_name_first"]);
    unset ($_SESSION["try_signup_email"]);

    $_SESSION["uid"] = $nameFirst;
    $_SESSION["role_name"] = "user";

    // Going to back front page
    header("location: ../src/page/table.php?error=none");

}
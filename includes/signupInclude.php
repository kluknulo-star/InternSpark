<?php

if (isset($_POST["submit"])) {
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once "$root/classes/Validator/SignupValidator.php";
    require_once "$root/includes/session/session.php";
    require_once "$root/classes/Helper/UserHelper.php";

    //Grabbing the data from Signup Form
    $nameFirst = $_POST["uid"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwdRepeat"];
    $email = $_POST["email"];

    //Check user in system
    if (isset($_SESSION["uid"])) {
        $_SESSION["error"] = "in_system";
        header("location: /InternSpark/src/page/table.php.old");
        exit();
    }

    $signup = new SignupValidator($nameFirst, $password, $passwordRepeat, $email);

    //Running error handlers and user signup
    $signup->signupUser();
    unset ($_SESSION["try_signup_name_first"]);
    unset ($_SESSION["try_signup_email"]);

    $userSessionRecord = UserHelper::findUser($nameFirst);
    $_SESSION["uid"] = $userSessionRecord->getNameFirst();


//    var_dump($test->getEmail());
    // Going to back front page
    header("location: /InternSpark/src/page/table/table.php");
    exit();
}
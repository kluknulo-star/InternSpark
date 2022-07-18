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
    $location = "/users";
    if (isset($_SESSION["uid"])) {
        $_SESSION["error"] = "in_system";
        header("location: $location");
        exit();
    }

    $signup = new SignupValidator($nameFirst, $password, $passwordRepeat, $email);

    //Running error handlers and user signup
    $signup->signupUser();
    unset ($_SESSION["try_signup_name_first"]);
    unset ($_SESSION["try_signup_email"]);

    $userSessionRecord = UserHelper::findUser($nameFirst);
    $_SESSION["uid"] = $userSessionRecord->getNameFirst();

    header("location: $location");
    exit();
}
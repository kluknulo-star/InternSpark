<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$status = session_status();
if (session_status() != PHP_SESSION_ACTIVE)
{
    session_start();
}


if (isset($_POST["submit"]))
{
    //Grabbing the data
    $uid= $_POST["uid_login"];
    $password = $_POST["pwd_login"];

    if (isset($_SESSION["uid"])) {
        if ($_GET["error"] == "access_denied")
        {
            $_SESSION["error"] = "access_denied";
            header("location: /InternSpark/src/page/table.php?");
        }
        else{
            $_SESSION["error"] = "in_system";
            header("location: /InternSpark/src/page/table.php?");
        }
        exit();
    }

    // Instantiate LoginValidator class
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);

    require_once "$root/classes/Entity/UserData.php";
    require_once "$root/classes/Validator/LoginValidator.php";
    $login = new LoginValidator($uid, $password);

    //Running error handlers and user signup
    $login->loginUser();

    // Going to back front page
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    header("location: ../src/page/table.php");

}
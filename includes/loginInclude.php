<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/src/constant/verificationError.php";
require_once "$root/classes/Helper/UserHelper.php";
require_once "$root/includes/session/session.php";
require_once "$root/classes/Entity/UserData.php";
require_once "$root/classes/Validator/LoginValidator.php";

if (isset($_POST["submit"]))
{
    //Grabbing the data
    $uid= $_POST["uid_login"];
    $password = $_POST["pwd_login"];
    var_dump($_SESSION);

    $location = "/users";

    if (isset($_SESSION["uid"])) {
        if ($_SESSION["error"] == "access_denied")
        {
            $_SESSION["error"] = "access_denied";
            header("location: $location");
        }
        else{
            $_SESSION["error"] = "in_system";
            header("location: $location");
        }
        exit();
    }

    // Instantiate LoginValidator class
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);

    $login = new LoginValidator($uid, $password);

    //Running error handlers and user signup
    $login->loginUser();

    $UserData = new UserData();

    $userSessionRecord = UserHelper::findUser($uid);
    $_SESSION["uid"] = $userSessionRecord->getNameFirst();

    // Going to back front view
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    header("location: $location");
    exit();
}
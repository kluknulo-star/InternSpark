<?php
require_once APP_ROOT_DIRECTORY . "app/Core/Helpers/UserHelper.php";

class UsersRestoreService
{
    public function __construct()
    {

    }

    private function redirect($location, $error = "")
    {
        if ($error != "") {
            $_SESSION["error"] = $error;
        }
        header("location: $location");
        exit();
    }

}


<?php
namespace app\Users\Services\users;

class UsersDeleteService
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


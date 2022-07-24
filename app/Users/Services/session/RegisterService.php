<?php

namespace app\Users\Models;
require_once APP_ROOT_DIRECTORY . '/app/Users/Validator/LoginValidator.php';


class RegisterService
{
    public function __construct()
    {
//        $this->tryToLogout();
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

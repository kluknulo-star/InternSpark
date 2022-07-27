<?php

namespace app\Users\Services\session;

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

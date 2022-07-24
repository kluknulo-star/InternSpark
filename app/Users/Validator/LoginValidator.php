<?php


namespace Validator;

use app\Users\Models\UserModel;

require_once APP_ROOT_DIRECTORY . "/app/Users/Validator/Validation.php";
require_once APP_ROOT_DIRECTORY . "/app/Users/Models/UserModel.php";

class LoginValidator
{

    private string $uid;
    private string $password;

    public static function loginUser($uid, $password) : bool
    {
        $_SESSION["try_login_uid"] = $uid;

        if (!Validation::isFullInputLogin($uid, $password)) {
            // echo "Empty input";
            $_SESSION["error"] = "empty_input";
            return false;
        }
        return true;
    }

}
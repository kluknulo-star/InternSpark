<?php


namespace app\Users\Validator;

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
<?php

namespace app\Users\Models;
require_once APP_ROOT_DIRECTORY . '/app/Users/Validator/LoginValidator.php';


class LogoutService
{
    public static function tryToLogout()
    {
        session_unset();
        session_destroy();
    }
}

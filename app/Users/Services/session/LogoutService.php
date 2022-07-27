<?php

namespace app\Users\Services\session;

class LogoutService
{
    public static function tryToLogout()
    {
        session_unset();
        session_destroy();
    }
}

<?php
namespace app\Users\Models;
require APP_ROOT_DIRECTORY . '/app/Users/Services/Validator/LoginValidator.php';


class LoginService
{
    public function __construct($logout = false)
    {
        $this->tryToLogout($logout);
        $this->checkUserInSystem();
        $this->checkSubmitData();
    }

    protected function tryToLogout(bool $logout)
    {
        if ($logout) {
            session_unset();
            session_destroy();
            header("location: /login");
            exit();
        }
    }

    protected function checkUserInSystem()
    {
        if (isset($_SESSION["uid"])) {
            header("location: /users");
            exit();
        }
    }

    protected function loginValidationData()
    {
        $uid = $_POST["uid_login"];
        $password = $_POST["pwd_login"];
        $valudation = new \LoginValidator($uid, $password);
    }

    protected function checkSubmitData()
    {
        if (isset($_POST["submit"]))
        {
            $this->loginValidationData();
        }
    }

}

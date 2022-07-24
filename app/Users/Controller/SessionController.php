<?php

namespace app\Users\Controller;

use AddUserValidator;
use app\Users\Models\LoginService;
use app\Users\Models\LogoutService;
use app\Users\Models\UserModel;
use UserHelper;
use Validator\LoginValidator;

require_once 'BaseController.php';
require_once APP_ROOT_DIRECTORY . '/app/Core/Helpers/UserHelper.php';
require_once APP_ROOT_DIRECTORY . '/app/Users/Services/session/LogoutService.php';
require_once APP_ROOT_DIRECTORY . '/app/Users/Validator/LoginValidator.php';
require_once APP_ROOT_DIRECTORY . '/app/Users/Models/UserModel.php';
require_once APP_ROOT_DIRECTORY . '/app/Users/Validator/AddUserValidator.php';


class SessionController extends BaseController
{
    private function checkUserInSystem()
    {
        if (UserHelper::isUserInSystem()) {
            $_SESSION["error"] = "in_system";
            $this->redirect("users");
        }
    }

    public function login()
    {
        $this->checkUserInSystem();


        if (isset($_POST["submit"])) {
            $uid = $_POST["uid_login"];
            $password = $_POST["pwd_login"];
            $validation = LoginValidator::loginUser($uid, $password);

//            var_dump($validation);
            if ($validation) {
                if (UserModel::loginUser($uid, $password)) {
                    unset($_SESSION["try_login_uid"]);
                    $this->redirect("users");
                }
            }
            $this->redirect("login");
        }


        $this->render("app/Users/views/session/session.login.php");
    }

    public function logout()
    {

        LogoutService::tryToLogout();
        $this->redirect("login");
    }

    public function register()
    {
        $this->checkUserInSystem();

//        var_dump($_SESSION);
        if (isset($_POST["submit"])) {

            //Grabbing the data from Signup Form
            $email = $_POST["email"];
            $nameFirst = $_POST["uid"];
            $password = $_POST["pwd"];
            $passwordRepeat = $_POST["pwdRepeat"];


            $isValidAddAction = AddUserValidator::check($nameFirst, $email, $password, $passwordRepeat);
            var_dump($_SESSION);

            if ($isValidAddAction) {

                $UserName = UserHelper::findUser($nameFirst);
                $UserEmail = UserHelper::findUser($email);

                if (!$UserName && !$UserEmail) {
                    UserModel::createUser($nameFirst, $email, $password);
                    $_SESSION["success"] = "success_register";
                    unset ($_SESSION["try_create_name_first"]);
                    unset ($_SESSION["try_create_email"]);
                    $_SESSION["uid"] = $nameFirst;
                    $this->redirect("users");
                } else {
                    $_SESSION["error"] = "user_or_mail_taken";
                }

            }
            $this->redirect("register");
        }

        $this->render("app/Users/views/session/session.register.php");
    }

    public function error()
    {
        $this->render("app/Users/views/404.html");
    }


}

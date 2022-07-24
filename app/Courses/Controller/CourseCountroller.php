<?php
namespace app\Users\Controller;
use app\Users\Models\LoginService;
use app\Users\Models\LogoutService;
use app\Users\Models\UserModel;

require_once 'BaseController.php';
require_once APP_ROOT_DIRECTORY . '/app/Users/Services/session/LoginService.php';
require_once APP_ROOT_DIRECTORY . '/app/Users/Services/session/LogoutService.php';
require_once APP_ROOT_DIRECTORY . '/app/Users/Validator/LoginValidator.php';
require_once APP_ROOT_DIRECTORY . '/app/Users/Models/UserModel.php';


class CourseCountroller extends BaseController{
    public function myCourse()
    {
        $loginService = new LoginService();

        if (isset($_POST["submit"]))
        {
            $uid = $_POST["uid_login"];
            $password = $_POST["pwd_login"];
            $validation = new \Validator\LoginValidator($uid, $password);
            if ($validation){
                $userModel = new UserModel();
                $userModel->getUser($uid, $password);
                $loginService->goToHomepage();
            }
        }


        $this->render("app/Users/views/session/session.login.php");
    }

    public function logout()
    {
        $loginService = new LogoutService();



//        $this->render("app/Users/views/users/user.view.php");
    }

    public function register()
    {

//        $this->render("app/Users/views/users/user.view.php");
    }
    public function error()
    {
        $this->render("app/Users/views/404.html");
    }



}

<?php
namespace app\Users\Controller;
use app\Users\Models\LoginService;

require 'BaseController.php';
require APP_ROOT_DIRECTORY . '/app/Users/Services/LoginService.php';

class SessionController extends BaseController{
    public function login(array $params)
    {
        $loginService = new LoginService();
        if (isset($_POST))
        {
            var_dump($_POST);
            echo 'что-то есть тут';
            var_dump($_SESSION);
        }
        $this->render("app/Users/views/session/session.login.php");
    }

    public function logout(array $params)
    {
        $loginService = new LoginService(true);

//        $this->render("app/Users/views/users/users.view.php");
    }

    public function register(array $params)
    {


//        $this->render("app/Users/views/users/users.view.php");
    }



}

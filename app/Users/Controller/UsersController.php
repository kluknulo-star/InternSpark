<?php

namespace app\Users\Controller;

use AddUserValidator;
use app\Users\Models\UserModel;
use EditUserValidator;
use UserHelper;
use UsersCreateService;
use UsersEditService;
use UsersViewService;

require_once APP_ROOT_DIRECTORY . '/app/Users/Controller/BaseController.php';
require_once APP_ROOT_DIRECTORY . '/app/Core/Helpers/UserHelper.php';
require_once APP_ROOT_DIRECTORY . '/app/Users/Services/users/UsersTableService.php';
require_once APP_ROOT_DIRECTORY . '/app/Users/Services/users/UsersViewService.php';
require_once APP_ROOT_DIRECTORY . '/app/Users/Services/users/UsersEditService.php';
require_once APP_ROOT_DIRECTORY . '/app/Users/Services/users/UsersCreateService.php';
require_once APP_ROOT_DIRECTORY . '/app/Users/Validator/EditUserValidator.php';
require_once APP_ROOT_DIRECTORY . '/app/Users/Validator/AddUserValidator.php';

class UsersController extends BaseController
{
    private function checkUserInSystem()
    {
        if (!UserHelper::isUserInSystem())
        {
            $_SESSION["error"] = "access_denied";
            $this->redirect("login");
        }
    }

    private function checkUserDeleted(int $id)
    {
        if (UserHelper::findUserFromId($id)->isDeleted()) {
            $_SESSION["error"] = "access_denied";
            $this->redirect("users");
        }
    }

    private function checkToPermission()
    {
        $this->checkUserInSystem();
        if (!UserHelper::UserIsAdmin()) {
            $_SESSION["error"] = "access_denied";
            $this->redirect("users");
        }
    }

    public function index()
    {
        $this->checkUserInSystem();

        $UsersTableService = new \UsersTableService();

        require_once APP_ROOT_DIRECTORY . "app/Users/views/users/table/users.list.php";
    }

    public function view(array $params)
    {
        $this->checkUserInSystem();

        $userId = array_shift($params);
        $UsersViewService = new UsersViewService();

        $row = $UsersViewService->getUserFromId($userId);

        require_once APP_ROOT_DIRECTORY . "app/Users/views/users/user.view.php";
    }

    public function create()
    {
        $this->checkToPermission();

//        $UsersCreateService = new UsersCreateService();

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

                if (!$UserName && !$UserEmail){
                    UserModel::createUser($nameFirst, $email, $password);
                    $_SESSION["success"] = "success_create";
                    unset ($_SESSION["try_create_name_first"]);
                    unset ($_SESSION["try_create_email"]);
                    $this->redirect("users");
                } else {
                    $_SESSION["error"] = "user_or_mail_taken";
                }
            }
            $this->redirect("users/create");
        }

        require_once APP_ROOT_DIRECTORY . "app/Users/views/users/user.create.php";
    }

    public function edit(array $params)
    {
        $this->checkToPermission();

        $userId = array_shift($params);
        $this->checkUserDeleted($userId);

        $UsersEditService = new UsersEditService();

        //validation
        if (isset($_POST["submit"])) {

            //Grabbing the data from Signup Form
            $email = $_POST["email"];
            $nameFirst = $_POST["uid"];
            $password = $_POST["pwd"];
            $passwordRepeat = $_POST["pwdRepeat"];
            if (isset($_POST["setAdmin"])){
                $role_set = 2;
            } else{
                $role_set = 1;
            }

            $isValidEditAction = EditUserValidator::check($nameFirst, $email, $password, $passwordRepeat);
            var_dump($_SESSION);
//            echo

            if ($isValidEditAction) {

                $UserEntity = UserHelper::findUserFromId($userId);

                if (!UserHelper::checkUpdateUser($UserEntity->getNameFirst(), $UserEntity->getEmail(), $UserEntity->getId())){
                    UserModel::updateUser($UserEntity->getId(), $nameFirst, $email, $role_set, $password);
                    $_SESSION["success"] = "success_edit";
                    unset ($_SESSION["try_edit_name_first"]);
                    unset ($_SESSION["try_edit_email"]);
                    $this->redirect("users");
                } else {
                    $_SESSION["error"] = "user_or_mail_taken";
                }
            }
            $this->redirect("users/$userId/edit");
        }


        $row = $UsersEditService->getUserFromId($userId);

        require_once APP_ROOT_DIRECTORY . "app/Users/views/users/user.edit.php";
    }

    public function delete(array $params)
    {
        $this->checkToPermission();
        $userId = (int)array_shift($params);
        $this->checkUserDeleted($userId);

        $userInSystem = UserHelper::findUser($_SESSION["uid"]);

        var_dump($userInSystem->getId());
        var_dump($userId);
        if ($userInSystem->getId() === $userId)
        {
            $_SESSION["error"]="delete_myself";
        }
        else
        {
            UserModel::delete($userId);
        }

        $this->redirect("users");
    }

    public function restore(array $params)
    {
        $this->checkToPermission();

        $userId = array_shift($params);

        UserModel::restore($userId);

        $this->redirect("users");
    }

    public function profile()
    {
        $this->checkToPermission();

        $UsersEditService = new UsersEditService();

        $row = $UsersEditService->getUserInSystem();
        require_once APP_ROOT_DIRECTORY . "app/Users/views/users/profile.php";
    }


}
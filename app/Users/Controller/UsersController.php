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
        if (!UserHelper::isUserInSystem()) {
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

                if (!$UserName && !$UserEmail) {
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
            if (isset($_POST["setAdmin"])) {
                $role_set = 2;
            } else {
                $role_set = 1;
            }

            $isValidEditAction = EditUserValidator::check($nameFirst, $email, $password, $passwordRepeat);
            var_dump($_SESSION);
//            echo

            if ($isValidEditAction) {

                $UserEntity = UserHelper::findUserFromId($userId);

                if (!UserHelper::checkUpdateUser($UserEntity->getNameFirst(), $UserEntity->getEmail(), $UserEntity->getId())) {
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
        if ($userInSystem->getId() === $userId) {
            $_SESSION["error"] = "delete_myself";
        } else {
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
        $this->checkUserInSystem();
        $UsersEditService = new UsersEditService();

        if (isset($_POST["submit"])) {

            var_dump($_FILES);
            if (isset($_FILES["fileToUpload"]["tmp_name"]) && $_FILES["fileToUpload"]["tmp_name"]) {
                $target_dir = APP_ROOT_DIRECTORY . "/public/images/avatars/";
                $_FILES["fileToUpload"]["name"] = uniqid() . $_FILES["fileToUpload"]["name"];
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

                if (!$check) {
                    $_SESSION["error"] = "File is not an image";
                }

                if ($UsersEditService->checkImage($target_file, $imageFileType, $target_dir)) {
                    UserModel::addAvatar($_SESSION["uid"], $_FILES["fileToUpload"]["name"]);
                }
                unset($FILE);

//                $this->redirect("profile");
            }

            $userInSystem = UserHelper::findUser($_SESSION["uid"]);

            $email = $_POST["email"];
            $nameFirst = $_POST["firstName"];
            $userId = $userInSystem->getId();

            $password = $_POST["pwd"];
            $passwordRepeat = $_POST["pwdRepeat"];

            $isValidProfileAction = EditUserValidator::check($nameFirst, $email, $password, $passwordRepeat);
            var_dump($_SESSION);
//            echo

            if ($isValidProfileAction) {

                $UserEntity = UserHelper::findUserFromId($userId);

                if ($UserEntity->getRole() === 'admin') {
                    $role_set = 2;
                } else {
                    $role_set = 1;
                }

                if (!UserHelper::checkUpdateUser($UserEntity->getNameFirst(), $UserEntity->getEmail(), $UserEntity->getId())) {
                    UserModel::updateUser($UserEntity->getId(), $nameFirst, $email, $role_set, $password);
                    $_SESSION["success"] = "success_edit";
                    $_SESSION["uid"] = $nameFirst;
                    unset ($_SESSION["try_profile_name_first"]);
                    unset ($_SESSION["try_profile_email"]);
//                    $this->redirect("users");
                } else {
                    $_SESSION["error"] = "user_or_mail_taken";
                }
            }
            $this->redirect("profile");
        }

        if (isset($_POST["deleteMyselfAvatar"])) {
            $userInSystem = UserHelper::findUser($_SESSION["uid"]);

            $target_dir = APP_ROOT_DIRECTORY . "/public/images/avatars/";
            if ($userInSystem->getAvatar()) {
                unlink(APP_ROOT_DIRECTORY . $userInSystem->getAvatar());
            }
            UserModel::addAvatar($_SESSION["uid"], "");
        }

        $row = $UsersEditService->getUserInSystem();
        require_once APP_ROOT_DIRECTORY . "app/Users/views/users/profile.php";
    }
}

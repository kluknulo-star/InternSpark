<?php

use app\Users\Models\UserModel;

require_once APP_ROOT_DIRECTORY . "app/Core/Helpers/UserHelper.php";
require_once APP_ROOT_DIRECTORY . "app/Users/Models/UserModel.php";

class UsersEditService
{


    public function getUserFromId($id)
    {
        return UserHelper::findUserFromId($id);
    }
    public function getUserInSystem()
    {
        return UserHelper::findUser($_SESSION["uid"]);
    }

    public function editUser(int $id,string $nameFirst,string $email,int $roleId,string $password = "") : bool
    {
        return UserModel::updateUser($id, $nameFirst, $email, $roleId, $password);
    }

}


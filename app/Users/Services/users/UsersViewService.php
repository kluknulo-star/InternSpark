<?php
require_once APP_ROOT_DIRECTORY . "app/Core/Helpers/UserHelper.php";

class   UsersViewService
{

    public function getUserFromId($id)
    {
        return UserHelper::findUserFromId($id);
    }

}


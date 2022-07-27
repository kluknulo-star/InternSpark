<?php
namespace app\Users\Services\users;

use app\Core\Helpers\UserHelper;

class   UsersViewService
{

    public function getUserFromId($id)
    {
        return UserHelper::findUserFromId($id);
    }

}


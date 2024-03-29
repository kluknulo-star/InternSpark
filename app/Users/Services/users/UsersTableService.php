<?php
namespace app\Users\Services\users;

use app\Core\Helpers\Pagination;
use app\Core\Helpers\UserHelper;
use app\Users\Entity\UserData;

class UsersTableService
{
    private function redirect($location, $error = "")
    {
        if ($error != "") {
            $_SESSION["error"] = $error;
        }
        header("location: ". "/" . $location);
        exit();
    }

    public function getUserInSystem()
    {
        return UserHelper::findUser($_SESSION["uid"]);
    }

    public function getUserFromId($id)
    {
        return UserHelper::findUserFromId($id);
    }

    public function getCountTableRecords($role="admin")
    {
        return UserData::getCountTableRecords($role);
    }

    public function sliceRead($start, $per_page, $role)
    {
        return UserData::sliceRead($start, $per_page, $role);
    }

    public function createPagination($page, $per_page, $total)
    {
        return new Pagination((int)$page, $per_page, $total);
    }

}


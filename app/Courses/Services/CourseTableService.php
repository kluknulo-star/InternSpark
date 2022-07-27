<?php
namespace app\Courses\Services;

use app\Core\Helpers\Pagination;
use app\Core\Helpers\UserHelper;
use app\Courses\Entity\CourseData;
use app\Users\Entity\UserData;

class CourseTableService
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

    public function getCountTableRecords(int $idAuthor, string $role="admin")
    {
        return CourseData::getCountCourseRecords($idAuthor, $role);
    }

    public function sliceRead($idAuthor, $start, $per_page, $role)
    {
        return CourseData::sliceRead($idAuthor, $start, $per_page, $role);
    }

    public function createPagination($page, $per_page, $total)
    {
        return new Pagination((int)$page, $per_page, $total);
    }

}


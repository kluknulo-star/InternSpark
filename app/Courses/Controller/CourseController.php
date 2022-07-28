<?php

namespace app\Courses\Controller;

use app\Core\Helpers\CourseHelper;
use app\Core\Helpers\Pagination;
use app\Courses\Entity\CourseData;

use app\Courses\Entity\SectionRecord;
use app\Courses\Model\SectionModel;
use app\Courses\Services\CourseTableService;
use app\Courses\Validator\AddCourseValidator;
use app\Users\Models\UserModel;

use app\Core\Helpers\UserHelper;
use app\Courses\Model\CourseModel;


class CourseController extends BaseController
{
    private function checkUserInSystem()
    {
        if (!UserHelper::isUserInSystem()) {
            $_SESSION["error"] = "access_denied";
            $this->redirect("login");
        }
    }

    private function checkPermission(int $courseId)
    {
        $courseRecord = CourseHelper::findCourseFromId($courseId);
        $userInSystem = UserHelper::findUser($_SESSION['uid']);
        if ($userInSystem->getId() != $courseRecord->getIdAuthor()) {
            $_SESSION["error"] = "access_denied";
            $this->redirect("courses");
            return true;
        }
    }

    public function index(array $params)
    {
        $this->checkUserInSystem();

        $userId = array_shift($params);
        $userInSystem = UserHelper::findUser($_SESSION["uid"]);
        $CourseData = new CourseData();
        $CourseTableService = new CourseTableService();

        require_once APP_ROOT_DIRECTORY . "app/Courses/views/table/table.php";
    }

    public function listIndex(array $params)
    {
        $this->checkUserInSystem();

        $userId = array_shift($params);
        $userInSystem = UserHelper::findUser($_SESSION["uid"]);
        $CourseData = new CourseData();

        $userInSystem = UserHelper::findUser($_SESSION["uid"]);
        $page = $_GET['page'] ?? 1;
        $per_page = 10;
        $total = CourseData::getAllCountCourseRecords($userInSystem->getRole());
        $_SESSION["allTable"] = "true";

        $pagination = new Pagination((int)$page, $per_page, $total);
        $start = $pagination->get_start();

        $sliceCourseData = CourseData::sliceReadAll($start, $per_page, $userInSystem->getRole());

        require_once APP_ROOT_DIRECTORY . "app/Courses/views/table/allTable.php";
    }

    public function create()
    {
        $this->checkUserInSystem();

        if (isset($_POST["submit"])) {

            $idAuthor = UserHelper::findUser($_SESSION["uid"])->getId();
            $title = htmlspecialchars($_POST["title"]);
            $description = htmlspecialchars($_POST["description"]);
            if (strlen(str_replace(" ", '',$_POST["title"])) && strlen(str_replace(" ", '',$_POST["description"]))) {
                CourseModel::createCourse($idAuthor, $title, $description);
                unset($_SESSION["try_title"]);
                unset($_SESSION["try_description"]);
                $this->redirect("courses");
            }
            else
            {
                $_SESSION["error"] = "empty_input";
            }
            $this->redirect("courses/create");
        }


        require_once APP_ROOT_DIRECTORY . "app/Courses/views/course.create.php";
    }

    public function view(array $params)
    {
        $courseId = array_shift($params);

        $this->checkUserInSystem();
        $courseRecord = CourseHelper::findCourseFromId($courseId);
        $sectionCourseDump = SectionModel::readCourseContent($courseId);

        require_once APP_ROOT_DIRECTORY . "app/Courses/views/course.view.php";
    }

    public function delete(array $params)
    {
        $courseId = array_shift($params);
        $this->checkUserInSystem();
        $this->checkPermission($courseId);

        CourseModel::deleteCourse($courseId);
        $this->redirect("courses");
    }

    public function restore(array $params)
    {
        $courseId = array_shift($params);
        $this->checkUserInSystem();
        $this->checkPermission($courseId);

        CourseModel::restoreCourse($courseId);
        $this->redirect("courses");
    }

    public function edit(array $params)
    {
        $courseId = array_shift($params);
        $this->checkUserInSystem();
        $this->checkPermission($courseId);

        $courseRecord = CourseHelper::findCourseFromId($courseId);

        if (isset($_POST["submit"])) {
            $title = htmlspecialchars($_POST["title"]);
            $description = htmlspecialchars($_POST["description"]);
            if (strlen(str_replace(" ", '', $_POST["title"])) && strlen(str_replace(" ", '', $_POST["description"]))) {
                CourseModel::updateCourse($courseId, $title, $description);
                unset($_SESSION["try_title"]);
                unset($_SESSION["try_description"]);
                $this->redirect("courses");
            } else {
                $_SESSION["error"] = "empty_input";
            }
        }

        require_once APP_ROOT_DIRECTORY . "app/Courses/views/course.edit.php";
    }

    public function listCards(array $params)
    {
        $courseId = array_shift($params);
        $this->checkUserInSystem();
        $this->checkPermission($courseId);
//        var_dump($params);
        $courseRecord = CourseHelper::findCourseFromId($courseId);
        $sectionCourseDump = SectionModel::readCourseContent($courseId);

        require_once APP_ROOT_DIRECTORY . "app/Courses/views/section/course.section.list.php";
    }

    public function createCard(array $params)
    {
        $courseId = array_shift($params);
        $this->checkUserInSystem();
        $this->checkPermission($courseId);

        if (isset($_POST["submit"])) {
            $contentType = htmlspecialchars($_POST['selectType']);
            $content = htmlspecialchars($_POST['textbox']);

            $sectionRecord = new SectionRecord($contentType, $content);
            SectionModel::createSectionCourse($courseId, $sectionRecord);

            $this->redirect("courses/$courseId/content");
        }


        require_once APP_ROOT_DIRECTORY . "app/Courses/views/section/course.section.create.php";
    }

    public function deleteCard(array $params)
    {
        $courseId = array_shift($params);
        $contentId = array_shift($params);
        $this->checkUserInSystem();
        $this->checkPermission($courseId);

        SectionModel::deleteSection($courseId, $contentId);
        $this->redirect("courses/$courseId/content");
        require_once APP_ROOT_DIRECTORY . "app/Courses/views/section/course.section.list.php";
    }

    public function editCard(array $params)
    {
        $courseId = array_shift($params);
        $contentId = array_shift($params);
        $this->checkUserInSystem();
        $this->checkPermission($courseId);

        $sectionContent = SectionModel::getSectionCourse($courseId, $contentId);

        if (isset($_POST["submit"])) {
            $contentType = htmlspecialchars($_POST['selectType']);
            $content = htmlspecialchars($_POST['textbox']);

            $sectionRecord = new SectionRecord($contentType, $content);
            SectionModel::editSectionCourse($courseId, $contentId, $sectionRecord);

            $this->redirect("courses/$courseId/content");
        }


//        SectionModel::deleteSection($courseId, $contentId);

        require_once APP_ROOT_DIRECTORY . "app/Courses/views/section/course.section.edit.php";
    }

}


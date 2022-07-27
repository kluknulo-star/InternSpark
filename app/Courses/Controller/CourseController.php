<?php

namespace app\Courses\Controller;
use app\Core\Helpers\CourseHelper;
use app\Courses\Entity\CourseData;

use app\Courses\Entity\SectionRecord;
use app\Courses\Model\SectionModel;
use app\Courses\Services\CourseTableService;
use app\Courses\Validator\AddCourseValidator;
use app\Users\Models\UserModel;

use app\Core\Helpers\UserHelper;
use app\Courses\Model\CourseModel;


class CourseController extends BaseController{
    private function checkUserInSystem()
    {
        if (!UserHelper::isUserInSystem())
        {
            $_SESSION["error"] = "access_denied";
            $this->redirect("login");
        }
    }

    private function checkPermission(int $courseId)
    {
        $courseRecord = CourseHelper::findUserFromId($courseId);
        $userInSystem = UserHelper::findUser($_SESSION['uid']);
        if ($userInSystem->getId() != $courseRecord->getIdAuthor()) {
            $_SESSION["error"] = "access_denied";
            $this->redirect("course");
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

    public function create()
    {
        $this->checkUserInSystem();

        if (isset($_POST["submit"])) {

            $idAuthor = UserHelper::findUser($_SESSION["uid"])->getId();
            $title = $_POST["title"];
            $description = $_POST["description"];
            if(AddCourseValidator::check($title, $description))
            {
                CourseModel::createCourse($idAuthor, $title, $description);
                unset($_SESSION["try_title"]);
                unset($_SESSION["try_description"]);
                $this->redirect("courses");
            }
            $this->redirect("courses/create");
        }


        require_once APP_ROOT_DIRECTORY . "app/Courses/views/course.create.php";
    }

    public function view(array $params)
    {
        $courseId = array_shift($params);

        $this->checkUserInSystem();
        $courseRecord = CourseHelper::findUserFromId($courseId);
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

        $CourseId = array_shift($params);

        $CourseRecord = CourseHelper::findUserFromId($CourseId);

        require_once APP_ROOT_DIRECTORY . "app/Courses/views/course.edit.php";
    }

//    public function addCards(array $params)
//    {
//        $courseId = array_shift($params);
//        $this->checkUserInSystem();
//        $this->checkPermission($courseId);
//
//        $newSection1 = new SectionRecord("text", "Hello, world");
//        $newSection2 = new SectionRecord("text", "GoodBye");
//        $inputObj = $newSection1;
//
//        $idCourse = 8;
//
//        $sectionCourseDump = SectionModel::readCourseContent($idCourse);
//
//        require_once APP_ROOT_DIRECTORY . "app/Courses/views/course.view.php";
//    }


    public function listCards(array $params)
    {
        $courseId = array_shift($params);
        $this->checkUserInSystem();
        $this->checkPermission($courseId);
//        var_dump($params);
        $courseRecord = CourseHelper::findUserFromId($courseId);
        $sectionCourseDump = SectionModel::readCourseContent($courseId);

        require_once APP_ROOT_DIRECTORY . "app/Courses/views/section/course.section.list.php";
    }

    public function createCard(array $params)
    {
        $courseId = array_shift($params);
        $this->checkUserInSystem();
        $this->checkPermission($courseId);

        if (isset($_POST["submit"])){
            $contentType = htmlspecialchars($_POST['selectType']);
            $content = htmlspecialchars($_POST['textbox']);

            $sectionRecord = new SectionRecord($contentType, $content);
            SectionModel::createSectionCourse($courseId, $sectionRecord);

            $this->redirect("courses/$courseId/content");
//            var_dump($contentType, $content);
        }


        require_once APP_ROOT_DIRECTORY . "app/Courses/views/section/course.section.create.php";
    }

}


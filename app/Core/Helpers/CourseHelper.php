<?php

namespace app\Core\Helpers;

use app\Courses\Entity\CourseRecord;
use config\DataBase;
use PDO;

class CourseHelper
{

    const FIND_COURSE_RECORD_FROM_ID = 'SELECT id_course , id_author, title, description, users.name_first, content, courses.deleted_at
                                                FROM users INNER JOIN courses ON users.id = courses.id_author 
                                                WHERE  id_course=? ORDER BY id_course DESC;';



    const IS_EXIST_ID = 'SELECT IF( EXISTS(SELECT id FROM users WHERE id= ?), 1, 0);';

    public static function findCourseFromId(int $id) : mixed
    {

        $statement = DataBase::connect()->prepare(self::FIND_COURSE_RECORD_FROM_ID);
        $statement->execute([$id]);
        $tableStatement = $statement->fetchAll(PDO::FETCH_ASSOC);
        $line = $tableStatement[0];
        if (empty($tableStatement)) {
            return false;
        }

        $courseId = $line["id_course"];
        $authorId = $line["id_author"];
        $title= $line["title"];
        $description = $line["description"] ?? "";
        $content= $line["content"];
        $deletedAt= $line["deleted_at"];
        $authorName= $line["name_first"];

        $record = new CourseRecord($courseId, $authorId, $title, $description, $authorName, $content, $deletedAt);
        return $record;
    }

    public static function isUserInSystem() : bool
    {
        return isset($_SESSION["uid"]);
    }

    public static function userIsAdmin() : bool
    {
        return UserHelper::findUser($_SESSION["uid"])->getRole() == "admin";
    }

    public static function isExistId($id)
    {
        $statement = DataBase::connect()->prepare(self::IS_EXIST_ID);

        if (!$statement->execute([$id])) {
            $statement = null;
            header("location: signup.php?error=statement_error_SET_USER");
            exit();
        }
        $row = $statement->fetch(PDO::FETCH_LAZY);
        return $row[0];
    }

    public static function checkUpdateUser($nameFirst, $email, $id)
    {
        $statement = DataBase::connect()
            ->prepare('SELECT IF( EXISTS(SELECT id FROM users WHERE (name_first= ? OR email = ?) AND NOT id=?), 1, 0);');

        if (!$statement->execute(array($nameFirst, $email, $id))) {
            $statement = null;
            return false;
        }
        $row = $statement->fetch(PDO::FETCH_LAZY);
        return $row[0];
    }

}
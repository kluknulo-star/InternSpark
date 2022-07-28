<?php

namespace app\Courses\Entity;

use config\DataBase;
use PDO;

class CourseData
{

    const COUNT_RECORDS = 'SELECT COUNT(*) FROM courses WHERE id_author=?;';
    const COUNT_RECORDS_FOR_USERS = 'SELECT COUNT(*) FROM courses WHERE id_author=? AND deleted_at IS NULL;';

    const UPDATE_COURSE_PROFILE = 'UPDATE courses SET content = ? WHERE id = ?;';

    const SOFT_DELETE = 'UPDATE courses SET deleted_at = NOW() WHERE id = ? AND deleted_at IS NULL;';

    const RECOVER_COURSE = 'UPDATE courses SET deleted_at = NULL WHERE id = ? AND deleted_at IS NOT NULL;';

    public static function getAllCountCourseRecords(string $role = "admin"): int
    {
        if ($role == 'admin') {

            $statement = DataBase::connect()->prepare('SELECT COUNT(*) FROM courses;');

        } else {
            $statement = DataBase::connect()->prepare("SELECT COUNT(*) FROM courses WHERE deleted_at IS NULL;");
        }

        $statement->execute();

        return $statement->fetchColumn();
    }

    public static function sliceReadAll(int $start, int $perPage, string $sessionRoleName = "admin"): array
    {
        if ($sessionRoleName == "admin") {
            $statement = DataBase::connect()
                ->query("SELECT id_course, id_author, title, description, users.name_first, content, courses.deleted_at
                                                FROM users INNER JOIN courses ON users.id = courses.id_author
                                                    ORDER BY id_course DESC LIMIT $start, $perPage;");
        } else {
            $statement = DataBase::connect()
                ->query("SELECT id_course , id_author, title, description, users.name_first, content, courses.deleted_at
                                                FROM users INNER JOIN courses ON users.id = courses.id_author 
                                                WHERE courses.deleted_at IS NULL ORDER BY id_course DESC LIMIT $start, $perPage");
        }

        $tableStatement = $statement->fetchAll(PDO::FETCH_ASSOC);

        $sliceRecords = [];
        foreach ($tableStatement as $line) {

            $idCourse = $line["id_course"];
            $idAuthor = $line["id_author"];
            $title = $line["title"];
            $nameFirst = $line["name_first"];
            $content = $line["content"];
            $deleted_at = $line["deleted_at"];
            $description = $line["description"];


            $record = new CourseRecord($idCourse, $idAuthor, $title, $description, $nameFirst, $content, $deleted_at);
            $sliceRecords[] = $record;

        }
        return $sliceRecords;
    }

    public static function getCountCourseRecords(int $idAuthor, string $role = "admin"): int
    {
        if ($role == 'admin') {

            $statement = DataBase::connect()->prepare(self::COUNT_RECORDS);

        } else {
            $statement = DataBase::connect()->prepare(self::COUNT_RECORDS_FOR_USERS);
        }

        $statement->execute([$idAuthor]);

        return $statement->fetchColumn();
    }


    public static function sliceRead(int $idAuthor, int $start, int $perPage, string $sessionRoleName = "admin"): array
    {
        if ($sessionRoleName == "admin") {
            $statement = DataBase::connect()
                ->query("SELECT id_course, id_author, title, description, users.name_first, content, courses.deleted_at
                                                FROM users INNER JOIN courses ON users.id = courses.id_author WHERE id_author=$idAuthor
                                                    ORDER BY id_course DESC LIMIT $start, $perPage;");
        } else {
            $statement = DataBase::connect()
                ->query("SELECT id_course , id_author, title, description, users.name_first, content, courses.deleted_at
                                                FROM users INNER JOIN courses ON users.id = courses.id_author 
                                                WHERE courses.deleted_at IS NULL AND id_author=$idAuthor ORDER BY id_course DESC LIMIT $start, $perPage");
        }

        $tableStatement = $statement->fetchAll(PDO::FETCH_ASSOC);

        $sliceRecords = [];
        foreach ($tableStatement as $line) {

            $idCourse = $line["id_course"];
            $idAuthor = $line["id_author"];
            $title = $line["title"];
            $nameFirst = $line["name_first"];
            $content = $line["content"];
            $deleted_at = $line["deleted_at"];
            $description = $line["description"];


            $record = new CourseRecord($idCourse, $idAuthor, $title, $description, $nameFirst, $content, $deleted_at);
            $sliceRecords[] = $record;

        }
        return $sliceRecords;
    }

    public static function update($content): void
    {
        $statement = DataBase::connect()->prepare(self::UPDATE_COURSE_PROFILE);
    }

    public static function delete($id)
    {
        // soft
        $statement = DataBase::connect()->prepare(self::SOFT_DELETE);
        $statement->execute([$id]);

    }

    public static function recover($id)
    {
        $statement = DataBase::connect()->prepare(self::RECOVER_COURSE);
        $statement->execute(array($id));
    }

    public static function getCourse(int $id)
    {
        $statement = DataBase::connect()->prepare(self::RECOVER_COURSE);
        $statement->execute(array($id));
    }

}

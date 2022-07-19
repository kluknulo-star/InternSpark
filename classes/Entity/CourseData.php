<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/classes/config/DataBasePDO.php";
require_once 'CourseRecord.php';

class CourseData extends DataBasePDO {

    const COUNT_RECORDS = 'SELECT COUNT(*) FROM courses WHERE id_author=?;';
    const COUNT_RECORDS_FOR_USERS = 'SELECT COUNT(*) FROM users WHERE deleted_at IS NULL AND id_author=?;';

    const UPDATE_COURSE_PROFILE = 'UPDATE courses SET content = ? WHERE id = ?;';

    const SOFT_DELETE = 'UPDATE courses SET deleted_at = NOW() WHERE id = ? AND deleted_at IS NULL;';

    const RECOVER_COURSE = 'UPDATE courses SET deleted_at = NULL WHERE id = ? AND deleted_at IS NOT NULL;';

    public function create()
    {
        // function create was realized in Signup.php
        return null;
    }

    public function getCountCourseRecords($idAuthor, $role="admin"): int
    {
        if ($role == 'admin')
        {
            $statement = $this->connect()->prepare(self::COUNT_RECORDS);
        } else {
            $statement = $this->connect()->prepare(self::COUNT_RECORDS_FOR_USERS);
        }

        $statement->execute([$idAuthor]);

        return $statement->fetchColumn();
    }


    public function sliceRead($idAuthor, $start, $perPage, $sessionRoleName="admin"): array
    {
        if ($sessionRoleName == "admin")
        {
            $statement = $this->connect()
                ->query("SELECT id_course, id_author, title, users.name_first, content, courses.deleted_at
                                                FROM users INNER JOIN courses ON users.id = courses.id_author WHERE id_author=$idAuthor
                                                    ORDER BY id ASC LIMIT $start, $perPage;");
        }
        else
        {
            $statement = $this->connect()
                ->query("SELECT id_course , id_author, title, users.name_first, content, courses.deleted_at
                                                FROM users INNER JOIN courses ON users.id = courses.id_author 
                                                WHERE courses.deleted_at IS NULL AND id_author=$idAuthor ORDER BY id ASC LIMIT $start, $perPage");
        }

        $tableStatement = $statement->fetchAll(PDO::FETCH_ASSOC);

        $sliceRecords = [];
        foreach($tableStatement as $line)
        {

            $idCourse = $line["id_course"];
            $idAuthor = $line["id_author"];
            $title= $line["title"];
            $nameFirst = $line["name_first"];
            $content= $line["content"];
            $deleted_at = $line["deleted_at"];


            $record = new CourseRecord($idCourse, $idAuthor, $title, $nameFirst, $content, $deleted_at);
            $sliceRecords[] = $record;

        }
        return $sliceRecords;
    }

    public function update($content): void
    {
        $statement = $this->connect()->prepare(self::UPDATE_COURSE_PROFILE);
    }

    public function delete($id)
    {
        // soft
        $statement = $this->connect()->prepare(self::SOFT_DELETE);
        $statement->execute([$id]);

    }

    public function recover($id)
    {
        $statement = $this->connect()->prepare(self::RECOVER_COURSE);
        $statement->execute(array($id));
    }

}

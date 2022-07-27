<?php
namespace app\Courses\Model;
use config\DataBase;
use PDO;

class SectionModel
{
    public static function readCourseContent(int $idCourse) : array | null
    {
        $statement = DataBase::connect()
            ->prepare('SELECT content FROM courses WHERE id_course=?;');
        $statement->execute([$idCourse]);
        $contentStatement = $statement->fetch(PDO::FETCH_LAZY);
        $line = $contentStatement[0];
        if ($line)
            $line = json_decode($line, true);
        return $line;
    }


    public static function createSectionCourse(int $idCourse,mixed $contentInput) : bool
    {

        $jsonContent = SectionModel::readCourseContent($idCourse);

        array_unshift($jsonContent, $contentInput);
//        $jsonContent[] = $contentInput;

        $jsonContent = json_encode($jsonContent);

        $statement = DataBase::connect()
            ->prepare("UPDATE courses SET content=? WHERE id_course=?;");
//        var_dump($jsonContent);
        return $statement->execute([$jsonContent, $idCourse]);

    }

    public static function updateCourseContent($content, $id){
        $statement = DataBase::connect()
            ->prepare('UPDATE courses SET content=? WHERE id_course=?;');

        return $statement->execute([$content, $id]);
    }

    public static function updateCourseAuthor($title, $description, $id){
        $statement = DataBase::connect()
            ->prepare('UPDATE courses SET title=?, description=? WHERE id_course=?;');

        return $statement->execute([$title, $description, $id]);
    }

    public static function deleteCourse($id){
        $statement = DataBase::connect()
            ->prepare('UPDATE courses SET deleted_at=NOW() WHERE id_course=? AND deleted_at IS NULL;');

        return $statement->execute([$id]);
    }

    public static function recoverCourse($id){
        $statement = DataBase::connect()
            ->prepare('UPDATE courses SET deleted_at=NULL WHERE id_course=? AND deleted_at IS NOT NULL;');

        return $statement->execute([$id]);

    }



}
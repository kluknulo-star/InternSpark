<?php
namespace app\Courses\Model;
use config\DataBase;

class CourseModel
{
    public static function createCourse($idAuthor, $title, $description){
        $statement = DataBase::connect()
//            ->prepare('UPDATE courses SET title=?, description=?;');
            ->prepare('INSERT INTO courses(id_author, title, description) VALUES (?,?,?);');

        return $statement->execute([$idAuthor, $title, $description]);
    }

    public static function updateCourseContent($content, $id){
        $statement = DataBase::connect()
            ->prepare('UPDATE courses SET content=? WHERE id_course=?;');

        return $statement->execute([$content, $id]);
    }

    public static function updateCourse($id, $title, $description){
        $statement = DataBase::connect()
            ->prepare('UPDATE courses SET title=?, description=? WHERE id_course=?;');

        return $statement->execute([$title, $description, $id]);
    }

    public static function deleteCourse($id){
        $statement = DataBase::connect()
            ->prepare('UPDATE courses SET deleted_at=NOW() WHERE id_course=? AND deleted_at IS NULL;');

        return $statement->execute([$id]);
    }

    public static function restoreCourse($id){
        $statement = DataBase::connect()
            ->prepare('UPDATE courses SET deleted_at=NULL WHERE id_course=? AND deleted_at IS NOT NULL;');

        return $statement->execute([$id]);

    }



}
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

        if ($jsonContent)
        {
            array_unshift($jsonContent, $contentInput);
        }
        else
        {
            $jsonContent[] = $contentInput;
        }

//        $jsonContent[] = $contentInput;

        $jsonContent = json_encode($jsonContent);

        return SectionModel::updateCourseContent($jsonContent, $idCourse);
    }

    public static function updateCourseContent($content, $id) : bool
    {
        $statement = DataBase::connect()
            ->prepare('UPDATE courses SET content=? WHERE id_course=?;');

        return $statement->execute([$content, $id]);
    }

    public static function updateCourse($title, $description, $id){
        $statement = DataBase::connect()
            ->prepare('UPDATE courses SET title=?, description=? WHERE id_course=?;');

        return $statement->execute([$title, $description, $id]);
    }

    public static function deleteSection($idCourse, $idSection){
        $allSectionCourse = SectionModel::readCourseContent($idCourse);

        foreach ($allSectionCourse as $key => $section)
        {
            if ($section['sectionId'] == $idSection) {
                unset($allSectionCourse[$key]);
            }
        }

        $jsonContent = json_encode($allSectionCourse);

        return SectionModel::updateCourseContent($jsonContent, $idCourse);
    }

    public static function editSectionCourse($idCourse, $idSection, $content){
        $allSectionCourse = SectionModel::readCourseContent($idCourse);

        foreach ($allSectionCourse as $key => $section)
        {
            if ($section['sectionId'] == $idSection) {
                $allSectionCourse[$key] = $content;
//                unset($allSectionCourse[$key]);
             var_dump($section);
            }
        }

        $jsonContent = json_encode($allSectionCourse);

        return SectionModel::updateCourseContent($jsonContent, $idCourse);
    }

    public static function getSectionCourse($idCourse, $idSection) : string
    {
        $allSectionCourse = SectionModel::readCourseContent($idCourse);

        foreach ($allSectionCourse as $key => $section)
        {
            if ($section['sectionId'] == $idSection) {
                return $allSectionCourse[$key]['content'];
            }
        }
        return "";
    }


}
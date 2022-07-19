<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/classes/config/DataBasePDO.php";

class EditCourse extends DataBasePDO
{
    public function updateCourse($title, $content, $id){
        $statement = $this->connect()
            ->prepare('UPDATE courses SET title=?, content=? WHERE id_course=?;');

        if (!$statement->execute(array($title, $content, $id))) {
            $statement = null;
            header("location: signup.php?error=statement_error_SET_USER");
            exit();
        }
    }

    public function deleteCourse($id){
        $statement = $this->connect()
            ->prepare('UPDATE courses SET deleted_at=NOW() WHERE id_course=? AND deleted_at IS NULL;');

        if (!$statement->execute([$id])) {
            $statement = null;
            header("location: signup.php?error=statement_error_SET_USER");
            exit();
        }
    }

    public function recoverCourse($id){
        $statement = $this->connect()
            ->prepare('UPDATE courses SET deleted_at=NULL WHERE id_course=? AND deleted_at IS NOT NULL;');

        if (!$statement->execute([$id])) {
            $statement = null;
            header("location: signup.php?error=statement_error_SET_USER");
            exit();
        }
    }



}
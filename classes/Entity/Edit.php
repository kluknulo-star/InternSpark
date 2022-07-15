<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/classes/DataBaseConnection/DataBasePDO.php";

class Edit extends DataBasePDO
{
    protected function updateUser($id, $nameFirst, $email, $password, $roleId){
        $statement = $this->connect()
            ->prepare('UPDATE users SET name_first=?, email=?,password=?,role_id=? WHERE id=?;');

        if (!$statement->execute(array($nameFirst, $email, $password, $roleId, $id))) {
            $statement = null;
            header("location: signup.php?error=statement_error_SET_USER");
            exit();
        }
    }

    protected function updateMyself($id, $nameFirst, $email, $password){
        $statement = $this->connect()
            ->prepare('UPDATE users SET name_first=?, email=?,password=? WHERE id=?;');

        if (!$statement->execute(array($nameFirst, $email, $password, $id))) {
            $statement = null;
            header("location: signup.php?error=statement_error_SET_USER");
            exit();
        }
    }

    protected function isMyself($id, $nameFirst, $email, $roleId=""){
        $statement = $this->connect()
            ->prepare('SELECT IF( EXISTS(SELECT id FROM users WHERE name_first= ? AND email = ? AND id =? AND role_id=?), 1, 0);');

        if (!$statement->execute(array($nameFirst, $email, $id, $roleId))) {
            $statement = null;
            header("location: signup.php?error=statement_error_SET_USER");
            exit();
        }
        $row = $statement->fetch(PDO::FETCH_LAZY);
        return $row[0];
    }

    protected function isMyselfProfile($id, $nameFirst, $email){
        $statement = $this->connect()
            ->prepare('SELECT IF( EXISTS(SELECT id FROM users WHERE name_first= ? AND email = ? AND id =?), 1, 0);');

        if (!$statement->execute(array($nameFirst, $email, $id))) {
            $statement = null;
            header("location: signup.php?error=statement_error_SET_USER");
            exit();
        }
        $row = $statement->fetch(PDO::FETCH_LAZY);
        return $row[0];
    }
    protected function checkUser($nameFirst, $email, $id)
    {
        $statement = $this->connect()
            ->prepare('SELECT IF( EXISTS(SELECT id FROM users WHERE (name_first= ? OR email = ?) AND NOT id=?), 1, 0);');

        if (!$statement->execute(array($nameFirst, $email, $id))) {
            $statement = null;
            header("location: signup.php?error=statement_error_CHECK_USER");
            exit();
        }
        $row = $statement->fetch(PDO::FETCH_LAZY);
        return $row[0];
    }

}
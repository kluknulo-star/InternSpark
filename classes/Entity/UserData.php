<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/classes/DataBaseConnection/DataBasePDO.php";
require_once 'UserRecord.php';

class UserData extends DataBasePDO {


    const READ_ALL = 'SELECT id,name_first, email, password, deleted_at, role_name  FROM users INNER JOIN roles using(role_id);';
    const READ_SLICE = 'SELECT id,name_first, email, password, deleted_at, role_name  FROM users 
                        INNER JOIN roles using(role_id) LIMIT ?, ?;';

    const COUNT_RECORDS = 'SELECT COUNT(*) FROM users';

    const UPDATE_USER_PROFILE = 'UPDATE users SET name_first = ?, email = ?, role_id = ? WHERE id = ?;';
    const UPDATE_USER_PROFILE_WITH_PASSWORD = 'UPDATE users SET name_first = ?, email = ?, role_id = ?, password =? WHERE id = ?;';
//    const UPDATE_ID_ADMIN = 'UPDATE users SET name_first = ?, email = ?, role_id = 2 WHERE id = ?;';

    const SOFT_DELETE = 'UPDATE users SET deleted_at = NOW() WHERE id = ? AND deleted_at IS NULL;';

    const RECOVER_USER = 'UPDATE users SET deleted_at = NULL WHERE id = ? AND deleted_at IS NOT NULL;';

    const CHECK_USER = ' ';
    
    public function create()
    {
        // function create was realized in Signup.php
        return null;
    }

    public function getCountTableRecords($table="users"): int
    {
        $statement = $this->connect()->prepare(self::COUNT_RECORDS);
        $statement->execute();

        return $statement->fetchColumn();
    }

    public function getCurrentUser($uid)
    {
        $statement = $this->connect()->prepare("SELECT id,name_first, email, password, deleted_at, role_name, avatar  
                                                FROM users INNER JOIN roles using(role_id) WHERE email=? OR name_first=?;");

        $statement->execute(array($uid, $uid));
        $tableStatement = $statement->fetchAll(PDO::FETCH_ASSOC);
        $line = $tableStatement[0];

        $id = $line["id"];
        $nameFirst = $line["name_first"];
        $email= $line["email"];
        $password= $line["password"];
        $deleted_at= $line["deleted_at"];
        $role_name= $line["role_name"];
        $avatar= $line["avatar"];

        $record = new UserRecord($id, $nameFirst, $email, $password,$deleted_at, $role_name, $avatar);
        return $record;
    }

    public function sliceRead($start, $perPage, $sessionRoleName): array
    {
        if ($sessionRoleName == "admin")
        {
            $statement = $this->connect()->query("SELECT id,name_first, email, password, deleted_at, role_name, avatar  
                                                FROM users INNER JOIN roles using(role_id) ORDER BY id DESC LIMIT $start, $perPage ");
        }
        else
        {
            $statement = $this->connect()->query("SELECT id,name_first, email, password, deleted_at, role_name, avatar
                                                FROM users INNER JOIN roles using(role_id) WHERE deleted_at IS NULL ORDER BY id DESC LIMIT $start, $perPage");


        }

        $tableStatement = $statement->fetchAll(PDO::FETCH_ASSOC);

        $sliceRecords = [];
        foreach($tableStatement as $line)
        {

            $id = $line["id"];
            $nameFirst = $line["name_first"];
            $email= $line["email"];
            $password= $line["password"];
            $deleted_at= $line["deleted_at"];
            $role_name= $line["role_name"];
            $avatar=$line["avatar"];

            $record = new UserRecord($id, $nameFirst, $email, $password,$deleted_at, $role_name, $avatar);
            $sliceRecords[] = $record;

        }
        return $sliceRecords;
    }

    public function update($id, $nameFirst, $email, $setAdmin = 1, $new_password=""): void
    {
        // update
        if ($new_password)
        {
            $statement = $this->connect()->prepare(self::UPDATE_USER_PROFILE_WITH_PASSWORD);
        }
        else{
            $statement = $this->connect()->prepare(self::UPDATE_USER_PROFILE);
        }

    }

    public function delete($id)
    {
        // soft
        $statement = $this->connect()->prepare(self::SOFT_DELETE);
        $statement->execute(array($id));

    }

    public function recover($id)
    {
        $statement = $this->connect()->prepare(self::RECOVER_USER);
        $statement->execute(array($id));
    }

}

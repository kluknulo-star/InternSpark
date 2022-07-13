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
//    const UPDATE_ID_ADMIN = 'UPDATE users SET name_first = ?, email = ?, role_id = 2 WHERE id = ?;';

    const SOFT_DELETE = 'UPDATE users SET deleted_at = NOW() WHERE id = ?;';

    const RECOVER_USER = 'UPDATE users SET deleted_at = NULL WHERE id = ?;';
    
    public function create()
    {
        // function create was realized in Signup.php
        return null;
    }

//    public function read()
//    {
//        $statement = $this->connect()->prepare(self::READ_ALL);
//        $statement->execute();
//        $tableStatement = $statement->fetchAll(PDO::FETCH_ASSOC);
//
//        $allRecords = [];
//        foreach($tableStatement as $line)
//        {
//
//            $id = $line["id"];
//            $nameFirst = $line["name_first"];
//            $email= $line["email"];
//            $password= $line["password"];
//            $deleted_at= $line["deleted_at"];
//            $role_name= $line["role_name"];
//
//            $record = new UserRecord($id, $nameFirst, $email, $password,$deleted_at, $role_name);
//            $allRecords[] = $record;
//
//        }
//        return $allRecords;
//    }
    public function getCountTableRecords($table="users"): int
    {
        $statement = $this->connect()->prepare(self::COUNT_RECORDS);
        $statement->execute();

        return $statement->fetchColumn();
    }

    public function sliceRead($start, $perPage, $sessionRoleName): array
    {
        if ($sessionRoleName == "admin")
        {
            $statement = $this->connect()->query("SELECT id,name_first, email, password, deleted_at, role_name  
                                                FROM users INNER JOIN roles using(role_id) LIMIT $start, $perPage");
        }
        else
        {
            $statement = $this->connect()->query("SELECT id,name_first, email, password, deleted_at, role_name  
                                                FROM users INNER JOIN roles using(role_id) WHERE deleted_at IS NULL LIMIT $start, $perPage");
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

            $record = new UserRecord($id, $nameFirst, $email, $password,$deleted_at, $role_name);
            $sliceRecords[] = $record;

        }
        return $sliceRecords;
    }

    public function update($id, $nameFirst, $email, $setAdmin = 1): void
    {
        // update
        $statement = $this->connect()->prepare(self::UPDATE_USER_PROFILE);
        $statement->execute(array($nameFirst, $email, $setAdmin, $id));
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

<?php

namespace app\Users\Entity;

use config\DataBase;
use PDO;

class UserData {

    const COUNT_RECORDS = 'SELECT COUNT(*) FROM users;';
    const COUNT_RECORDS_FOR_USERS = 'SELECT COUNT(*) FROM users WHERE deleted_at IS NULL';


//    private static $pdh = DataBase::connect();


    public static function  getCountTableRecords($role="admin"): int
    {
        if ($role == 'admin')
        {
            $statement = DataBase::connect()->prepare(self::COUNT_RECORDS);
        } else {
            $statement = DataBase::connect()->prepare(self::COUNT_RECORDS_FOR_USERS);
        }

        $statement->execute();

        return $statement->fetchColumn();
    }

    public static function sliceRead($start, $perPage, $sessionRoleName): array
    {
        if ($sessionRoleName == "admin")
        {
            $statement = DataBase::connect()->query("SELECT id,name_first, email, password, deleted_at, role_name, avatar  
                                                FROM users INNER JOIN roles using(role_id) ORDER BY id DESC LIMIT $start, $perPage ");
        }
        else
        {
            $statement = DataBase::connect()->query("SELECT id,name_first, email, password, deleted_at, role_name, avatar
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

}

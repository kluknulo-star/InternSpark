<?php

namespace app\Core\Helpers;

use app\Users\Entity\UserRecord;
use config\DataBase;
use PDO;

class   UserHelper extends DataBase
{

    const FIND_USER_RECORD = 'SELECT id,name_first, email, password, deleted_at, role_name, avatar  
                                                FROM users INNER JOIN roles using(role_id) WHERE email=? OR name_first=?;';
    const FIND_USER_RECORD_FROM_ID = 'SELECT id,name_first, email, password, deleted_at, role_name, avatar  
                                                FROM users INNER JOIN roles using(role_id) WHERE id=?;';

     const ADD_IMAGE = 'UPDATE users SET avatar=? WHERE email=? OR name_first=?;';

     const DELETE_IMAGE = 'UPDATE users SET avatar="" WHERE (email=? OR name_first=?)';

     const IS_EXIST_ID = 'SELECT IF( EXISTS(SELECT id FROM users WHERE id= ?), 1, 0);';


    public static function findUser($uid)
    {

        $statement = DataBase::connect()->prepare(self::FIND_USER_RECORD);
        $statement->execute([$uid, $uid]);
        $tableStatement = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (empty($tableStatement)) {
            return null;
        }

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

    public static function findUserFromId($id)
    {

        $statement = DataBase::connect()->prepare(self::FIND_USER_RECORD_FROM_ID);
        $statement->execute([$id]);
        $tableStatement = $statement->fetchAll(PDO::FETCH_ASSOC);
        $line = $tableStatement[0];
        if (empty($tableStatement)) {
            return null;
        }

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

    public static function isUserInSystem() : bool
    {
        return isset($_SESSION["uid"]);
    }

    public static function idUserInSystem() : string
    {
        return $_SESSION["uid"];
    }

    public static function userIsAdmin() : bool
    {
        return UserHelper::findUser($_SESSION["uid"])->getRole() == "admin";
    }

    public static function isExistId($id)
    {
        $statement = DataBase::connect()->prepare(self::IS_EXIST_ID);

        if (!$statement->execute([$id])) {
            $statement = null;
            header("location: signup.php?error=statement_error_SET_USER");
            exit();
        }
        $row = $statement->fetch(PDO::FETCH_LAZY);
        return $row[0];
    }

    public static function checkUpdateUser($nameFirst, $email, $id)
    {
        $statement = DataBase::connect()
            ->prepare('SELECT IF( EXISTS(SELECT id FROM users WHERE (name_first= ? OR email = ?) AND NOT id=?), 1, 0);');

        if (!$statement->execute(array($nameFirst, $email, $id))) {
            $statement = null;
            return false;
        }
        $row = $statement->fetch(PDO::FETCH_LAZY);
        return $row[0];
    }

}
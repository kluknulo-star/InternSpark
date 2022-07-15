<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/classes/DataBaseConnection/DataBasePDO.php";
require_once "$root/classes/Entity/UserRecord.php";

class UserHelper extends DataBasePDO
{

    const FIND_USER_RECORD = 'SELECT id,name_first, email, password, deleted_at, role_name, avatar  
                                                FROM users INNER JOIN roles using(role_id) WHERE email=? OR name_first=?;';

     const ADD_IMAGE = 'UPDATE users SET avatar=? WHERE email=? OR name_first=?;';

     const DELETE_IMAGE = 'UPDATE users SET avatar="" WHERE (email=? OR name_first=?)';


    public static function findUser($uid)
    {

        $statement = DataBasePDO::connect()->prepare(self::FIND_USER_RECORD);
        $statement->execute([$uid, $uid]);
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

    public static function addAvatar($uid, $avatar)
    {
        $statement = DataBasePDO::connect()->prepare(self::ADD_IMAGE);
        $statement->execute([$avatar, $uid, $uid]);
    }
    public static function deleteAvatar($uid)
    {
        $statement = DataBasePDO::connect()->prepare(self::DELETE_IMAGE);
        $statement->execute([$uid, $uid]);
    }

}
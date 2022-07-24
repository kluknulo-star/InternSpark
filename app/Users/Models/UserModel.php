<?php
namespace app\Users\Models;
// get user
// create user

use DataBase;
use PDO;

require_once APP_ROOT_DIRECTORY . '/config/DataBase.php';

class UserModel
{

    public static function loginUser(string $uid, string $password) : bool
    {

        $statement = DataBase::connect()
            ->prepare('SELECT name_first, password, role_name, deleted_at FROM users 
                             INNER JOIN roles USING(role_id) WHERE name_first = ? OR email = ?');

        if (!$statement->execute([$uid, $uid])) {
            $statement = null;
            $_SESSION["error"] = "error_database";
            return false;
        }

        if ($statement->rowCount() == 0)
        {
            $_SESSION["error"] = "incorrect_user_or_password";
            return false;
        }

        $tableStatement = $statement->fetchAll(PDO::FETCH_ASSOC);
        $checkPassword = password_verify($password, $tableStatement[0]["password"]);

        if ($tableStatement[0]["deleted_at"])
        {
            $_SESSION["error"] = "incorrect_user_or_password";
            return false;
        }

        if ($checkPassword)
        {
            $_SESSION["uid"] = $tableStatement[0]["name_first"];
            $_SESSION["role_name"] = $tableStatement[0]["role_name"];
            return true;
        }

        $_SESSION["error"] = "incorrect_user_or_password";
        return false;

    }

    public static function updateUser(int $id,string $nameFirst,string $email,int $roleId,string $password = "") : bool
    {
        if ($password){
            $password = password_hash($password, PASSWORD_DEFAULT);
            $statement = DataBase::connect()
                ->prepare('UPDATE users SET name_first=?, email=?,password=?,role_id=? WHERE id=?;');

            if (!$statement->execute(array($nameFirst, $email, $password, $roleId, $id))) {
                $statement = null;
                return false;
            }
        }
        else
        {
            $statement = DataBase::connect()
                ->prepare('UPDATE users SET name_first=?, email=?,role_id=? WHERE id=?;');

            if (!$statement->execute(array($nameFirst, $email, $roleId, $id))) {
                $statement = null;
                return false;
            }
        }
        return true;
    }

    public static function createUser(string $nameFirst,string $email,string $password, int $roleId = 1) : bool
    {
        $statement = DataBase::connect()
            ->prepare('INSERT INTO users(name_first, email, password, role_id) VALUES (?,?,?,?)');

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (!$statement->execute(array($nameFirst, $email, $hashedPassword, $roleId))) {
            $statement = null;
            $_SESSION["error"] = "error_database";
            return false;
        }
        return true;
    }

    public static function delete(int $id) : bool
    {
        // soft
        $statement = DataBase::connect()->prepare("UPDATE users SET deleted_at = NOW() WHERE id = ? AND deleted_at IS NULL;");
        if (!$statement->execute([$id]))
        {
            $_SESSION["error"] = "error_database";
            return false;
        }
        return true;
    }

    public static function restore(int $id) : bool
    {
        $statement = DataBase::connect()->prepare('UPDATE users SET deleted_at = NULL WHERE id = ? AND deleted_at IS NOT NULL;');
        if (!$statement->execute([$id]))
        {
            $_SESSION["error"] = "error_database";
            return false;
        }
        return true;
    }



}

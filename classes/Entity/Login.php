<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include_once "$root/classes/DataBaseConnection/DataBasePDO.php";
require_once "$root/includes/session/session.php";

class Login extends DataBasePDO {

    protected function getUser($uid, $password){

        $statement = $this->connect()
            ->prepare('SELECT name_first, password, role_name, deleted_at FROM users 
                             INNER JOIN roles USING(role_id) WHERE name_first = ? OR email = ?');

        $location = '/login';

        if (!$statement->execute(array($uid, $uid))) {
            $statement = null;
            header("location: $location?error=statement_error_GET_USER");
            exit();
        }

        if ($statement->rowCount() == 0)
        {
            $statement = null;
            $_SESSION["error"] = "user_not_found";
            header("location: $location");
            exit();
        }

        $tableStatement = $statement->fetchAll(PDO::FETCH_ASSOC);
        $checkPassword = password_verify($password, $tableStatement[0]["password"]);

        if ($tableStatement[0]["deleted_at"])
        {
            $statement = null;
            $_SESSION["error"] = "incorrect_user_or_password";
            header("location: $location");
            exit();
        }

        if ($checkPassword)
        {
          $_SESSION["uid"] = $tableStatement[0]["name_first"];
          $_SESSION["role_name"] = $tableStatement[0]["role_name"];
        }
        else
        {
            $statement = null;
            $_SESSION["error"] = "incorrect_user_or_password";
            header("location: $location");
            exit();
        }
    }
}
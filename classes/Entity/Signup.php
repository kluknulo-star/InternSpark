<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/classes/DataBaseConnection/DataBasePDO.php";

class Signup extends DataBasePDO {

    protected function setUser($nameFirst, $email, $password){
        $statement = $this->connect()
                      ->prepare('INSERT INTO users(name_first, email, password, role_id) VALUES (?,?,?,?)');

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (!$statement->execute(array($nameFirst, $email, $hashedPassword, 1))) {
            $statement = null;
            header("location: signup.php?error=statement_error_SET_USER");
            exit();
        }

    }

    protected function checkUser($nameFirst, $email)
    {
        $statement = $this->connect()->prepare('SELECT IF( EXISTS(SELECT id FROM users WHERE name_first= ? OR email = ?), 1, 0);');

//        $statement = $this->connect()->prepare('SELECT id FROM users WHERE name_first= ? OR email = ?;');
        //exist
        if (!$statement->execute(array($nameFirst, $email))) {
            $statement = null;
            header("location: signup.php?error=statement_error_CHECK_USER");
            exit();
        }

        $row = $statement->fetch(PDO::FETCH_LAZY);
        return $row[0];
    }


}
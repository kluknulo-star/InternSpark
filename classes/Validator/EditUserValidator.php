<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/classes/Entity/UserData.php";
require_once "$root/classes/Validator/Validation.php";
require_once "$root/classes/Entity/Edit.php";

class EditUserValidator extends Edit {

    private int $id;
    private string $nameFirst;
    private string $email;
    private string $password;
    private string $passwordRepeat;
    private string $roleSet;

    public function __construct($id, $nameFirst, $email, $password, $passwordRepeat, $roleSet){
        $this->id = $id;
        $this->nameFirst = $nameFirst;
        $this->email = $email;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;
        $this->roleSet = $roleSet;
    }

    public function editUser()
    {



        $_SESSION["try_create_name_first"] = $this->nameFirst;
        $_SESSION["try_create_email"] = $this->email;
        $location='/users';

        if ($this->isMyself($this->id, $this->nameFirst, $this->email, $this->roleSet)){
            $_SESSION["error"] = "old_input";
            header("location: $location");
            exit();
        }

        if(!Validation::isValidNameFirst($this->nameFirst)) {
            // echo "Invalid NameFirst";
            $_SESSION["error"] = "invalid_uid";
            header("location: $location");
            exit(); //check
        }

        if(!Validation::isValidEmail($this->email)) {
            // echo "Invalid email";
            $_SESSION["error"] = "invalid_uid";
            header("location: $location");
            exit();
        }

        if(!Validation::isPasswordMatch($this->password, $this->passwordRepeat)) {
            // echo "Passwords don't match! ";
            $_SESSION["error"] = "password_doesnt_match";
            header("location: $location");
            exit();
        }


        if (!($this->password == "" && $this->passwordRepeat == ""))
        {

            if ((!Validation::isValidPassword($this->password)) && !($this->password == "" && $this->password == ""))
            {
                // echo "Invalid email";
                $_SESSION["error"] = "incorrect_format_password";
                header("location: $location");
                exit();
            }
            else
                $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }

        if($this->uidTakenCheck()) {
            echo "uidTakenCheck";
            $_SESSION["error"] = "user_or_mail_taken";
            header("location: $location");
            exit();
        }

        if ($this->password == "" && $this->passwordRepeat == "") {
            $this->updateUserWithoutPassword($this->id, $this->nameFirst, $this->email, $this->roleSet);
        } else {
            $this->updateUser($this->id, $this->nameFirst, $this->email, $this->password, $this->roleSet);
        }
    }

    private function uidTakenCheck() : bool
    {
        return $this->checkUser($this->nameFirst, $this->email, $this->id);
    }

}
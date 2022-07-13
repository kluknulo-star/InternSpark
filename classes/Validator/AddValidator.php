<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/classes/Entity/Signup.php";
require_once "$root/classes/Validator/Validation.php";
require_once "$root/includes/session/session.php";



class AddValidator extends Signup {

    private string $nameFirst;
    private string $email;
    private string $password;
    private string $passwordRepeat;

    public function __construct($nameFirst, $password, $passwordRepeat, $email){
        $this->nameFirst = $nameFirst;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;
        $this->email = $email;
    }

    public function addUser()
    {

        $location = "/InternSpark/src/page/table.php";

        $_SESSION["try_create_name_first"] = $this->nameFirst;
        $_SESSION["try_create_email"] = $this->email;

        if(!Validation::isFullInput($this->nameFirst, $this->password, $this->passwordRepeat, $this->email)) {
            // echo "Empty input";
            $_SESSION["error"] = "empty_input";
            header("location: $location");//вернуть ошибку
            exit();
        }
        if(!Validation::isValidNameFirst($this->nameFirst)) {
            // echo "Invalid NameFirst";
            $_SESSION["error"] = "invalid_uid";
            header("location: $location");
            exit();
        }

        if(!Validation::isValidEmail($this->email)) {
            // echo "Invalid email";
            $_SESSION["error"] = "invalid_uid";
            header("location: $location");
            exit();
        }

        if(!Validation::isValidPassword($this->password)) {
            // echo "Invalid email";
            $_SESSION["error"] = "incorrect_format_password";
            header("location: $location");
            exit();
        }

        if(!Validation::isPasswordMatch($this->password, $this->passwordRepeat)) {
            // echo "Passwords don't match! ";
            $_SESSION["error"] = "password_doesnt_match";
            header("location: $location");
            exit();
        }

        if($this->uidTakenCheck()) {
            // echo "Invalid Username or email taken";
            $_SESSION["error"] = "user_or_mail_taken";
            header("location: $location");
            exit();
        }


        $this->setUser($this->nameFirst, $this->email, $this->password);
    }

    private function uidTakenCheck(){

        return $this->checkUser($this->nameFirst, $this->email);
    }
}
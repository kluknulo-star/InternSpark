<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/classes/Entity/Signup.php";
require_once "$root/classes/Validator/Validation.php";

class SignupValidator extends Signup {

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

    public function signupUser()
    {

        $location = "../src/page/registration.php";

        $_SESSION["try_signup_name_first"] = $this->nameFirst;
        $_SESSION["try_signup_email"] = $this->email;



        if(!Validation::isFullInput($this->nameFirst, $this->password, $this->passwordRepeat, $this->email)) {
            // echo "Empty input";
            header("location: $location?error=empty_input");
            exit();
        }
        if(!Validation::isValidNameFirst($this->nameFirst)) {
            // echo "Invalid NameFirst";
            header("location: $location?error=invalid_uid");
            exit();
        }

        if(!Validation::isValidEmail($this->email)) {
            // echo "Invalid email";
            header("location: $location?error=invalid_uid");
            exit();
        }

        if(!Validation::isValidPassword($this->password)) {
            // echo "Invalid email";
            header("location: $location?error=incorrect_format_password");
            exit();
        }

        if(!Validation::isPasswordMatch($this->password, $this->passwordRepeat)) {
            // echo "Passwords don't match! ";
            header("location: $location?error=password_doesnt_match");
            exit();
        }



        if($this->uidTakenCheck()) {
            // echo "Invalid Username or email taken";
            header("location: $location?error=user_or_mail_taken");
            exit();
        }


        $this->setUser($this->nameFirst, $this->email, $this->password);
    }

    private function uidTakenCheck() : bool
    {
        return $this->checkUser($this->nameFirst, $this->email);
    }
}
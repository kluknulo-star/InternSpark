<?php
namespace app\Users\Validator;

class AddUserValidator{

    private string $nameFirst;
    private string $email;
    private string $password;
    private string $passwordRepeat;


    public static function check(string $nameFirst, string $email, string $password, string $passwordRepeat) : bool
    {
        $_SESSION["try_create_name_first"] = $nameFirst;
        $_SESSION["try_create_email"] = $email;

        if(!Validation::isFullInput($nameFirst, $password, $passwordRepeat, $email)) {
            // echo "Empty input";
            $_SESSION["error"] = "empty_input";
            return false;
        }
        if(!Validation::isValidNameFirst($nameFirst)) {
            // echo "Invalid NameFirst";
            $_SESSION["error"] = "invalid_uid";
            return false;
        }

        if(!Validation::isValidEmail($email)) {
            // echo "Invalid email";
            $_SESSION["error"] = "invalid_uid";
            return false;
        }

        if(!Validation::isValidPassword($password)) {
            // echo "Invalid email";
            $_SESSION["error"] = "incorrect_format_password";
            return false;
        }

        if(!Validation::isPasswordMatch($password, $passwordRepeat)) {
            // echo "Passwords don't match! ";
            $_SESSION["error"] = "password_doesnt_match";
            return false;
        }
        return true;
    }

}
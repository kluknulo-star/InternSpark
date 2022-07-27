<?php

namespace app\Users\Validator;

class EditUserValidator {

    private int $id;
    private string $nameFirst;
    private string $email;
    private string $password;
    private string $passwordRepeat;
    private string $roleSet;

    public static function check(string $nameFirst,string $email,string $password,string $passwordRepeat) : bool
    {
        $_SESSION["try_edit_name_first"] = $nameFirst;
        $_SESSION["try_edit_email"] = $email;

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

        if(!Validation::isPasswordMatch($password, $passwordRepeat)) {
            // echo "Passwords don't match! ";
            $_SESSION["error"] = "password_doesnt_match";
            return false;
        }

        if (!($password == "" && $passwordRepeat == ""))
        {

            if ((!Validation::isValidPassword($password)) && !($password == "" && $password == ""))
            {
                // echo "Invalid email";
                $_SESSION["error"] = "incorrect_format_password";
                return false;
            }
            else
                $password = password_hash($password, PASSWORD_DEFAULT);
        }

        return true;
    }

}
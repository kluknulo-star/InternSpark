<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/classes/Entity/Signup.php";

class Validation {

    public static function isFullInput($nameFirst, $password, $passwordRepeat, $email) : bool
    {
        return ($nameFirst && $password && $passwordRepeat && $email);
    }

    public static function isFullInputLogin($nameFirst, $password) : bool
    {
        return ($nameFirst && $password);
    }

    public static function isValidNameFirst($nameFirst) : bool
    {

//        return preg_match('/^[a-zA-Z][a-zA-Z0-9-_\.]{4,20}$/', $nameFirst);
        return preg_match('/^[A-Za-z][A-Za-z0-9_]{4,29}$/', $nameFirst);
    }

    public static function isValidEmail($nameFirst) : bool
    {
        return filter_var($nameFirst, FILTER_VALIDATE_EMAIL);
    }

    public static function isValidPassword($password) : bool
    {
        // 1 заглавная, 1 прописная, цифра, длина от 5
//        return preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{5,15}$/', $password);
        return preg_match('/^(?=.*?[a-z]).{5,15}$/', $password);
    }

    public static function isPasswordMatch($password, $passwordRepeat) : bool
    {
        return $password == $passwordRepeat;
    }
}
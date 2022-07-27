<?php
namespace app\Courses\Validator;

class Validation
{

    public static function isValidNameTitle($title): bool
    {
        if (strlen($title) >= 45)
        {
            return false;
        }
        $title = str_replace(" ", "", $title);
        return preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9\._!,]{4,45}$/', $title);
    }

    public static function isValidDescription($description): bool
    {
        if (strlen($description) >= 255)
            return false;
        $description = str_replace(" ", "", $description);
        return preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9\._!,]{1,125}$/', $description);
    }


}
<?php
namespace app\Courses\Validator;

class AddCourseValidator{

    public static function check(string $title, string $description) : bool
    {
        $_SESSION["try_title"] = $title;
        $_SESSION["try_description"] = $description;

        if(!Validation::isValidNameTitle($title)) {
            // echo "Empty input";
            $_SESSION["error"] = "invalid_title_course";
            return false;
        }
        if(!Validation::isValidDescription($description)) {
            // echo "Invalid NameFirst";
            $_SESSION["error"] = "invalid_description_course";
            return false;
        }

        return true;
    }

}
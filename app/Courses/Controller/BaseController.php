<?php
namespace app\Courses\Controller;

class BaseController
{
    public function render($path)
    {
        require_once APP_ROOT_DIRECTORY . $path;
    }

    public function redirect(string $location, $error = "")
    {
        if ($error != ""){
            $_SESSION["error"] = $error;
        }
        header("location: " . "/" . $location);
        exit();
    }
}

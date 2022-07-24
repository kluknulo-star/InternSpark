<?php
namespace app\Users\Controller;

class BaseController
{
    public function render(string $path) : void
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

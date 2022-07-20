<?php
namespace app\Users\Controller;

class BaseController
{
    public function render($path)
    {
        require APP_ROOT_DIRECTORY . $path;
    }
}

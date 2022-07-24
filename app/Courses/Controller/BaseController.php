<?php
namespace app\Users\Controller;

class BaseController
{
    public function render($path)
    {
        require_once APP_ROOT_DIRECTORY . $path;
    }
}

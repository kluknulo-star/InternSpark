<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/classes/Entity/Login.php";
require_once "$root/classes/Validator/Validation.php";
require_once "$root/includes/session/session.php";

class LoginValidator extends Login {

    private string $uid;
    private string $password;

    public function __construct($uid, $password, ){
        $this->uid = $uid;
        $this->password = $password;
    }

    public function loginUser()
    {
        $_SESSION["try_login_uid"] = $this->uid;
        $location = '/InternSpark/src/page/login.php';

        if(!Validation::isFullInputLogin($this->uid, $this->password)) {
            // echo "Empty input";
            $_SESSION["error"] = "empty_input";
            header("location: $location?error=");
            exit();
        }

        $this->getUser($this->uid, $this->password);
    }

}
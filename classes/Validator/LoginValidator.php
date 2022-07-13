<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/classes/Entity/Login.php";
require_once "$root/classes/Validator/Validation.php";

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
            header("location: $location?error=empty_input");
            exit();
        }


        $this->getUser($this->uid, $this->password);
    }



}
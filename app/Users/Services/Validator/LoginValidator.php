<?php
require_once APP_ROOT_DIRECTORY ."/app/Users/Services/Validator/Validation.php";

class LoginValidator {

    private string $uid;
    private string $password;

    public function __construct($uid, $password,){
        $this->uid = $uid;
        $this->password = $password;
        $this->loginUser();
    }

    public function loginUser()
    {
        $_SESSION["try_login_uid"] = $this->uid;
        $location = '/login';

        if(!Validation::isFullInputLogin($this->uid, $this->password)) {
            // echo "Empty input";
            $_SESSION["error"] = "empty_input";
            header("location: $location");
            exit();
        }

//        if()

//        $this->getUser($this->uid, $this->password);
    }

}
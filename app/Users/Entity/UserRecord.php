<?php

class UserRecord {

    //добавить roles
    private int $id;
    private string $nameFirst;
    private string $email;
    private string $password;
    private $deletedAt;
    private string $roleName;
    private $avatar;

    public function __construct($id, $nameFirst, $email, $password, $deletedAt, $roleName, $avatar=""){
        $this->id = $id;
        $this->nameFirst = $nameFirst;
        $this->email = $email;
        $this->password = $password;
        $this->deletedAt = $deletedAt;
        $this->roleName = $roleName;
        $this->avatar = $avatar;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getNameFirst() : string
    {
        return $this->nameFirst;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function getRole() : string
    {
        return $this->roleName;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function getFullAvatar()
    {
        $source = "/images/avatars/";
        $root_source = APP_ROOT_DIRECTORY . "public/images/avatars/";
        if ($this->getAvatar() != "" && file_exists($root_source . $this->getAvatar()))
        {
            $source .= $this->getAvatar();
            $root_source .= $this->getAvatar();
        } else{
            $source .= "default.svg";
            $root_source .= $this->getAvatar();
        }
        return $source;
    }

    public function isDeleted() : bool
    {
        return (bool)$this->deletedAt;
    }




    public function __toString(): string
    {
        return ("<td>" . $this->id . "</td>" .
            "<td>" . $this->nameFirst . "</td>" .
            "<td>" . $this->email . "</td>" .
            "<td>" . $this->deletedAt . "</td>".
            "<td>" . $this->roleName . "</td>"
        );
    }

    public function userToString(): string
    {
        return ("<td>" . $this->id . "</td>" .
            "<td>" . $this->nameFirst . "</td>" .
            "<td>" . $this->email . "</td>" .
            "<td>" . $this->roleName . "</td>"
        );
    }
}
?>
<?php

class UserRecord {

    //добавить roles
    private int $id;
    private string $nameFirst;
    private string $email;
    private string $password;
    private $deleted_at;
    private string $role_name;
    private $avatar;

    public function __construct($id, $nameFirst, $email, $password, $deleted_at, $role_name, $avatar=""){
        $this->id = $id;
        $this->nameFirst = $nameFirst;
        $this->email = $email;
        $this->password = $password;
        $this->deleted_at = $deleted_at;
        $this->role_name = $role_name;
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
        return $this->role_name;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function isDeleted() : bool
    {
        return (int)$this->deleted_at;
    }




    public function __toString(): string
    {
        return ("<td>" . $this->id . "</td>" .
            "<td>" . $this->nameFirst . "</td>" .
            "<td>" . $this->email . "</td>" .
            "<td>" . $this->deleted_at . "</td>".
            "<td>" . $this->role_name . "</td>"
        );
    }

    public function userToString(): string
    {
        return ("<td>" . $this->id . "</td>" .
            "<td>" . $this->nameFirst . "</td>" .
            "<td>" . $this->email . "</td>" .
            "<td>" . $this->role_name . "</td>"
        );
    }
}
?>
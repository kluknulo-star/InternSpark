<?php

class UserRecord {

    //добавить roles
    private int $id;
    private string $nameFirst;
    private string $email;
    private string $password;
    private $deleted_at;
    private string $role_name;

    public function __construct($id, $nameFirst, $email, $password, $deleted_at, $role_name){
        $this->id = $id;
        $this->nameFirst = $nameFirst;
        $this->email = $email;
        $this->password = $password;
        $this->deleted_at = $deleted_at;
        $this->role_name = $role_name;
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

    public function getRole() : int
    {
        return $this->role_name;
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
            "<td>" . $this->password . "</td>" .
            "<td>" . $this->deleted_at . "</td>".
            "<td>" . $this->role_name . "</td>"
        );
    }
}
?>
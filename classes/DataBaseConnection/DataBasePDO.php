<?php

class DataBasePDO {

    protected static function connect(){
        try {
            $username = "root";
            $password = "kluknulo";
            $dph = new PDO('mysql:host=localhost;dbname=imagespark', $username, $password);
            return $dph;
        }
        catch (PDOException $e) {
            echo "Error!" . $e->getMessage() . "<br/>";
            die();
        }
    }


}
?>
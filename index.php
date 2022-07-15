<?php
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once "$root/includes/session/session.php";

    if (isset($_SESSION["uid"]))
    {
        header("location: /InternSpark/src/page/table/table.php");

    }
    else{
        header('location: /InternSpark/src/page/login.php');
    }
    exit();
    ?>

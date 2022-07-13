<?php

    const PHP_SESSION_DISABLED = 0;
    const PHP_SESSION_NONE = 1;
    const PHP_SESSION_ACTIVE = 2;

    $status = session_status();
    if ($status == PHP_SESSION_DISABLED)
    {
        session_start();
    }

    if (empty($_SESSION["uid"]))
    {
        header('Location: ./src/page/login.php');
    }
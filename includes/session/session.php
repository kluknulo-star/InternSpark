<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


    $status = session_status();
    if ($status != PHP_SESSION_ACTIVE)
    {
        session_start();
    }

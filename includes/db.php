<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once("Database-Class/MysqliDb.php");

    try {
        $db = new MysqliDb($host, $db_user, $db_pass, $database);
    } catch (Exception $e) {
        die('Er kon geen verbinding met de database gemaakt worden: ' . $e->getMessage() . "\n");
    }

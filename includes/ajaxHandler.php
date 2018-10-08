<?php

    $host = "localhost";
    $db_user = "root";
    $db_pass = "trommel";
    $database = "dw_cms";


    if(!empty($_GET['p'])) {
        $pageId = $_GET['p'];
    }else {
        $pageId = 1;
    }

    $db = mysqli_connect($host, $db_user, $db_pass, $database);

    if (!$db) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL . "<br>";
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL . "<br>";
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    $action = $_POST['action'];

    switch($action) {
        case "updateMenuOrder":
            $result = mysqli_query($db, "UPDATE `menuOrder` SET `orderJSON` = '" . $_POST['JSONlist'] . "' WHERE `id` = 1");
            echo $result;
          break;
        case "getPageInfo":
            $result = mysqli_query($db, "SELECT `id`, `titel`, `url`, `omschrijving`, `zoektermen` FROM `pages` WHERE `id` = $pageId");
            echo $result;
          break;
        
    }

    mysqli_close($db);


?>

<?php

    require("../../../config.php");
    require("../../../includes/db.php");
    require("../../../includes/main-class.php");

    //kijk of iemand is ingelogd...
    $Auth = Authenticate::checkAuth($db);

    try {
        if ( 0 < $_FILES['file']['error'] ) {
            echo 'Error: ' . $_FILES['file']['error'] . '<br>';
        }
        else {
            move_uploaded_file($_FILES['file']['tmp_name'], '../../../uploads/images/logo.png');
        }
    } catch(Exception $e) {
        $response = array(
            "status"        => "error",
            "errorMessage"  => $e->getMessage()
        );
        die(json_encode($response));
    }
    die(true);

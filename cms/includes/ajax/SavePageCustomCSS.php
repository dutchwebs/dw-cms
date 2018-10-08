<?php

    require("../../../config.php");
    require("../../../includes/db.php");
    require("../../../includes/main-class.php");

    //kijk of iemand is ingelogd...
    $Auth = Authenticate::checkAuth($db);

    $currentPage = filter_input(INPUT_POST, 'currentPage', FILTER_VALIDATE_INT );

    // If is empty means homepage
    if(empty($currentPage)) {
        $currentPage = 1;
    }

    $customCSS = filter_input(INPUT_POST, 'customCSS', FILTER_SANITIZE_STRING);

    // Remove cms related tags
    $outputCSS = str_replace('style>', ">", $customCSS);

    $data = array(
        "customCSS" => $outputCSS
    );

    try {
        $db->where ('id', $currentPage);

        if ($db->update ('pages', $data)) {
            die("{true}");
        }else {
            echo "{error}: " . $db->getLastError();
        }
    }catch(Exception $e) {
        die("{error}: " . $e->getMessage());
    }

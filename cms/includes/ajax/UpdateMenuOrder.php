<?php

    require("../../../config.php");
    require("../../../includes/db.php");
    require("../../../includes/main-class.php");

    //kijk of iemand is ingelogd...
    $Auth = Authenticate::checkAuth($db);

    $JSONList = filter_input(INPUT_POST, 'JSONlist', FILTER_DEFAULT);
    $menuId = filter_input(INPUT_POST, 'MenuId', FILTER_VALIDATE_INT );

    $isJSONValid = isJson($JSONList);

    if($isJSONValid && !empty($menuId)) {

        // Update website menu
        try {

            // Prepare array with setting titel value
            $data = array ('orderJSON' => $JSONList);
            // Find website title setting
            $db->where ('id', $menuId);
            // Update website setting
            $updateMenuOrder = $db->update('menuOrder', $data);

        } catch(Exception $e) {
            $response = array(
                "status"        => "error",
                "errorMessage"  => $e->getMessage()
            );
            die(json_encode($response));
        }

    }else {
        die("JSON is not valid! " . $JSONList);
    }

    $response = array("status" => "done");
    die(json_encode($response));

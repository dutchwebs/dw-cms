<?php

    require("../../../config.php");
    require("../../../includes/db.php");
    require("../../../includes/main-class.php");

    //kijk of iemand is ingelogd...
    $Auth = Authenticate::checkAuth($db);

    $currentPageId = filter_input(INPUT_POST, 'currentPage', FILTER_VALIDATE_INT );
    $deleteTrueOrFalse = filter_input(INPUT_POST, 'removePage', FILTER_VALIDATE_BOOLEAN);

    try {
        //get menuItem id
        $db->where("pageId", $currentPageId);
        $menuItem = $db->getOne("menuItems");

        //get menu order
        $menuOrder = $db->getOne("menuOrder");
        $menuOrderArray = json_decode($menuOrder['orderJSON'], true);

        //remove menuItem from menu order
        $newMenuOrderArray = array_filter_recursive(remove_element_by_value($menuOrderArray, $menuItem['id']));

        $menuOrderUpdateArray = array("orderJSON" => json_encode($newMenuOrderArray));

        //update menu order by id {hoofdmenu: 1}
        $db->where("id", 1);
        $menuOrder = $db->update("menuOrder", $menuOrderUpdateArray);

        //remove menuItem
        $db->where('id', $menuItem['id']);
        $db->delete('menuItems');

        //finally remove whole page
        $db->where('id', $currentPageId);
        $db->delete('pages');

        $response = array("status" => "done");
        die(json_encode($response));

    } catch(Exception $e) {
        $response = array(
            "status"        => "error",
            "errorMessage"  => $e->getMessage()
        );
        die(json_encode($response));
    }

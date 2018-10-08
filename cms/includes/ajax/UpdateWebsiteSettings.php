<?php

    require("../../../config.php");
    require("../../../includes/db.php");
    require("../../../includes/main-class.php");

    //kijk of iemand is ingelogd...
    $Auth = Authenticate::checkAuth($db);

    $currentPageId = filter_input(INPUT_POST, 'currentPage', FILTER_VALIDATE_INT );
    $websiteNaam = filter_input(INPUT_POST, 'websiteNaam', FILTER_SANITIZE_SPECIAL_CHARS);
    $websiteEmail = filter_input(INPUT_POST, 'websiteEmail', FILTER_SANITIZE_SPECIAL_CHARS);
    $paginaTitel = filter_input(INPUT_POST, 'paginaTitel', FILTER_SANITIZE_SPECIAL_CHARS);

    $paginaMenuTitel = filter_input(INPUT_POST, 'paginaMenuTitel', FILTER_SANITIZE_SPECIAL_CHARS);

    try {
        $paginaUrl = Pagina::getNewPageUrl($db, str_replace('+', '-', urlencode(filter_input(INPUT_POST, 'paginaURL', FILTER_SANITIZE_SPECIAL_CHARS))), 1, $currentPageId);
    } catch(Exception $e) {
        $response = array(
            "status"        => "error",
            "errorMessage"  => $e->getMessage()
        );
        die(json_encode($response));
    }

    $paginaOmschrijving = filter_input(INPUT_POST, 'paginaOmschrijving', FILTER_SANITIZE_SPECIAL_CHARS);
    $paginaKeyWords = filter_input(INPUT_POST, 'paginaKeyWords', FILTER_SANITIZE_SPECIAL_CHARS);


    // Update the page values
    try {

        // Prepare array with page update values
        $data = array (
            'titel' => $paginaTitel,
            'url' => $paginaUrl,
            'omschrijving' => $paginaOmschrijving,
            'zoektermen' => $paginaKeyWords
        );
        // Find page to update
        $db->where ('id', $currentPageId);
        // Update page
        $updatePage = $db->update ('pages', $data);

        // Prepare array with menuItem titel value
        $data = array (
            'titel' => $paginaMenuTitel
        );
        // Find menu item to update
        $db->where ('pageId', $currentPageId);
        // Update menu item
        $updateMenuItem = $db->update ('menuItems', $data);

    } catch(Exception $e) {
        $response = array(
            "status"        => "error",
            "errorMessage"  => $e->getMessage()
        );
        die(json_encode($response));
    }

    // Update website settings values
    try {

        // Prepare array with setting titel value
        $data = array ('Value' => $websiteNaam);
        // Find website title setting
        $db->where ('Setting', "titel");
        // Update website setting
        $updatePage = $db->update ('instellingen', $data);

        // Prepare array with setting email value
        $data = array ('Value' => $websiteEmail);
        // Find website email setting
        $db->where ('Setting', "email");
        // Update website setting
        $updatePage = $db->update ('instellingen', $data);

    } catch(Exception $e) {
        $response = array(
            "status"        => "error",
            "errorMessage"  => $e->getMessage()
        );
        die(json_encode($response));
    }

    $response = array("status" => "done");
    die(json_encode($response));

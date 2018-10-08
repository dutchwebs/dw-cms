<?php

    require("../../../config.php");
    require("../../../includes/db.php");
    require("../../../includes/main-class.php");

    //kijk of iemand is ingelogd...
    $Auth = Authenticate::checkAuth($db);

    $templateNum = filter_input(INPUT_POST, 'templateNum', FILTER_VALIDATE_INT );
    $paginaNaam = filter_input(INPUT_POST, 'paginaNaam', FILTER_SANITIZE_SPECIAL_CHARS);

    $newPageUrl = Pagina::getNewPageUrl($db, str_replace('+', '-', urlencode($paginaNaam)));

    if(!empty($paginaNaam)) {

        try {
            // Hier halen we een html snippet op uit de database
            $db->where('id', $templateNum);
            $pageTemplate = $db->get('pageTemplates');
        }catch(Exception $e) {
            die("{error}: Template is niet gevonden...");
        }

        //hier vullen we de nieuwe pagina
        $pageData = array(
            "titel"     => $paginaNaam,
            "url"       => $newPageUrl,
            "section1"  => $pageTemplate[0]["section1"],
            "section2"  => $pageTemplate[0]["section2"],
            "section3"  => $pageTemplate[0]["section3"],
            "section4"  => $pageTemplate[0]["section4"],
            "section5"  => $pageTemplate[0]["section5"],
            "section6"  => $pageTemplate[0]["section6"],
            "section7"  => $pageTemplate[0]["section7"],
            "section8"  => $pageTemplate[0]["section8"],
            "section9"  => $pageTemplate[0]["section9"],
            "section10" => $pageTemplate[0]["section10"],
            "section11" => $pageTemplate[0]["section11"],
            "section12" => $pageTemplate[0]["section12"],
            "section13" => $pageTemplate[0]["section13"],
            "section14" => $pageTemplate[0]["section14"],
            "section15" => $pageTemplate[0]["section15"],
            "section16" => $pageTemplate[0]["section16"],
            "section17" => $pageTemplate[0]["section17"],
            "section18" => $pageTemplate[0]["section18"],
            "section19" => $pageTemplate[0]["section19"]
        );

        try {
            // Save page
            $newPageId = $db->insert ('pages', $pageData);
        }catch(Exception $e) {
            die("{error}: " . $e->getMessage());
        }

        $menuItemData = array(
            "titel"     => $paginaNaam,
            "pageId"    => $newPageId
        );

        try {
            // Add to menu options
            $addedToMenu = $db->insert ('menuItems', $menuItemData);
        }catch(Exception $e) {
            die("{error}: " . $e->getMessage());
        }

        $response = array(
            "status"    => "done",
            "url"       => $newPageUrl
        );

        die(json_encode($response));

    }else {
        echo "<span style=\"display: none;\">{error}</span><h2>Geen pagina titel!</h2><p>U moet uw nieuwe pagina wel een titel geven...</p>";
    }

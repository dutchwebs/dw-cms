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

    $sectionId = filter_input(INPUT_POST, 'blokNum', FILTER_VALIDATE_INT );
    $blokHTML = filter_input(INPUT_POST, 'blokHTML', FILTER_SANITIZE_SPECIAL_CHARS);
    $isLastBlok = filter_input(INPUT_POST, 'isLastBlok', FILTER_VALIDATE_INT);



    // Remove cms related tags
    $outputHTML = str_replace('&#60;div class=&#34;removeThisSection&#34;&#62;&#60;span&#62;&#60;/span&#62;&#60;/div&#62;', "", $blokHTML);

    $outputHTMLNotEditable = str_replace('contenteditable=&#34;true&#34;', 'contenteditable=&#34;false&#34;', $outputHTML);

    // If it is the last blok, next ones should be deleted
    if($isLastBlok === 1) {

        $emptyData = array(
            "section" . $sectionId => $outputHTMLNotEditable
        );

        $sectionId++;

        $emptyData["section" . $sectionId] = "";

        while($sectionId < 19) {

            $sectionId++;

            $emptyData["section" . $sectionId] = "";
        }

        try {
            $db->where ('id', $currentPage);

            if ($db->update ('pages', $emptyData)) {
                die("{done}");
            }else {
                echo "{error}: " . $db->getLastError();
            }
        }catch(Exception $e) {
            die("{error}: " . $e->getMessage());
        }

    }else {
        $data = array(
            "section" . $sectionId => $outputHTMLNotEditable
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
    }

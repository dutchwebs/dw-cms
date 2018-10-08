<?php


    require("../../../config.php");
    require("../../../includes/db.php");
    require("../../../includes/main-class.php");

    //kijk of iemand is ingelogd...
    $Auth = Authenticate::checkAuth($db);

    $position = filter_var($_POST['Position'], FILTER_SANITIZE_NUMBER_INT);

    if(!empty($position)) {

        $querySnippets = "SELECT * FROM `snippets` ORDER BY `snippets`.`id` ASC";
        $resultSnippets = $db->get('snippets');

        foreach($resultSnippets as $row) {
            echo "<div class=\"SnippetSelectionBlock\" onclick=\"PasteNewElement(" . $position . ", " . $row['id'] . ")\" style='background: url(https://server.dutchwebs.com/cms/img/snippetblocks/" . $row['prev'] . ") no-repeat center center;'><span class='snippetTitle'>" . $row['titel'] . "</span></div>";
        }

    }

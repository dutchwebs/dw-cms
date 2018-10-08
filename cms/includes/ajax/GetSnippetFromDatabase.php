<?php

    require("../../../config.php");
    require("../../../includes/db.php");
    require("../../../includes/main-class.php");

    //kijk of iemand is ingelogd...
    $Auth = Authenticate::checkAuth($db);

    $SnippetNumber = filter_var($_POST['SnippetNumber'], FILTER_SANITIZE_NUMBER_INT);

    // Hier halen we een html snippet op uit de database
    $db->where('id', $SnippetNumber);
    $resultSnippet = $db->getOne('snippets');

    die($resultSnippet['html']);

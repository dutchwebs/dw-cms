<?php

    require("../../../config.php");
    require("../../../includes/db.php");
    require("../../../includes/main-class.php");

    //kijk of iemand is ingelogd...
    $Auth = Authenticate::checkAuth($db);

    $paginaId = filter_var($_POST['p'], FILTER_SANITIZE_NUMBER_INT);

    if(!empty($paginaId)) {

        try {

            $websiteSettings = new Settings($db);
            $pagina = new Pagina($db, $paginaId);

            $pageInfoArray = array(
                "pageId"          => $paginaId,
                "websiteName"     => $websiteSettings->websiteNaam,
                "websiteEmail"    => $websiteSettings->websiteEmail,
                "pageTitle"       => $pagina->getTitel(),
                "pageMenuTitle"   => Menu::getPageMenuTitle($db, $paginaId),
                "pageUrl"         => $pagina->getUrl(),
                "pageDescription" => $pagina->getOmschrijving(),
                "pageKeyWords"    => $pagina->getZoektermen()
            );

            die(json_encode($pageInfoArray));

        } catch(Exception $e) {
            die("Er ging wat fout: " . $e->getMessage());
        }

    }else {
        die("Geen pagina id meegegeven...");
    }

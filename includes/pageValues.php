<?php

    $UrlWithoutCMS = str_replace($GLOBALS['website_root'] . "/cms", "", $_SERVER['REQUEST_URI']);
    $UrlPageName =  addslashes(
        str_replace('/', '', str_replace($GLOBALS['website_root'], "", parse_url($UrlWithoutCMS)['path']))
    );

    if(!empty($UrlPageName)) {
        $pageName = filter_var($UrlPageName, FILTER_SANITIZE_STRING);
    }else {
        $pageName = "";
    }

    //Hier halen we pagina op uit de database
    $db->where('url', $pageName);
    $rowPage = $db->get('pages');

    //Hier halen we de website instellingen op
    $websiteSettings = new Settings($db);

    //Als pagina niet bestaat...
    if(!isset($rowPage[0]['id'])) {
        die("<h2>Page not found...</h2>");
    }

    //Initialiseer waardes
    $websiteNaam = $websiteSettings->websiteNaam;
    $websiteEmail = $websiteSettings->websiteEmail;
    $websiteCSS = $websiteSettings->websiteCSS;

    $paginaId = $rowPage[0]['id'];
    $pageId = $rowPage[0]['id'];
    $paginaTitel = $rowPage[0]['titel'];
    $paginaUrl = $rowPage[0]['url'];
    $paginaCSS = $rowPage[0]['customCSS'];

    $paginaOmschrijving = $rowPage[0]['omschrijving'];
    $paginaKeyWords = $rowPage[0]['zoektermen'];
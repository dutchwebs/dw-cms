<?php

    require("../../../config.php");
    require("../../../includes/db.php");
    require("../../../includes/main-class.php");

    //kijk of iemand is ingelogd...
    $Auth = Authenticate::checkAuth($db);

    if(!empty($_POST['currentPage'])) {
        $pageId = $_POST['currentPage'];
    }else {
        $pageId = 1;
    }

    $menu = new Menu($db, $_POST['menuId'], $pageId, true);

    echo $menu->getMenu();

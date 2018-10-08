<?php
    require("../config.php");

    require("../includes/db.php");
    require("../includes/main-class.php");
    require("../includes/pageValues.php");

    //kijk of iemand is ingelogd...
    $Auth = Authenticate::checkAuth($db);

    if(isset($_GET['new'])) {
        $isNewPage = "true";
    }else {
        $isNewPage = "false";
    }

    $useragent=$_SERVER['HTTP_USER_AGENT'];
    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {

        $ckeditorMap = "ckeditor-mobile";

    }else {
        $ckeditorMap = "ckeditor";
    }


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- SEO -->
        <meta name="description" content="<?=$paginaOmschrijving?>">
        <meta name="keywords" content="<?=$paginaKeyWords?>">
        <meta name="author" content="<?=$websiteNaam?>">

        <!-- Website and page -->
        <title><?=$websiteNaam?> - <?=$paginaTitel?></title>

        <!-- Favicon link -->
        <link rel="icon" type="image/png" href="<?=$GLOBALS['website_root']?>/uploads/images/logo.png" />

        <!-- Bootstrap Core CSS -->
        <link href="<?=$GLOBALS['website_root']?>/cms/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="<?=$GLOBALS['website_root']?>/css/style.css" rel="stylesheet">
        <link href="css/custom_cms_style.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="<?=$GLOBALS['website_root']?>/cms/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

        <!-- jquery ui -->
        <link href='<?=$GLOBALS['website_root']?>/cms/includes/jquery-ui/jquery-ui.min.css' rel='stylesheet' type='text/css'>
        <link href='<?=$GLOBALS['website_root']?>/cms/includes/jquery-ui/jquery-ui.theme.min.css' rel='stylesheet' type='text/css'>
        <link href='<?=$GLOBALS['website_root']?>/cms/includes/jquery-ui/jquery-ui.structure.min.css' rel='stylesheet' type='text/css'>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- CMS Core files -->
        <link rel='stylesheet' href='<?=$GLOBALS['website_root']?>/cms/includes/spectrum/spectrum.css' />
        <link href="<?=$GLOBALS['website_root']?>/cms/css/style.css" rel="stylesheet">
        <link href="<?=$GLOBALS['website_root']?>/cms/css/custom_cms_style.css" rel="stylesheet">
        <link rel=stylesheet href="<?=$GLOBALS['website_root']?>/cms/includes/codemirror/lib/codemirror.css">
        <script src="<?=$GLOBALS['website_root']?>/cms/js/jquery.js"></script>
        <script src="<?=$GLOBALS['website_root']?>/cms/includes/jquery-ui/jquery-ui.min.js"></script>

        <script src="<?=$GLOBALS['website_root']?>/cms/includes/<?=$ckeditorMap?>/ckeditor.js"></script>

        <script src='<?=$GLOBALS['website_root']?>/cms/includes/spectrum/spectrum.js'></script>
        <script src="<?=$GLOBALS['website_root']?>/cms/includes/codemirror/lib/codemirror.js"></script>
        <script src="<?=$GLOBALS['website_root']?>/cms/includes/codemirror/mode/xml/xml.js"></script>
        <script src="<?=$GLOBALS['website_root']?>/cms/includes/codemirror/mode/javascript/javascript.js"></script>
        <script src="<?=$GLOBALS['website_root']?>/cms/includes/codemirror/mode/css/css.js"></script>
        <script src="<?=$GLOBALS['website_root']?>/cms/includes/codemirror/mode/htmlmixed/htmlmixed.js"></script>
        <script src="<?=$GLOBALS['website_root']?>/cms/includes/codemirror/addon/edit/matchbrackets.js"></script>
        <script src="<?=$GLOBALS['website_root']?>/cms/includes/codemirror/addon/formatting/formatting.js"></script>

        <!-- End CMS Core files -->

        <style id="globalCSS">
            <?php
                //de custom css van de pagina laden
                //echo str_replace('&#39;', '"', htmlspecialchars_decode($websiteCSS));
            ?>
        </style>

        <style id="customCSS">
            <?php
                //de custom css van de pagina laden
                echo str_replace('&#39;', '"', htmlspecialchars_decode($paginaCSS));
            ?>
        </style>

    </head>

    <body id="page-top" class="index">

        <!-- Navigation -->
        <nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                        <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                    </button>
                    <a class="brand-logo" href="<?=$GLOBALS['website_root']?>/cms/">
                        <img src="<?=$GLOBALS['website_root']?>/uploads/images/logo.png" alt="logo" id="websiteLogo">
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <?php
                          $menu = new Menu($db, 1, $paginaId, true);
                          echo $menu->getMenu();
                        ?>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>

        <?php
            $loopCount = 0;
            while ($loopCount < 20) {
                // Check of row niet leeg is
                if(!empty($rowPage[0]["section" . $loopCount])) {
                    // Hier gooien we een wrapper om de content zodat het cms ermee kan werken
                    echo '<div id="SectionToEdit-' . $loopCount . '" class="EditableSection Blok">';
                    // Dit is de knop waarmee je een blok kunt verwijderen, wordt met css content ingeladen
                    echo "<div class=\"removeThisSection\"><span></span></div>";
                    // In de database slaan we de html op als html htmlspecialchars dit moeten we terug naar gewone html krijgen
                    echo str_replace('contenteditable="false"', 'contenteditable="true"', htmlspecialchars_decode($rowPage[0]["section" . $loopCount])) . "</div>";
                    // De bar onder een blok waarmee je een nieuw blok kan toevoegen
                    echo "<span id='NewElementLine-$loopCount' class='NieuwElementLine LineNewElementLine-$loopCount'>";
                    ?>

                <div class="blobs">
                    <?php
                    echo "<div class='blob' onclick='NewElement($loopCount)'>";
                    ?>
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </div>
                </div>

        <?php

                    echo "</span>";
                }
                $loopCount++;
            }
        ?>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <ul class="list-inline quicklinks">
                            <li><span class="copyright">Webdesign by: <a style="color:#5e8efc;" href="http://dutchwebs.com" target="_blank" title="Dutchwebs web-development">Dutchwebs</a></span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                        <ul class="list-inline quicklinks">
                            <li><a target="_blank" href="<?=$GLOBALS['website_root']?>/Privacy-Statement.pdf">Privacy Statement</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?=$GLOBALS['website_root']?>/cms/js/bootstrap.min.js"></script>

        <!-- Plugin JavaScript -->
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

        <script src="<?=$GLOBALS['website_root']?>/cms/js/packery.pkgd.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="<?=$GLOBALS['website_root']?>/js/custom.js"></script>


        <div id="uploadFrame">
            <iframe id="uploadIframe" name="uploadFrame"></iframe>
            <div id="closeUploadFrame"><i class="fa fa-times" aria-hidden="true"></i></div>
        </div>

        <div id="CMSLeftPanel">
            <span id="close"><i class="fa fa-times" aria-hidden="true"></i></span>
            <div class="PanelWrapper">
                <h1 id="blokNaam">Blok 1</h1>
                <div id="backgroundSelectionWrapper"></div>
            </div>
        </div>
        <div id="CMSLeftPanelOpener"><span></span></div>

        <div id="CMSRightPanel">
            <span id="close"><i class="fa fa-times" aria-hidden="true"></i></span>
            <div class="PanelWrapper">
                <h1 id="blokNaam" style="text-align: right;">Toolbox</h1>
                <div id="ToolBoxWrapper"></div>
            </div>
        </div>
        <div id="CMSRightPanelOpener"><span></span></div>

        <div class="BottomConfigButtons">
            <a class="PageSettingsButton" id="PageSettingsButton">
                <i class="fa fa-cogs" aria-hidden="true"></i>
            </a>
            <a class="SaveButton" id="SaveButton">
                <i class="fa fa-floppy-o" aria-hidden="true"></i>
            </a>
            <a class="PageSEOButton" id="PageSEOButton">
                <i class="fa fa-search" aria-hidden="true"></i>
            </a>
            <a class="PageLicenseButton" id="PageLicenseButton">
                <i class="fa fa-globe" aria-hidden="true"></i>
            </a>
        </div>

        <div class="LoadingOverlay">
            <span>
                <div class='uil-ripple-css' style='transform:scale(1);'>
                    <div></div>
                    <div></div>
                </div>
            </span>
        </div>
        <div class="NewElementDiv"></div>

        <a href="<?php echo str_replace('/cms/index.php', '', $_SERVER['PHP_SELF']);?>">
          <button class="viewPageButton" id="viewPageButton" title="Pagina bekijken...">Bekijk pagina</button>
        </a>

        <script>

            var website_root = "<?=$GLOBALS['website_root']?>";
            var document_root = "<?=$_SERVER['DOCUMENT_ROOT']?>";

            var currentPage = "<?php echo $paginaId ?>";
            var websiteRootUrl = "<?php echo url() ?>";

            var isPageNew = "<?php echo $isNewPage ?>";

            var websiteNaam = "<?php echo $websiteNaam ?>";
            var websiteEmail = "<?php echo $websiteEmail ?>";
            var paginaTitel = "<?php echo $paginaTitel ?>";
            var paginaUrl = "<?php echo $paginaUrl ?>";
            var paginaOmschrijving = "<?php echo $paginaOmschrijving ?>";
            var paginaKeyWords = "<?php echo $paginaKeyWords ?>";

            <?php
            if(isset($_GET['website_created'])) {
                ?>
                $(document).ready(function () {
                  openPageLicenseInfo(true);
                });
                <?php
            }
            ?>

        </script>

        <script src="<?=$GLOBALS['website_root']?>/cms/js/cmsFooter.js"></script>
        <script src="<?=$GLOBALS['website_root']?>/cms/js/custom_cms_footer.js"></script>
    </body>
</html>

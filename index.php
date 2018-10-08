<?php

    require("config.php");

    require("includes/db.php");
    require("includes/main-class.php");
    require("includes/pageValues.php");

?>
<!DOCTYPE html>
<html lang="nl">
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
        <link rel="icon" type="image/png" href="/uploads/images/logo.png" />

        <!-- Bootstrap Core CSS -->
        <link href="<?=$GLOBALS['website_root']?>/cms/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="<?=$GLOBALS['website_root']?>/css/style.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="<?=$GLOBALS['website_root']?>/cms/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

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
                    <a class="brand-logo" href="<?=$GLOBALS['website_root']?>/">
                        <img src="<?=$GLOBALS['website_root']?>/uploads/images/logo.png" alt="logo" id="websiteLogo">
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <?php
                            $menu = new Menu($db, 1, $paginaId);
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
                if(!empty($rowPage[0]["section" . $loopCount])) {
                    echo str_replace('contenteditable="true"', 'contenteditable="false"', htmlspecialchars_decode($rowPage[0]["section" . $loopCount]));
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

        <?php
          if(isset($_COOKIE["email"]) && isset($_COOKIE["hashedPass"])) {
        ?>
        <a href="<?=$GLOBALS['website_root']?>/cms<?php echo str_replace('/index.php', '', $_SERVER['PHP_SELF']);?>">
          <button class="editPageButton" id="editPageButton" title="Bewerk deze pagina">Bewerk pagina</button>
        </a>
        <?php
          }
        ?>

        <!-- jQuery -->
        <script src="<?=$GLOBALS['website_root']?>/cms/js/jquery.js"></script>
        <script src="<?=$GLOBALS['website_root']?>/cms/js/jquery-ui-1.12.1/jquery-ui.min.js"></script>

        <!-- canvas inline mobile video player -->
        <script src="<?=$GLOBALS['website_root']?>/cms/js/canvas-video-player.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?=$GLOBALS['website_root']?>/cms/js/bootstrap.min.js"></script>

        <!-- Only on live site JavaScript -->
        <script src="http://matthew.wagerfield.com/parallax/assets/scripts/js/libraries.min.js"></script>
        <script src="<?=$GLOBALS['website_root']?>/cms/plugins/parallax/deploy/jquery.parallax.js"></script>
        <script src="<?=$GLOBALS['website_root']?>/cms/js/packery.pkgd.min.js"></script>

        <!-- Custom JavaScript -->
        <script src="<?=$GLOBALS['website_root']?>/js/custom.js"></script>
        <script src="<?=$GLOBALS['website_root']?>/js/custom-live.js"></script>

    </body>
</html>

<?php
    require("../../config.php");
?>
<!DOCTYPE html>
<html lang="nl">
    <head>
        <meta charset="utf-8">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="default" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable = no" />

        <title>CMS - Log in</title>

        <script src="https://server.dutchwebs.com/cms/js/jquery.js"></script>
        <script src="https://server.dutchwebs.com/cms/includes/jquery-ui/jquery-ui.min.js"></script>

        <!-- jquery ui -->
        <link href='https://server.dutchwebs.com/cms/includes/jquery-ui/jquery-ui.min.css' rel='stylesheet' type='text/css'>
        <link href='https://server.dutchwebs.com/cms/includes/jquery-ui/jquery-ui.theme.min.css' rel='stylesheet' type='text/css'>
        <link href='https://server.dutchwebs.com/cms/includes/jquery-ui/jquery-ui.structure.min.css' rel='stylesheet' type='text/css'>

        <link href="https://server.dutchwebs.com/cms/css/bootstrap.min.css" rel="stylesheet">

        <style>
            body {
                background: #fcfcfc;
                font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            }
            input:focus,
            select:focus,
            textarea:focus,
            button:focus {
                outline: none;
            }
            .logoImage {
                position: relative;
                top: 0px;
                left: 0px;
                right: 0px;
                display: block;
                width: 100%;
            }
            .loginDiv, .dutchwebsLogoImg {
                position: relative;
                padding: 0px;
                width: 95%;
                max-width: 300px;
                margin: auto;
                left: 0px;
                right: 0px;
                top: 20vh;
                font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                border-radius: 3px;
                margin-top: 10px;
            }
            .dutchwebsLogoImg {
                -webkit-box-shadow: none;
                -moz-box-shadow: none;
                box-shadow: none;
                background: transparent;
                top: 20vh;
                max-width: 300px;
            }
            .loginDiv input {
                width: 90%;
                text-align: center;
                display: block;
                font-size: 16px;
                padding: 15px 0px;
                position: relative;
                margin: auto;
                left: 0px;
                right: 0px;
                border: none;
                border-bottom: solid 1px #c1c1c1;
                border-radius: 0px;
                background: transparent;
            }
            .loginDiv .loginKnop {
                -webkit-appearance: none;
                appearance: none;
                position: relative;
                width: 100%;
                margin-top: 10px;
                padding: 15px;
                background: #4cc17c;
                color: white;
                font-weight: bold;
                border: none;
                cursor: pointer;
                border-radius: 3px;
                -webkit-transition: all .3s; /* Safari */
                transition: all .3s;
            }
            .loginDiv .loginKnop:hover {
                background: #47b575;
            }

            .errorIcon {
                position: absolute;
                top: 7px;
                font-size: 28px;
                left: -10px;
                color: #ec3a32;
                display: none;
            }

            #passwordError {
                top: 56px;
            }

            .inloggenNietGelukt {
                position: fixed;
                top: 20px;
                right: 40px;
                background: #ec3a32;
                color: white;
                padding: 15px 20px;
                border-radius: 3px;
            }
            .inloggenNietGelukt span {
                font-size: 16px;
                font-weight: bold;
            }

        </style>
    </head>
    <body>

        <div class="dutchwebsLogoImg">
            <img src="https://www.dutchwebs.com/png/dutchwebs-flat.png" class="logoImage">
        </div>

        <?php
            if(isset($_GET['p'])) {
                if($_GET['p'] === "f") {
                ?>

        <div class="inloggenNietGelukt">
            <span>Inloggen niet gelukt!</span>
        </div>

                <?php
                }
            }
        ?>

        <div class="loginDiv">
            <span id="emailError" class="errorIcon"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
            <span id="passwordError" class="errorIcon"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
            <form action="<?=$GLOBALS['website_root']?>/cms/" method="POST" id="loginForm">
                <input type="email" name="loginEmail" id="loginEmail" placeholder="Email">
                <input type="password" name="loginPassword" id="loginPassword" placeholder="Wachtwoord" style="border-bottom: none;">
                <input type="submit" value="Inloggen" class="loginKnop" id="loginKnop">
            </form>
        </div>
    </body>
</html>
<script>
    $(document).ready(function () {
        $("#loginForm").submit(function () {
            if($("#loginEmail").val() == "" || $("#loginPassword").val() == "") {

                if($("#loginEmail").val() == "") {
                    $("#emailError").show("fade");
                }else {
                    $("#emailError").hide("fade");
                }

                if($("#loginPassword").val() == "") {
                    $("#passwordError").show("fade");
                }else {
                    $("#passwordError").hide("fade");
                }

                return false;
            }else {
                return true;
            }
        });
    });
</script>

<?php

    //Pass encryption
    function encryptIt( $q ) {
        $cryptKey  = 'f82739fbubf3wp9fh3f2389';
        $qEncoded  = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
        return( $qEncoded );
    }

    if(isset($_POST['submit'])) {
        
        $servername = $_POST['inputDBHost'];
        $username = $_POST['inputDBUser'];
        $password = $_POST['inputDBPass'];
        
        $CMSdbName = $_POST['inputDBName'];
        
        $cms_email = $_POST['inputCMSEmail'];
        $cms_pass = $_POST['inputCMSPass'];
        
        try {
            
            // Connect to MySQL server
            if( ! $conn = mysqli_connect($servername, $username, $password) ) {
                die('No connection: ' . mysqli_connect_error());
            }

            //db_dump url
            $db_dump = 'initial-setup.sql';

            //inject user name & pass
            $user_data_injected = str_replace("##EMAIL##", $cms_email, file_get_contents($db_dump));
            $user_data_injected = str_replace("##USER##", strtok($cms_email, '@'), $user_data_injected);
            $user_data_injected = str_replace("##PASS##", encryptIt($cms_pass), $user_data_injected);

            //create new db
            mysqli_query($conn, "CREATE DATABASE $CMSdbName");

            // Select database
            mysqli_select_db($conn, $CMSdbName) or die('Error selecting MySQL database: ' . mysql_error());

            //Importeer db_dump
            $importReturn = mysqli_multi_query($conn, $user_data_injected);

            //change config file to new db
            $cms_db_config_file_dest = "config.php";
            $file_data_injected = str_replace("##DB##", $CMSdbName, file_get_contents($cms_db_config_file_dest));
            $file_data_injected = str_replace("##HOST##", $servername, $file_data_injected);
            $file_data_injected = str_replace("##USER##", $username, $file_data_injected);
            $file_data_injected = str_replace("##PASS##", $password, $file_data_injected);
            $CMSdataBaseIntegration = file_put_contents($cms_db_config_file_dest, $file_data_injected);
            
        } catch (Exception $e) {
            die('Caught exception @ CMS setup: ' . $e->getMessage());
        }
        
        echo 'YEAH!';
        die();
    }
?>
<!DOCTYPE html>
<html lang="nl">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Website and page -->
        <title>Setup Dutchwebs CMS</title>

        <!-- Favicon link -->
        <link rel="icon" type="image/png" href="/uploads/images/logo.png" />

        <!-- Bootstrap Core CSS -->
        <link href="https://server.dutchwebs.com/cms/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="/css/style.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="https://server.dutchwebs.com/cms/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        <style>
            .form-signin {
                position: relative;
                top: 7.5vh;
                width: 80%;
                max-width: 550px;
                margin: auto;
                left: 0px;
                right: 0px;
            }
            .form-label-group {
/*                padding-top: 15px;*/
                padding-bottom: 15px;
            }
        </style>

    </head>

    <body id="page-top" class="index">

        <form class="form-signin" action="?" method="post">
          <div class="text-center mb-4">
            <img class="mb-4" src="https://www.dutchwebs.com/png/dutchwebs-flat.png" alt="" width="150">
            <h1 class="h3 mb-3 font-weight-normal">Setup Dutchwebs CMS</h1>
            <p>Please fill out the following form to get your website up and running!</p>
          </div>

          <div class="form-label-group">
              <label for="inputDBHost">Database hostname (localhost)</label>
            <input type="text" id="inputDBHost" name="inputDBHost" class="form-control" placeholder="Database hostname" required="" autofocus="">
          </div>

          <div class="form-label-group">
              <label for="inputDBName">Database name (creates new db)</label>
            <input type="text" id="inputDBName" name="inputDBName" class="form-control" placeholder="Database name" value="dw_cms" required="" autofocus="">
          </div>

          <div class="form-label-group">
              <label for="inputDBUser">Database username (root)</label>
            <input type="text" id="inputDBUser" name="inputDBUser" class="form-control" placeholder="Database username" required="" autofocus="">
          </div>

          <div class="form-label-group">
              <label for="inputDBPass">Database password</label>
            <input type="password" id="inputDBPass" name="inputDBPass" class="form-control" placeholder="Database password" autofocus="">
          </div>

          <div class="form-label-group">
              <label for="inputCMSEmail">Email address (new CMS user login)</label>
            <input type="email" id="inputCMSEmail" name="inputCMSEmail" class="form-control" placeholder="Email address" required="" autofocus="">
          </div>

          <div class="form-label-group">
              <label for="inputCMSPass">Password (new CMS user password)</label>
            <input type="password" id="inputCMSPass" name="inputCMSPass" class="form-control" placeholder="Password" required="">
          </div>

          <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Initialize website</button>
          <p class="mt-5 mb-3 text-muted text-center">© 2018 - 2019</p>
        </form>

    </body>
</html>

<!-- jQuery -->
<script src="https://server.dutchwebs.com/cms/js/jquery.js"></script>
<script src="https://server.dutchwebs.com/cms/js/jquery-ui-1.12.1/jquery-ui.min.js"></script>

<!-- canvas inline mobile video player -->
<script src="https://server.dutchwebs.com/cms/js/canvas-video-player.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="https://server.dutchwebs.com/cms/js/bootstrap.min.js"></script>
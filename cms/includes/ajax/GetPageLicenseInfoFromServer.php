<?php

    require("../../../config.php");
    require("../../../includes/db.php");
    require("../../../includes/main-class.php");

    //kijk of iemand is ingelogd...
    $Auth = Authenticate::checkAuth($db);

    $paginaId = filter_var($_POST['p'], FILTER_SANITIZE_NUMBER_INT);

    function encrypt( $key, $plaintext, $meta = '' ) {
    	// Generate valid key
    	$key = hash_pbkdf2( 'sha256', $key, '', 10000, 0, true );
    	// Serialize metadata
    	$meta = serialize($meta);
    	// Derive two subkeys from the original key
    	$mac_key = hash_hmac( 'sha256', 'mac', $key, true );
    	$enc_key = hash_hmac( 'sha256', 'enc', $key, true );
    	$enc_key = substr( $enc_key, 0, 32 );
    	// Derive a "synthetic IV" from the nonce, plaintext and metadata
    	$temp = $nonce = ( 16 > 0 ? mcrypt_create_iv( 16 ) : "" );
    	$temp .= hash_hmac( 'sha256', $plaintext, $mac_key, true );
    	$temp .= hash_hmac( 'sha256', $meta, $mac_key, true );
    	$mac = hash_hmac( 'sha256', $temp, $mac_key, true );
    	$siv = substr( $mac, 0, 16 );
    	// Encrypt the message
    	$enc = mcrypt_encrypt( 'rijndael-128', $enc_key, $plaintext, 'ctr', $siv );
    	return base64_encode( $siv . $nonce . $enc );
    }

    if(!empty($paginaId)) {

        try {

            $websiteSettings = new Settings($db);
            $pagina = new Pagina($db, $paginaId);

            //API call to server.dutchwebs.com
            $url = 'https://server.dutchwebs.com/portaal/api/';
            $ch = curl_init($url);

            $loginEmail = $_COOKIE["email"];
            $encryptedPassword = $_COOKIE["hashedPass"];

            //encrypt Params
            $key = 'Baloo is de liefste hond van allemaal!';
            $login = encrypt($key, $loginEmail);
            $pass = encrypt($key, decryptIt($encryptedPassword));

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                "getLicenseInfo" => "true",
                "u" => $login,
                "p" => $pass,
                "domain" => $_SERVER['SERVER_NAME']
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            $err = curl_error($ch);

            curl_close($ch);

            if ($err) {
             echo "cURL Error #:" . $err;
            }

            die($response);

        } catch(Exception $e) {
            die("Er ging wat fout: " . $e->getMessage());
        }

    }else {
        die("Geen pagina id meegegeven...");
    }

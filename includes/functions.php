<?php

   function encryptIt( $q ) {
        $cryptKey  = 'f82739fbubf3wp9fh3f2389';
        $qEncoded  = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
        return( $qEncoded );
   }

   function decryptIt( $q ) {
        $cryptKey  = 'f82739fbubf3wp9fh3f2389';
        $qDecoded  = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
        return( $qDecoded );
   }

    function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    function object_to_array($data) {
            
        if (is_array($data) || is_object($data))
        {
            $result = array();
            foreach ($data as $key => $value)
            {
                $result[$key] = object_to_array($value);
            }
            return $result;
        }
        return $data;
    }

    function url(){
        if(isset($_SERVER['HTTPS'])){
            $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
        }
        else{
            $protocol = 'http';
        }
        return $protocol . "://" . $_SERVER['HTTP_HOST'] . "/";
    }

    function array_flatten($arrayOrObject,$return) {
        
        $array = object_to_array($arrayOrObject);
        
        for($x = 0; $x <= count($array); $x++) {
            if(is_array($array[$x])) {
                $return = array_flatten($array[$x], $return);
            }
            else {
                if(isset($array[$x])) {
                    $return[] = $array[$x];
                }
            }
        }
        return $return;
    }

    function remove_element_by_value($arr, $val) {
       $return = array(); 
       foreach($arr as $k => $v) {
          if(is_array($v)) {
             $return[$k] = remove_element_by_value($v, $val); //recursion
             continue;
          }
          if($v == $val) continue;
          $return[$k] = $v;
       }
       return $return;
    }

    function array_filter_recursive($array) {
       foreach ($array as $key => &$value) {
          if (empty($value)) {
             unset($array[$key]);
          }
          else {
             if (is_array($value)) {
                $value = array_filter_recursive($value);
                if (empty($value)) {
                   unset($array[$key]);
                }
             }
          }
       }

       return $array;
    }
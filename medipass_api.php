<?php
$file = basename(__FILE__);
if (preg_match('~' . $file . '~i', $_SERVER['REQUEST_URI'])) {die('This file cannot be accessed directly!');}

function medipass_call($path,$key,$params = '',$post = '') {
  $api = 'https://dev-api-au.medipass.io/v2/'.$path.$params; //test
  //$api = 'https://api-au.medipass.io/'.$path.$params; //live
  $headers = [];
  $request_headers = array();
  $request_headers[] = 'authorization: Bearer '.$key;
  $request_headers[] = "x-appid: YOUR_APP_ID;
  $request_headers[] = "x-appver: YOUR_APP_VERSION";
  $request_headers[] = "Accept: application/json";
  if ($path == 'invoices') {
    $request_headers[] = 'Content-Type: application/json';
  }

  $request = curl_init($api); // initiate curl object
  curl_setopt($request, CURLOPT_HTTPHEADER, $request_headers);
  curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); 
  curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt ($request, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2 );
  if (strlen($post) > 0) {
    curl_setopt($request, CURLOPT_POST, 1);
    curl_setopt($request, CURLOPT_POSTFIELDS,
            $post);
  }
  $response = (string)curl_exec($request); // execute curl fetch and store results in $response

  if ( !$response ) {
      die(curl_error($request));
  }
  curl_close($request); // close curl object

  return $result = json_decode($response, true);
}

?>

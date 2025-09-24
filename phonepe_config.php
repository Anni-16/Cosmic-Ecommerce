<?php

// ==========================
// PhonePe Configuration
// ==========================

$client_id="TEST-M234U07GS3MSS_25091";
$client_version=1;
$client_secret="ZWE4MGE1OGMtYmIxOC00ZTRlLWE1NmUtNjcwODg1OTUwYWY5";
$grant_type="client_credentials";
    
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api-preprod.phonepe.com/apis/pg-sandbox/v1/oauth/token',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'client_id='.$client_id.'&client_version='.$client_version.'&client_secret='.$client_secret.'&grant_type='.$grant_type,
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$getToken=json_decode($response, true) ;

//echo $getToken['access_token'];
if(isset($getToken['access_token']) && $getToken['access_token'] !=''){
    // print_r($getToken);
    $accessToken=$getToken['access_token'];
    $expires_at=$getToken['expires_at'];
// Save this details in the database to use access token and check expiry

}else{
    $accessToken='';
    $expires_at='';
}

?>
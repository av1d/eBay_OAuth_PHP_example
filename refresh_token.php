<?php

/*
   Takes the Refresh Token from UserAccessToken.json and exchanges it for a new User Access Token.
   Do not run this until you've generated that file. 
*/


// do not store your credentials in the PHP file like this, it is unsafe.
$my_AppID   = "";
$my_CertID  = "";
$my_Ru_Name = "";

// load the token
$refreshToken = file_get_contents('./tokens/UserAccessToken.json');
$refreshToken = json_decode($refreshToken, TRUE);
$refreshToken = $refreshToken["refresh_token"];


function base64_encode_string($concatenated_credentials) {
    $concatenated_credentials_bytes = utf8_encode($concatenated_credentials);
    $base64_string                  = base64_encode($concatenated_credentials_bytes);
    return $base64_string;
}


$encoded_string = base64_encode_string($my_AppID . ":" . $my_CertID);
$auth_string    = "Basic " . $encoded_string;


$headers = array(
    "Content-Type: application/x-www-form-urlencoded", 
    "Authorization: $auth_string"
);

$data = array(
    "grant_type"    => "refresh_token",
    "refresh_token" => $refreshToken,
    "client_id"     => $my_AppID,
    "client_secret" => $my_CertID
);


$ch = curl_init("https://api.ebay.com/identity/v1/oauth2/token");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

$response = curl_exec($ch);


// save the JSON response:
// do not actually store this in this manner, it is unsafe.
file_put_contents("./tokens/RefreshToken.json", $response);


// access the JSON data:
$data = json_decode($response, true);

echo $data["access_token"];

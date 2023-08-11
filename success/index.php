<?php

/*
   Captures the consent token and then issues a User Access Token and Refresh Token
   along with the expiration times.
   Do not run this directly, it is for capturing responses only.
*/


// do not store your credentials in the PHP file like this, it is unsafe.
$my_AppID   = "";
$my_CertID  = "";
$my_Ru_Name = "";


function base64_encode_string($concatenated_credentials) {
    $concatenated_credentials_bytes = utf8_encode($concatenated_credentials);
    $base64_string                  = base64_encode($concatenated_credentials_bytes);
    return $base64_string;
}



if (!empty($_GET)) {  // if there's a request
    $consent_code = $_GET["code"];
} else {
    echo "No consent token received.";
    exit;
}


$encoded_string = base64_encode_string($my_AppID . ":" . $my_CertID);
$auth_string    = "Basic " . $encoded_string;


$headers = array(
    "Content-Type: application/x-www-form-urlencoded", 
    "Authorization: $auth_string"
);

$data = array(
    "grant_type" => "authorization_code",
    "code" => $consent_code,
    "redirect_uri" => $my_Ru_Name
);


$ch = curl_init("https://api.ebay.com/identity/v1/oauth2/token");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

$response = curl_exec($ch);


// save the JSON response:
// do not actually store this in this manner, it is unsafe.
file_put_contents("../tokens/UserAccessToken.json", $response);


// access the JSON data:
$data = json_decode($response, true);

$access_token             = $data['access_token'];
$expires_in               = $data['expires_in'];
$refresh_token            = $data['refresh_token'];
$refresh_token_expires_in = $data['refresh_token_expires_in'];
$token_type               = $data['token_type'];


// print the data:

echo <<<HTML
    <!DOCTYPE html>
    <html lang="en">
      <head>
        <title>User Access & Refresh Tokens</title>
      </head>
        <body>
HTML;

echo "<b>Access Token:</b> "             . $access_token             . "<br>";
echo "<b>Expires In:</b> "               . $expires_in               . "<br>";
echo "<b>Refresh Token:</b> "            . $refresh_token            . "<br>";
echo "<b>Refresh Token Expires In:</b> " . $refresh_token_expires_in . "<br>";
echo "<b>Token Type:</b> "               . $token_type               . "<br>";

echo "</body></html>";

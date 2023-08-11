<?php

/*
 eBay OAuth consent request / authorization grant flow to obtain User Access and Refresh Tokens.
 Also refreshes the User Access Token.
*/

$my_AppID   = "";
$my_CertID  = "";
$my_Ru_Name = "";


// you can specify additional scopes here. Pay attention to the spaces at the end, they are necessary.
$scope = 
         "https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.account "
        ."https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly "
;

$scope = urlencode($scope);

$url = "https://auth.ebay.com/oauth2/authorize?client_id=$my_AppID&redirect_uri=$my_Ru_Name&response_type=code&scope=$scope&";

header ("location: " . $url);  // redirect the user to the eBay Consent Page

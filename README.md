# eBay_OAuth_PHP_example
Grant User Access &amp; Refresh Tokens, refreshes User tokens.

This is an example in PHP of how to follow the authorization grant flow. It directs the user to the eBay consent page and grants them a consent token which is then exchanged for the User Access Token and Refresh Token. Also included is an example of how to refresh the User Access Token.

 The index.php file in the root directory will redirect the user to the eBay consent form. If they're not logged into eBay, they will be  prompted to login. If/when they are logged in, eBay will display the list of permissions this application  has defined in its scope. If they agree, eBay will send the Consent Token to /success/index.php which will capture it. The Consent Token is then automatically exchanged for a User Access Token and Refresh Token.
 
 At the time of this writing, the Refresh Token is valid for 18 months and the User Access Token is valid for 2 hours. Therefore, in your application you will need to check when the User Access Token was granted, and if it has expired, then you will need to use the Refresh Token to generate a new User Access Token.
 
 All received tokens will be located in ./tokens/
 
 Requirements:
   developer account from https://developer.ebay.com/
   create an application key https://developer.ebay.com/my/keys
   
 On the Application Keys page (https://developer.ebay.com/my/keys) click User Tokens under your application. Scroll down the page to "Your eBay Sign-in Settings" and look for "Your auth accepted URL1". Set this field to the URL on your server where the /success/ folder is (do not include index.php in the URL). For example: https://example.org/ebay-oauth-example/success/
 
 From this same section, copy the "RuName (eBay Redirect URL name)".
 Go back to the Application Keys page, copy your App ID and Cert ID credentials.
 
 Place these credentials into each PHP script in this example (both index.php files and refresh_token.php).
 
 To use this example, you will never access /success/index.php directly. Instead, you will access the main index.php file. For example: https://example.org/ebay-oauth-example/
 This is the page which will bring you to the eBay consent page.
 
 Once the user has consented, eBay will redirect to the /success/ URL which will capture the Consent Token, then exchange this token for the Refresh Token and User Access Token.
 The resulting tokens will be printed on the page and deposited in ./tokens/UserAccessToken.json
 
 To refresh the User Access Token, run refresh_token.php.
 The refresh token will be deposited in ./tokens/RefreshToken.json
 
 Note that this example is a basic implementation and does not refresh tokens automatically. You will need to add additional logic, error handling and security. Always store your credentials outside of the web root or in a database, never hard-code them or store the received tokens in flat files in the web root. It is a security risk.
 
 Additional info:
   https://developer.ebay.com/api-docs/static/oauth-consent-request.html
   https://developer.ebay.com/api-docs/static/oauth-auth-code-grant-request.html
   
   
 Warning: do not store any credentials in code or in your web root.
This example is just for demonstration purposes only and is not authorized by eBay.

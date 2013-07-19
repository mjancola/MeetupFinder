<?php
  session_start(); 
  require_once 'HTTP/Client.php';
  //include 'http_client.inc';
  $code = $_GET['code'];
  $state = $_GET['state'];
 
 // error_log("got code=" + $code, 3, "~/error.log");
  error_log("got state=" + $state, 4);

  // Verify the 'state' value is the same random value we created when initiating the authorization request.
  //if ((! is_numeric($state)) || ($state != $_SESSION['state']))
   // throw new Exception('Error validating state. Possible CSRF.'

  $accessTokenExchangeUrl = 'https://foursquare.com/oauth2/access_token?';
  $redirectUriPath = '/fourauth_bharath.php';
// Linkedin requires the following parameters
  $accessTokenExchangeParams = array(
    'grant_type' => 'authorization_code',
    'redirect_uri' => (isset($_SERVER['HTTPS'])?'https://':'http://') .
                $_SERVER['HTTP_HOST'] . $redirectUriPath,
    'client_id' => 'EIFO1DOWBVOLJZHESQWPA03VYAYUOJFPXB5OYW05DUJ2VHHD', 
    'client_secret' => 'E3QT30H2MFODR2NWJBCWKLIDKJOLQBJ3JRHQCL4G3V1QD4TN',
    'code' => $code,);

  $httpClient = new Http_Client();
  $responseRaw = $httpClient->get($accessTokenExchangeUrl, $accessTokenExchangeParams);
  $all=$httpClient->currentResponse();
  $body=$all['body'];
  $resCode=$all['code'];
  print("<h2>body=$body</h2>");
  print("<h2>resCode=$resCode</h2>");
  print("<h1>response=$responseRaw</h1>");
  print("<h1>code=$code</h1>");

  // helper automatically parses into variables named like the query keys  
  
  $token = json_decode($body);
  
    $_SESSION['access_token'] = $token->access_token; // guard this!
    $_SESSION['expires_in']   = $token->expires_in; // relative time (in seconds)
    $_SESSION['expires_at']   = time() + $_SESSION['expires_in']; // absolute time

  $accessToken = $_SESSION['access_token'];
  $expires = $_SESSION['expires_in'];
                    
  print("<h1>access=$accessToken</h1>");
  print("<h2>expires=$expires</h2>"); 
 // error_log("accessToken=" + $accessToken, 0);
 //header('Location: /location_retrieval.php');
 header('Location: /bharath_foursquare_results.php');
?> 

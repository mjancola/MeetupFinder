<?php
  session_start(); 
  require_once 'HTTP/Client.php';
  
  $code = $_GET['code'];
  $state = $_GET['state'];

  $accessTokenExchangeUrl = 'https://foursquare.com/oauth2/access_token?';
  $redirectUriPath = 'meetup.hopto.org/app/oauthfoursquareback.php';

  // Foursquare requires the following parameters
  $accessTokenExchangeParams = array(
    'grant_type' => 'authorization_code',
    'redirect_uri' => (isset($_SERVER['HTTPS'])?'https://':'http://') . $redirectUriPath,
    'client_id' => 'FGCPSWBQHUYHNBL0G3U3OLUE4PLP1BVJSJGWI5VUEFMB3JAK', 
    'client_secret' => '1DKYZE0EXV0X2EKE11LR5OENEO1RUGGYTQ4C5G0KSRJ4FV3L',
    'code' => $code,);

  $httpClient = new Http_Client();
  $responseRaw = $httpClient->get($accessTokenExchangeUrl, $accessTokenExchangeParams);
  $all=$httpClient->currentResponse();
  $body=$all['body'];
  $resCode=$all['code'];
  //print("<h2>body=$body</h2>");
  //print("<h2>resCode=$resCode</h2>");
  //print("<h1>response=$responseRaw</h1>");
  //print("<h1>code=$code</h1>");

  // helper automatically parses into variables named like the query keys  
  
  $token = json_decode($body);
  
    $_SESSION['fs_token'] = $token->access_token; // guard this!
    $_SESSION['fs_expires']  = $token->expires_in; // relative time (in seconds)
    $_SESSION['expires_at']   = time() + $_SESSION['expires_in']; // absolute time

  $access_token = $_SESSION['fs_token'];
  $expires = $_SESSION['fs_expires'];
  $claimed_id = $_SESSION['claimed_id'];

  // Foursquare doesn't seem to be setting the expires
  // set it to something valid
  if ($expires == '')
  {
    $expires = 0;
  }
  //print "<h1>access=$access_token</h1>";
  //print "<h2>expires=$expires</h2>"; 
  //print "<h2>claimed_id=$claimed_id</h2>"; 

  // save the values to the DB!
  mysql_connect("localhost", "root", "") or die(mysql_error()); 
  mysql_select_db("meetupfinder_prod") or die(mysql_error()); 
  $query="UPDATE users SET foursquare_token='".$access_token."', foursquare_expires=".$expires." where claimed_id ='".$claimed_id."'";
  //Print "<p>QUERY=".$query."</p>";
  mysql_query($query);

  header('Location: /app/get_foursquare_data.php');
?> 

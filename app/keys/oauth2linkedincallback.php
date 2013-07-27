<?php
  session_start(); 
  require_once 'HTTP/Client.php';
  //include 'http_client.inc';
  $code = $_GET['code'];
  $state = $_GET['state'];

  // Verify the 'state' value is the same random value we created when initiating the authorization request.
  if ((! is_numeric($state)) || ($state != $_SESSION['state']))
    throw new Exception('Error validating state. Possible CSRF.'
  );

  $accessTokenExchangeUrl = 'https://www.linkedin.com/uas/oauth2/accessToken';
  $redirectUriPath = 'meetup.hopto.org/app/oauth2linkedincallback.php';


  // Linkedin requires the following parameters
  $accessTokenExchangeParams = array(
    'grant_type' => 'authorization_code',
    'redirect_uri' => (isset($_SERVER['HTTPS'])?'https://':'http://') . $redirectUriPath,
    'client_id' => '8kq4mhd5zyg1', 
    //'client_id' => '4szyuwih9i83', 
    //'client_secret' => '29sIwayaMjIBwW31',
    'client_secret' => 'DB5xp8FWOu2ux914',
    'code' => $code);

  $httpClient = new Http_Client();
  $responseRaw = $httpClient->get($accessTokenExchangeUrl, $accessTokenExchangeParams);
  $all=$httpClient->currentResponse();
  $body=$all['body'];
  $resCode=$all['code'];
   print("<h2>body=$body</h2>");
 // print("<h2>resCode=$resCode</h2>");
 // print("<h1>response=$responseRaw</h1>");
 // print("<h1>code=$code</h1>");

  // helper automatically parses into variables named like the query keys  
  
  $token = json_decode($body);
  
  $_SESSION['access_token'] = $token->access_token; // guard this!
  $_SESSION['access_expires']   = $token->expires_in; // relative time (in seconds)
  $_SESSION['expires_at']   = time() + $_SESSION['expires_in']; // absolute time

  $access_token = $_SESSION['access_token'] ;
  $expires = $_SESSION['access_expires'];
  $claimed_id = $_SESSION['claimed_id'];
                    
 // Print "<h1>access=$access_token</h1>";
// Print "<h2>expires=$expires</h2>"; 
  Print "<h2>claimed_id=".$claimed_id."</h2";

  // save the values to the DB!
  mysql_connect("localhost", "root", "") or die(mysql_error()); 
  mysql_select_db("meetupfinder_prod") or die(mysql_error()); 
  $query="UPDATE users SET linkedin_token='".$access_token."', linkedin_expires=".$expires." where claimed_id ='".$claimed_id."'";
  Print "<p>QUERY=".$query."</p>";
  mysql_query($query);
  header('Location: /app/get_linkedin_data.php');
?> 


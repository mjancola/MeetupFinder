<?php
  session_start();
  //define('SCOPE', 'r_fullprofile r_network r_basicprofile r_emailaddress rw_nus' );
  
  // unique session variable to passed to Authenication server as our state
  $_SESSION['state'] = rand(0,999999999);
  $authorizationUrlBase = 'https://foursquare.com/oauth2/authenticate';
  $redirectUriPath = '/oauthfoursquareback.php';

  // Facebook requires client_id = app_id and a redirect uri
  $queryParams = array(
    'client_id' => 'PU3V513OEAG4GXUQPRHV4FFCLJ4JXHUOXUKBDD4MNLWXJV5E',  // app_id from Facebook
    'client_secret' => 'MLBSU00CK5AQWRPTGIY21130NRVXCZBWBY2GMP2LO5PEEWFT',
    'redirect_uri' => (isset($_SERVER['HTTPS'])?'https://':'http://') .
                $_SERVER['HTTP_HOST'] . $redirectUriPath,
              
    // optional params
    //'state' => $_SESSION['state'],
    'state' => uniqid('', true),
    'response_type' => 'code',);

  $goToUrl = $authorizationUrlBase . '?' . http_build_query($queryParams);

  // Output a webpage directing users to the $goToUrl after
  // they click a "Let's Go" button
  include 'access_request_templatefoursquare.php';
?>



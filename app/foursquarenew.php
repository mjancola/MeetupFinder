<?php
  session_start();
  //define('SCOPE', 'r_fullprofile r_network r_basicprofile r_emailaddress rw_nus' );
  //print("<h1>token=".$_SESSION['fs_token']."</h1>");
  
  if ((!isset($_SESSION['fs_token'])) || (empty($_SESSION['fs_token'])) || ($_SESSION['fs_token'] == ''))
  {
    // unique session variable to passed to Authenication server as our state
    $_SESSION['state'] = rand(0,999999999);
    $authorizationUrlBase = 'https://foursquare.com/oauth2/authenticate';
    $redirectUriPath = '/app/oauthfoursquareback.php';

    // Foursquare required parameters
    $queryParams = array(
      'client_id' => 'PU3V513OEAG4GXUQPRHV4FFCLJ4JXHUOXUKBDD4MNLWXJV5E',  // app_id from Foursquare
      'client_secret' => 'MLBSU00CK5AQWRPTGIY21130NRVXCZBWBY2GMP2LO5PEEWFT',
      'redirect_uri' => (isset($_SERVER['HTTPS'])?'https://':'http://') .
                $_SERVER['HTTP_HOST'] . $redirectUriPath,
              
    // optional params
    'state' => uniqid('', true),
    'response_type' => 'code',);

    $goToUrl = $authorizationUrlBase . '?' . http_build_query($queryParams);

    // Output a webpage directing users to the $goToUrl after
    // they click a "Let's Go" button
    include 'access_request_templatefoursquare.php';
  }
  else
  {
    // We have a token already, just do the query
    $_SESSION['access_token'] = $_SESSION['fs_token'];
    $_SESSION['expires'] = $_SESSION['fs_expires'];

    //print("<h1>access=".$_SESSION['access_token']."</h1>");
    //print("<h2>expires=".$_SESSION['expires']."</h2>");
    header('Location: http://54.225.92.231/app/get_foursquare_data.php');
  }

?>


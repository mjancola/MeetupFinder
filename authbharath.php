<?php
  session_start();
  //define('SCOPE', 'r_fullprofile r_network r_basicprofile r_emailaddress rw_nus' );
  
  // unique session variable to passed to Authenication server as our state
  $_SESSION['state'] = rand(0,999999999);
  $authorizationUrlBase = 'https://foursquare.com/oauth2/authenticate';
  $redirectUriPath = '/fourauth_bharath.php';

  // Facebook requires client_id = app_id and a redirect uri
  $queryParams = array(
    'client_id' => 'EIFO1DOWBVOLJZHESQWPA03VYAYUOJFPXB5OYW05DUJ2VHHD',  // app_id from Facebook
    'client_secret' => 'E3QT30H2MFODR2NWJBCWKLIDKJOLQBJ3JRHQCL4G3V1QD4TN',
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



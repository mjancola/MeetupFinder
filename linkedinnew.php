<?php
  session_start();
  define('SCOPE', 'r_fullprofile r_network r_basicprofile r_emailaddress rw_nus' );
  
  // unique session variable to passed to Authenication server as our state
  $_SESSION['state'] = rand(0,999999999);
  $authorizationUrlBase = 'https://www.linkedin.com/uas/oauth2/authorization';
  $redirectUriPath = '/oauth2linkedincallback.php';

  // Facebook requires client_id = app_id and a redirect uri
  $queryParams = array(
    'client_id' => '4szyuwih9i83',  // app_id from Facebook
    'client_secret' => '29sIwayaMjIBwW31',
    'redirect_uri' => (isset($_SERVER['HTTPS'])?'https://':'http://') .
                $_SERVER['HTTP_HOST'] . $redirectUriPath,
              
    // optional params
    'state' => $_SESSION['state'],
    'response_type' => 'code',
    'scope' => SCOPE );

  $goToUrl = $authorizationUrlBase . '?' . http_build_query($queryParams);

  // Output a webpage directing users to the $goToUrl after
  // they click a "Let's Go" button
  include 'access_request_templatelinkedin.php';
?>

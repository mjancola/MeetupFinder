<?php
  session_start();
  // save the session data that was posted to us
  //$_SESSION['name'] = $_POST['name'];
  //$_SESSION['location'] = $_POST['location'];
 
  // unique session variable to passed to Authenication server as our state
  $_SESSION['state'] = rand(0,999999999);
  $authorizationUrlBase = 'https://www.facebook.com/dialog/oauth';
  $redirectUriPath = '/oauth2fbcallback.php';

  // Facebook requires client_id = app_id and a redirect uri
  $queryParams = array(
    'client_id' => '146448285541021',  // app_id from Facebook
    'redirect_uri' => (isset($_SERVER['HTTPS'])?'https://':'http://') .
		$_SERVER['HTTP_HOST'] . $redirectUriPath,
    // optional params
    'state' => $_SESSION['state'],
    'response_type' => 'code',
    'scope' => 'friends_hometown');

  $goToUrl = $authorizationUrlBase . '?' . http_build_query($queryParams);

  // Output a webpage directing users to the $goToUrl after
  // they click a "Let's Go" button
  include 'fb_request_access.php';
?>

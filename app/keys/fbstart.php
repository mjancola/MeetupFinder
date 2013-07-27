<?php
  session_start();
  
  if ((!isset($_SESSION['fb_token'])) || (empty($_SESSION['fb_token'])) || ($_SESSION['fb_token'] == ''))
  {
    // unique session variable to passed to Authenication server as our state
    $_SESSION['state'] = rand(0,999999999);
    $authorizationUrlBase = 'https://www.facebook.com/dialog/oauth';
    $redirectUriPath = 'meetup.hopto.org/app/oauth2fbcallback.php';

    // Facebook requires client_id = app_id and a redirect uri
    $queryParams = array(
      'client_id' => '146448285541021',  // app_id from Facebook
      'redirect_uri' => (isset($_SERVER['HTTPS'])?'https://':'http://') . $redirectUriPath,
      //'redirect_uri' => (isset($_SERVER['HTTPS'])?'https://':'http://') .
      //		$_SERVER['HTTP_HOST'] . $redirectUriPath,
      // optional params
      'state' => $_SESSION['state'],
      'response_type' => 'code',
      'scope' => 'friends_hometown');

    $goToUrl = $authorizationUrlBase . '?' . http_build_query($queryParams);
    // print("<h2>gotoURL=".$gotoURL."</h2>");

    // Output a webpage directing users to the $goToUrl after
    // they click a "Let's Go" button
    echo "We dont have the fb token";
    header("Location: $goToUrl");
    //include 'fb_request_access.php';
  } 
  else
  {
    // We have a token already, just do the query
    //$_SESSION['access_token'] = $_SESSION['fb_token'];
    //$_SESSION['expires'] = $_SESSION['fb_expires'];

    //print("<h1>access=".$_SESSION['fb_token']."</h1>");
    //print("<h2>expires=".$_SESSION['expires']."</h2>");
    header('Location: /app/get_fb_data.php');
  }
?>

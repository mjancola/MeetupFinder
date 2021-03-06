<?php
  session_start();
  //define('SCOPE', 'r_fullprofile r_network r_basicprofile r_emailaddress rw_nus' );
  //print("<h1>token=".$_SESSION['fs_token']."</h1>");
  
  if ( (!isset($_SESSION['fs_token'])) || 
       (empty($_SESSION['fs_token'])) ||
       ($_SESSION['fs_token'] == '') ) 
       // foursquare oauth tokens don't expire! 
       //(time() > $_SESSION['fs_expires']) )
  {
    // unique session variable to passed to Authenication server as our state
    $_SESSION['state'] = rand(0,999999999);
    $authorizationUrlBase = 'https://foursquare.com/oauth2/authenticate';
    $redirectUriPath = 'meetup.hopto.org/app/oauthfoursquareback.php';

    // Foursquare required parameters
    $queryParams = array(
      'client_id' => 'xxx',  // app_id from Foursquare
      'client_secret' => 'xxx',
      'redirect_uri' => (isset($_SERVER['HTTPS'])?'https://':'http://') . $redirectUriPath,
              
    // optional params
    'state' => uniqid('', true),
    'response_type' => 'code',);

    $goToUrl = $authorizationUrlBase . '?' . http_build_query($queryParams);

    // Output a webpage directing users to the $goToUrl after
    // they click a "Let's Go" button
    //echo "four square is  not set in our app this line is from foursquarenew.php";
    // header("Location:$goToUrl");
    include 'access_request_templatefoursquare.php';
  }
  else
  {
    // We have a token already, just do the query
    //print("<h1>access=".$_SESSION['fs_token']."</h1>");
    //print("<h2>expires=".$_SESSION['fs_expires']."</h2>");
    header('Location: http://meetup.hopto.org/app/get_foursquare_data.php');
  }

?>


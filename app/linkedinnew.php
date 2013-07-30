<?php
  session_start();

  if ( (!isset($_SESSION['li_token'])) ||
       (empty($_SESSION['li_token'])) || 
       ($_SESSION['li_token'] == '') ||
       (time() > $_SESSION['li_expires']) )
  {
    define('SCOPE', 'r_fullprofile r_network r_basicprofile r_emailaddress rw_nus' );
  
    // unique session variable to passed to Authenication server as our state
    $_SESSION['state'] = rand(0,999999999);
    $authorizationUrlBase = 'https://www.linkedin.com/uas/oauth2/authorization';
    $redirectUriPath = 'meetup.hopto.org/app/oauth2linkedincallback.php';

    // LinkedIn requires client_id = app_id and a redirect uri
    $queryParams = array(
      'client_id' => 'zzz',  // app_id from LinkedIn
      'client_secret' => 'zzz',
      'redirect_uri' => (isset($_SERVER['HTTPS'])?'https://':'http://') . $redirectUriPath,
              
      // optional params
      'state' => $_SESSION['state'],
      'response_type' => 'code',
      'scope' => SCOPE );

    $goToUrl = $authorizationUrlBase . '?' . http_build_query($queryParams);

    // Output a webpage directing users to the $goToUrl after
    // they click a "Let's Go" button
    header("Location: $goToUrl");
  }
  else
  {
    // We have a token already, just do the query
    $_SESSION['li_token'];
    $_SESSION['li_expires'];

    print("<h1>access=".$_SESSION['li_token']."</h1>");
    print("<h2>expires=".$_SESSION['li_expires']."</h2>");
    header('Location: /app/get_linkedin_data.php');
  }


?>

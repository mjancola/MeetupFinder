<?php
  session_start();
  require_once 'HTTP/Client.php';

  // unique session variable to passed to Authenication server as our state
  $_SESSION['state'] = rand(0,999999999);
 
  $redirectUriPath = '/app/openidauth.php';

  $gotoUrl =  (isset($_SERVER['HTTPS'])?'https://':'http://') .
		$_SERVER['HTTP_HOST'] . $redirectUriPath;

  // Output a webpage directing users to login with Google, redirecting to $gotoUrl
  include 'google.php';

?>

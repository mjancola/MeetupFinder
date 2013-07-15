<?php
  session_start();
  require_once 'HTTP/Client.php';

  // unique session variable to passed to Authenication server as our state
  $_SESSION['state'] = rand(0,999999999);
 
  $redirectUriPath = '/Open_login.php';

  $gotoUrl =  (isset($_SERVER['HTTPS'])?'https://':'http://') .
		$_SERVER['HTTP_HOST'] . $redirectUriPath;

  // Output a webpage directing users to the $goToUrl after
  // they click a "Let's Go" button
  include 'openid_msg.php';

?>

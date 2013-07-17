<?php
  session_start();
  require_once 'HTTP/Client.php';

  // unique session variable to passed to Authenication server as our state
  // second time post to this page
  $_SESSION['state'] = rand(0,999999999);

  $redirectUriPath = '/app/openidauth.php';

  $gotoUrl =  (isset($_SERVER['HTTPS'])?'https://':'http://') .
	$_SERVER['HTTP_HOST'] . $redirectUriPath;

  //include 'google.php';
?>
<h2>Welcome to the Meetup Finder</h2>
<p>Press a button to login using your account with of our affiliates</p>

<a href=http://54.225.92.231/app/openidauth.php ><img src="google.jpg" > </a>


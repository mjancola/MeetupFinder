
<html>
<body>
<style>
body 
{
  background: url(wix.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}

P
{
text-align:center;
}

</style>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<?php
  session_start();
  session_unset();
  require_once 'HTTP/Client.php';

  // unique session variable to passed to Authenication server as our state
  // second time post to this page
  $_SESSION['state'] = rand(0,999999999);

  $redirectUriPath = '/app/openidauth.php';

  $gotoUrl =  (isset($_SERVER['HTTPS'])?'https://':'http://') .
	$_SERVER['HTTP_HOST'] . $redirectUriPath;

  //include 'google.php';
?>

<p style="font-family:arial;color:white;font-size:30px;">
<b>Press a button to login using your account with of our affiliates</b>
<center><a href=http://54.225.92.231/app/openidauth.php ><img src="google.jpg" > </a></center>


</p>
</body>
</html> 

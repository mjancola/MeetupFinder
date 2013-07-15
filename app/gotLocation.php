<?php
  session_start();
  require_once 'HTTP/Client.php';

  // save the location requested
  $_SESSION['location'] = $_POST['location'];
  //$location = $_SESSION['location'];

  // print("<h2>location=$location</h2>");
 
  $liURL = (isset($_SERVER['HTTPS'])?'https://':'http://') .
		$_SERVER['HTTP_HOST'] .  '/app/linkedinnew.php';
  $fbURL = (isset($_SERVER['HTTPS'])?'https://':'http://') .
		$_SERVER['HTTP_HOST'] .  '/app/fbstart.php';
  $fsqURL = (isset($_SERVER['HTTPS'])?'https://':'http://') .
                $_SERVER['HTTP_HOST'] .  '/foursquarennew.php'; 
 Print "<tr><td>&nbsp;</td></tr>";
  Print "<tr><td>fbURL=".$fbURL."</td></tr>";
  Print "<tr><td>&nbsp;</td></tr><tr><td>";
  include 'partnerButtons.php';
  
  Print"</td></tr></table></body></html>";
?>

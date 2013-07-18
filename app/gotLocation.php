<?php
  session_start();
  require_once 'HTTP/Client.php';

  // save the location requested
  $_SESSION['location'] = $_POST['location'];
  $location = $_SESSION['location'];
 
  $liURL = (isset($_SERVER['HTTPS'])?'https://':'http://') .
		$_SERVER['HTTP_HOST'] .  '/app/linkedinnew.php';
  $fbURL = (isset($_SERVER['HTTPS'])?'https://':'http://') .
		$_SERVER['HTTP_HOST'] .  '/app/fbstart.php';
  $fsqURL = (isset($_SERVER['HTTPS'])?'https://':'http://') .
                $_SERVER['HTTP_HOST'] .  '/foursquarennew.php'; 
  Print "<html><body bgcolor=#CCFFFF>";

  Print "<h1>Meetup Finder</h1>";
  print "<html><body bgcolor=#CCFFFF>";
  print "<button style='background-color:#CD2222;color:white' onclick='home()'>Home</button>";
  print "&nbsp;";
  print "<button style='background-color:#CD2222;color:white' onclick='signout()'>Log Out</button>";

  print("<h2>Choose a social platform to search for friends in '".$location."'</h2>");
  Print "<a href= '".$fbURL."'><img src='facebook.jpg' ></a>";
  Print "&nbsp;";
  Print "<a href= '".$liURL."'><img src='linkedin.png' ></a>";
  
  Print"</body></html>";
?>

<?php
  session_start();
  Print"<html><body>";
  if ($_SESSION['newuser'] == "true")
  {
    Print"<h1>Welcome to Meetup Finder, ".$_SESSION['name']."</h1>";
  }
  else
  {
    Print "<h1>Welcome back, ".$_SESSION['name']."</h1>";
  }
  print "<button style='background-color:#CD2222;color:white' onclick='signout()'>Log Out</button>";
  include 'getLocation.php';
  
  Print "<hr>"; 
  Print "<br />";
/*  Print "<h2>(DEBUG) Here is the info we have on you:</h2>";

    Print "<table>";
      Print "<tr><td><b>Claimed_id</b></td><td>" .$_SESSION['claimed_id']. "</td></tr> "; 
      Print "<tr><td><b>Email</b></td><td>" .$_SESSION['email']. "</td></tr> "; 
      Print "<tr><td><b>Facebook Token</b></td><td>" .$_SESSION['fb_token']. "</td></tr> "; 
      Print "<tr><td><b>Facebook Expires</b></td><td>" .$_SESSION['fb_expires']. "</td></tr> "; 
      Print "<tr><td><b>LinkedIn Token</b></td><td>" .$_SESSION['li_token']. "</td></tr> "; 
      Print "<tr><td><b>LinkedIn Expires</b></td><td>" .$_SESSION['li_expires']. "</td></tr> "; 
      Print "<tr><td><b>Foursquare Token</b></td><td>" .$_SESSION['fs_token']. "</td></tr> "; 
      Print "<tr><td><b>Foursquare Expires</b></td><td>" .$_SESSION['fs_expires']. "</td></tr> "; 
    Print "</table>"; 
*/
  Print "</body></html>";


?>
<script>
function signout()
{
  window.location="https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://54.225.92.231/app/meetupfinder";
}
</script>


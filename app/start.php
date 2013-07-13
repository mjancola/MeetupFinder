<?php
  session_start();
  if ($_SESSION['newuser'] == "true")
  {
    Print"<h1>Welcome to Meetup Finder, ".$_SESSION['name']."</h1>";
  }
  else
  {
    Print "<h1>Welcome back, ".$_SESSION['name']."</h1>";
  }
  Print "<h2>Here is the info we have on you:</h2>";
    Print "<table>";
      Print "<tr><td><b>Claimed_id</b></td><td>" .$_SESSION['claimed_id']. "</td></tr "; 
      Print "<tr><td><b>Email</b></td><td>" .$_SESSION['email']. "</td></tr "; 
      Print "<tr><td><b>Facebook Token</b></td><td>" .$_SESSION['facebook_token']. "</td></tr "; 
      Print "<tr><td><b>Facebook Expires</b></td><td>" .$_SESSION['facebook_expires']. "</td></tr "; 
      Print "<tr><td><b>LinkedIn Token</b></td><td>" .$_SESSION['linkedin_token']. "</td></tr "; 
      Print "<tr><td><b>LinkedIn Expires</b></td><td>" .$_SESSION['linkedin_expires']. "</td></tr "; 
      Print "<tr><td><b>Foursquare Token</b></td><td>" .$_SESSION['foursquare_token']. "</td></tr "; 
      Print "<tr><td><b>Foursquare Expires</b></td><td>" .$_SESSION['foursquare_expires']. "</td></tr "; 
    Print "</table>"; 
?>


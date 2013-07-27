<?php
  session_start();
  // refetch the data on this user (in case something has expired)
  mysql_connect("localhost", "root", "") or die(mysql_error()); 
  mysql_select_db("meetupfinder_prod") or die(mysql_error()); 
  $data = mysql_query("SELECT * FROM users where claimed_id='" . $_SESSION['claimed_id'] . "'") or die(mysql_error());  
  $results = mysql_fetch_array( $data );
  $numrows = mysql_num_rows($data);
  //Print "<p>found " . $numrows . " rows</p>";
  Print"<html><body>";
  if ($numrows > 1)
  {
    Print "<p> Application Error - more than one row returned, call 1800HELPME!</p>";
  }
  elseif ($numrows < 1)
  {
    $claimed_id = $_SESSION['claimed_id'];
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    Print"<h1>Welcome to Meetup Finder, ".$_SESSION['name']."</h1>";
    $query="INSERT into users(claimed_id, name, email) VALUES ('$claimed_id','$name','$email')";
    //Print "<p>$query</p>";
    mysql_query($query);
  }
  else
  {
    Print "<h1>Welcome back, ".$_SESSION['name']."</h1>";
   
    // set or reset the session parameters
    $_SESSION['fb_token'] = $results['facebook_token'];
    $_SESSION['fb_expires'] = $results['facebooke_expires'];
    $_SESSION['li_token'] = $results['linkedin_token'];
    $_SESSION['li_expires'] = $results['linkedin_expires'];
    $_SESSION['fs_token'] = $results['foursquare_token'];
    $_SESSION['fs_expires'] = $results['foursquare_expires'];
    
    //echo "facetoken".$_SESSION['fb_token']; to check whether session is released or not in sessionRelease.php
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
  window.location="https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://meetup.hopto.org/app/meetupfinder.php";
}
</script>


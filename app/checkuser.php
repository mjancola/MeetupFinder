<?php   
  session_start();

  // check if we have username in the DB
  // if so, print their credentials
  // otherwise give them the welcome screen
  $name = $_POST['name'];
  $_SESSION['name'] = $_POST['name'];
  $_SESSION['location'] = $_POST['location'];

  mysql_connect("localhost", "root", "CSC9010") or die(mysql_error()); 
  mysql_select_db("meetupfinder") or die(mysql_error()); 
  $data = mysql_query("SELECT * FROM users where name='" . $name . "'") or die(mysql_error());  
  $results = mysql_fetch_array( $data );
  $numrows = mysql_num_rows($data);
  Print "<p>found " . $numrows . " rows</p>";
  if ($numrows > 1)
  {
	Print "<p> Application Error - more than one row returned, call 1800HELPME!</p>";
  }
  elseif ($numrows < 1)
  {
    // Not found, redirect to new page
    //header('Location: /new_openid.php');
    // route them to the new user fb stuff
//    header('Location: /fb2_auto.php');
  }
  else
  {
    Print "<p><b>" . $_SESSION['name'] . "</b> Welcome back!  here is the info we have on you</p>";
    Print "<table border cellpadding=3>"; 

      Print "<tr>"; 
      Print "<th>Name:</th> <td>".$results['name'] . "</td> "; 
      Print "<th>Facebook Token:</th> <td>".$results['facebook_token'] . " </td>"; 
      Print "<th>Facebook Expires:</th> <td>".$results['facebook_expires'] . " </td>"; 

      Print "<th>LinkedIn Token:</th> <td>".$results['linkedin_token'] . " </td>"; 
      Print "<th>LinkedIn Expires:</th> <td>".$results['linkedin_expires'] . " </td>"; 
    
      Print "<th>Foursquare Token:</th> <td>".$results['foursquare_token'] . " </td>"; 
      Print "<th>Foursquare Expires:</th> <td>".$results['foursquare_expires'] . " </td></tr>"; 
    Print "</table>"; 
    // set the session parameters
    $_SESSION['fb_token'] = $results['facebook_token'];
    $_SESSION['fb_expires'] = $results['facebook_expires'];
    $_SESSION['li_token'] = $results['linkedin_token'];
    $_SESSION['li_expires'] = $results['linkedin_expires'];
    $_SESSION['fs_token'] = $results['foursquare_token'];
    $_SESSION['fs_expires'] = $results['foursquare_expires'];
    header('Location: /fb2_auto.php');
    exit();
  }
?> 

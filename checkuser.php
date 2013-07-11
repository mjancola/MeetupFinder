<?php 
  // check if we have username in the DB
  // if so, print their credentials
  // otherwise give them the welcome screen
  $username = $_POST["username"];
  mysql_connect("localhost", "root", "CSC9010") or die(mysql_error()); 
  mysql_select_db("meetupfinder") or die(mysql_error()); 
  $data = mysql_query("SELECT * FROM users where name='" . $username . "'") or die(mysql_error());  
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
    header('Location: /new_openid.php');
  }
  else
  {
    Print "<p><b>" . $username . "</b> Welcome back!  here is the info we have on you</p>";
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
  }
?> 

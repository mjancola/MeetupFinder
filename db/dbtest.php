<?php 
  // Connects to your Database 
  mysql_connect("localhost", "root", "CSC9010") or die(mysql_error()); 
  mysql_select_db("meetupfinder") or die(mysql_error()); 
  $data = mysql_query("SELECT * FROM users") or die(mysql_error()); 
  Print "<table border cellpadding=3>"; 
  while($results = mysql_fetch_array( $data )) 
  { 
    Print "<tr>"; 
    Print "<th>Name:</th> <td>".$results['name'] . "</td> "; 
    Print "<th>Facebook Token:</th> <td>".$results['facebook_token'] . " </td>"; 
    Print "<th>Facebook Expires:</th> <td>".$results['facebook_expires'] . " </td>"; 

    Print "<th>LinkedIn Token:</th> <td>".$results['linkedin_token'] . " </td>"; 
    Print "<th>LinkedIn Expires:</th> <td>".$results['linkedin_expires'] . " </td>"; 
    
    Print "<th>Foursquare Token:</th> <td>".$results['foursquare_token'] . " </td>"; 
    Print "<th>Foursquare Expires:</th> <td>".$results['foursquare_expires'] . " </td></tr>"; 
  } 
  Print "</table>"; 
?> 

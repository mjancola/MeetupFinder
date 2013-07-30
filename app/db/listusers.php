<?php 
  // Connects to your Database 
  mysql_connect("localhost", "root", "") or die(mysql_error()); 
  mysql_select_db("meetupfinder_2") or die(mysql_error()); 
  $data = mysql_query("SELECT * FROM users") or die(mysql_error()); 
  Print "<form action='deleteuser.php' method='POST'>";
  Print "<table border cellpadding=3>"; 
  Print "<tr><td>$nbsp</td><td></b>Claimed_id</b></td><td></b>Name</b></td><td></b>Email</b></td><td></b>FB Token</b></td><td></b>FB Expires</b></td><td></b>LI Token</b></td><td></b>LI Expires</b></td><td></b>FS Token</b></td><td></b>FS Expires</b></td></tr>";
  while($results = mysql_fetch_array( $data )) 
  { 
      Print "<tr><td>
<a href='edituser.php?claimed_id=".$results['claimed_id']."&name=".$results['name']."&email=".$results['email']."&fbtoken=".$results['facebook_token']."&fbexpires=".$results['facebook_expires']."&litoken=".$results['linkedin_token']."&liexpires=".$results['linkedin_expires']."&fstoken=".$results['foursquare_token']."&fsexpires=".$results['foursquare_expires']."'>

Edit</a>

<a href='deleteuser.php?claimed_id=".$results['claimed_id']."'>
Delete</a>

</td><td>" .$results['claimed_id']. "</td><td>" .$results['name']. "</td><td>" .$results['email']. "</td><td>" .$results['facebook_token']. "</td><td>" .$results['facebook_expires']. "</td> <td>" .$results['linkedin_token']. "</td> <td>" .$results['linkedin_expires']. "</td> <td>" .$results['foursquare_token']. "</td> <td>" .$results['foursquare_expires']. "</td></tr> "; 
  }
  Print "</table>"; 
  Print "</form>";
?>  

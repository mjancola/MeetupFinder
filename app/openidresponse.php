<?php 
  session_start();

  $url=$_SERVER['QUERY_STRING'];

  $responseURL = urldecode($url);
  $decodeURL =explode("&", $responseURL );
  
  foreach($decodeURL as $key => $b)
  {
    $b = split('=', $b);
      if($b[0]=='openid.ext1.value.email')
      {
        //echo "{$b[1]}\n";
        $_SESSION['email'] = $b[1];
        $email = $b[1];
      }
      elseif($b[0]=='openid.ext1.value.country')
      {
        //echo "{$b[1]}\n";
        $_SESSION['country'] = $b[1];
        $country = $b[1];
      }
      elseif ($b[0]=='openid.ext1.value.firstname')
      {
        //echo "{$b[1]}\n";
        $_SESSION['name'] = $b[1];
        $name = $b[1];
      }
      elseif ($b[0]=='openid.claimed_id')
      {
        //echo "{$b[2]}\n";
        $_SESSION['claimed_id'] = $b[2];
        $claimed_id = $b[2];
      }
  } 

  // now check the DB for this user, by claimed_id
  mysql_connect("localhost", "root", "CSC9010") or die(mysql_error()); 
  mysql_select_db("meetupfinder_prod") or die(mysql_error()); 
  $data = mysql_query("SELECT * FROM users where claimed_id='" . $_SESSION['claimed_id'] . "'") or die(mysql_error());  
  $results = mysql_fetch_array( $data );
  $numrows = mysql_num_rows($data);
  Print "<p>found " . $numrows . " rows</p>";
  if ($numrows > 1)
  {
    Print "<p> Application Error - more than one row returned, call 1800HELPME!</p>";
  }
  elseif ($numrows < 1)
  {
    $_SESSION['newuser'] = "true";
    $query="INSERT into users(claimed_id, name, email) VALUES ('$claimed_id','$name','$email')";
    //Print "<p>$query</p>";
    mysql_query($query);
    //header('Location: /app/db/listusers.php');
    header('Location: /app/start.php');
    exit();
  }
  else
  {
    $_SESSION['newuser'] = "";
/*
    Print "<h1>Welcome back!  here is the info we have on you</h1>";
    Print "<table>";
      Print "<tr><td><b>Name</b></td><td>" .$results['name']. "</td></tr "; 
      Print "<tr><td><b>Email</b></td><td>" .$results['email']. "</td></tr "; 
      Print "<tr><td><b>Facebook Token</b></td><td>" .$results['facebook_token']. "</td></tr "; 
      Print "<tr><td><b>Facebook Expires</b></td><td>" .$results['facebooke_expires']. "</td></tr "; 
      Print "<tr><td><b>LinkedIn Token</b></td><td>" .$results['linkedin_token']. "</td></tr "; 
      Print "<tr><td><b>LinkedIn Expires</b></td><td>" .$results['linkedin_expires']. "</td></tr "; 
      Print "<tr><td><b>Foursquare Token</b></td><td>" .$results['foursquare_token']. "</td></tr "; 
      Print "<tr><td><b>Foursquare Expires</b></td><td>" .$results['foursquare_expires']. "</td></tr "; 
    Print "</table>"; 
*/
    // set the session parameters
    $_SESSION['fb_token'] = $results['facebook_token'];
    $_SESSION['fb_expires'] = $results['facebooke_expires'];
    $_SESSION['li_token'] = $results['linkedin_token'];
    $_SESSION['li_expires'] = $results['linkedin_expires'];
    $_SESSION['fs_token'] = $results['foursquare_token'];
    $_SESSION['fs_expires'] = $results['foursquare_expires'];
    header('Location: /app/start.php');
    exit();
  }

?>

<html>
<head>
<script>
function signout()
{
  document.location.href="https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://54.225.92.231/app/meetupfinder";
}
</script>
</head>
<body>

  <h3><b>Full Response:</b><?php echo $responseURL ?></h3>
  <h3><b>Name:</b><?php echo $_SESSION['name'] ?></h3>
  <h3><b>Country:</b><?php echo $_SESSION['country'] ?></h3>
  <h3><b>Email:</b><?php echo $_SESSION['email'] ?></h3>
  <h3><b>claimed_id:</b><?php echo $_SESSION['claimed_id'] ?></h3>
  <p>Click the button to signout from google account and takes to home page</p>

  <button onclick="signout()">Log Out</button>

  <p id="demo"></p>

</body>
</html>

<?php
  session_start();      
  require_once 'HTTP/Client.php';
  //require_once 'http_client.inc';
  define('SCOPE', 'r_basicprofile r_fullprofile r_network');
  
  $connectionsURL = 'https://api.linkedin.com/v1/people/~/connections:(firstName,location:(name))';
// print("<h2>$connectionsURL</h2>");
  
 $accessToken = $_SESSION['li_token'];
// print("<p>accessToken=$accessToken</p>\n"); 
  $redirectUriPath = 'meetup.hopto.org/app/get_linkedin_data.php';

  //Linkedin requires these
  $params = array(
    'oauth2_access_token' => $accessToken,
    'format' => 'json',
    'redirect_uri' => (isset($_SERVER['HTTPS'])?'https://':'http://') . $redirectUriPath,
    'scope' => SCOPE, );

  $httpClient = new Http_Client();
  $responseRaw = $httpClient->get($connectionsURL, $params);


  $all=$httpClient->currentResponse();
  $body=$all['body'];
//  print "$body";
  $resCode=$all['code'];
 // print("<p>ResponseCode=$resCode</p>");

  $responseArray = json_decode($body, TRUE);
  $connectionsList = $responseArray['values'];
//print_r($connectionsList); 
//added by bharath to split city 
// $placename = $_SESSION['location'];
  $location = $_SESSION['location'];
  $splitted = split(",", $location);
  $placename= $splitted[0];
  $countryfromUser = $splitted[1];
//print"$placename";
 
  print "<html><body bgcolor=#CCFF99>";
  print "<button style='background-color:#CD2222;color:white' onclick='home()'>Home</button>"; 
  print "&nbsp;";
  print "<button style='background-color:#CD2222;color:white' onclick='signout()'>Log Out</button>";
  print "<h2>List of your connections who stays in '$placename':</h2>"; 
  $count = 0;
  print ("<table>");
  //echo "<table><thead><tr><th>Connection Name</th><th>Present Location</th></tr$
  foreach ($connectionsList as $person) 
  {
    $name = $person['firstName'];       
    $hometown = $person['location']['name'];
    if(preg_match("/$placename/i", $hometown) && $placename != "")
    {
      //print "<h2>List of your connections who stays in $placename</h2>";
      print ("<tr><td>".$name."</td><td>".$hometown."</td></tr>");
      $count= $count+1;
    }       
  }
  print("</table>");
  //$redirectUriPath1 = '/app/start.php';
  //$goToUrl = (isset($_SERVER['HTTPS'])?'https://':'http://') .  $_SERVER['HTTP_HOST'] . $redirectUriPath1;
  if($count >= 1)
  {
    print "<h2>$count connections found associated with $placename</h2>";
    print "<h2>Would you like to meet them?</h2>";
  }
  else
  {
    print "<h2>No Connections found.  Search for venues anyway?</h2>";
  }
?>
  <input type="button" onClick="return window.location='<?php echo 'http://meetup.hopto.org/app/foursquarenew.php';?>';" value="Yes" /> 
  <input type="button" onClick="return window.location='<?php echo 'http://meetup.hopto.org/app/start.php';?>';" value="No" />
  </body></html>
      
<script>

function home()
{
  window.location="http://meetup.hopto.org/app/start.php";
}
function signout()
{
  window.location="https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://meetup.hopto.org/app/meetupfinder";
}
</script>




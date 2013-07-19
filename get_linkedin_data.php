<?php
  session_start();      
  require_once 'HTTP/Client.php';
  //require_once 'http_client.inc';
  define('SCOPE', 'r_basicprofile r_fullprofile r_network r_emailaddress rw_nus');
  
  $connectionsURL = 'https://api.linkedin.com/v1/people/~/connections:(firstName,location:(name))';
 // print("<h2>$connectionsURL</h2>");
  
  $accessToken = $_SESSION['access_token'];
 // print("<p>accessToken=$accessToken</p>\n"); 
  $redirectUriPath = '/get_linkedin_data.php';

  //Linkedin requires these
  $params = array(
    'oauth2_access_token' => $accessToken,
    'format' => 'json',
    'redirect_uri' => (isset($_SERVER['HTTPS'])?'https://':'http://') .
      $_SERVER['HTTP_HOST'] . $redirectUriPath,
      'scope' => SCOPE, );

  $httpClient = new Http_Client();
  $responseRaw = $httpClient->get($connectionsURL, $params);


  $all=$httpClient->currentResponse();
  $body=$all['body'];
  //print "$body";
  $resCode=$all['code'];
  //print("<p>ResponseCode=$resCode</p>");

 $responseArray = json_decode($body, TRUE);
 $connectionsList = $responseArray['values'];  
//added by bharath
 $location = $_SESSION['location'];
 $splitted = split(",", $location);
  $placename = $splitted[0];
  $countryfromUser = $splitted[1];
   
 $count = 0;
 
 print"<table>";
  //echo "<table><thead><tr><th>Connection Name</th><th>Present Location</th></tr></thead><tbody>"; 
  foreach ($connectionsList as $person) 
  {
    $name = $person['firstName'];       
    $hometown = $person['location']['name'];
    if(preg_match("/$placename/i", $hometown) && $placename != "")
    {
    print ("<tr><td>".$name."</td><td>".$hometown."</td></tr>");
    $count= $count+1;
    }       
  }
  print("</table>"); 
  
  
 
  if($count >= 1)
  {
  $goToUrl = 'http://54.225.92.231/foursquarenew.php';
  $goToUrl1 = 'http://54.225.92.231/app/start.php';
  print "<h2>$count of your connections stays in $placename, would you like to meet them?</h2>";
  //echo "<meta http-equiv=\"content=\"0;URL=http://54.225.92.231/somethingfound.php\">";
  }
  else
  {
  Print "You have no connections at $placename";
  header('Location: /nothingfound.php');
  }
  $goToUrl3 = 'http://54.225.92.231/app/start.php';  
?>

<input type="button" onClick="return window.location='<?php echo $goToUrl;?>';" value="Yes" /> 
<input type="button" onClick="return window.location='<?php echo $goToUrl1;?>';" value="No" />  
  
  
//<?php
//$goToUrl3 = 'http://54.225.92.231/app/start.php';
//if($count == 0)
//{
//Print "You have no connections at $placename";
//header('Location: /nothingfound.php');
//}
//?>




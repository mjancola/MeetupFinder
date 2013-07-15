<?php
  session_start();      
  require_once 'HTTP/Client.php';
  //require_once 'http_client.inc';
  define('SCOPE', 'r_basicprofile r_fullprofile r_network r_emailaddress rw_nus');
  
  $connectionsURL = 'https://api.linkedin.com/v1/people/~/connections:(firstName,location:(name))';
 // print("<h2>$connectionsURL</h2>");
  
  $accessToken = $_SESSION['access_token'];
 // print("<p>accessToken=$accessToken</p>\n"); 
  $redirectUriPath = '/app/get_linkedin_data.php';

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
 $placename = $_SESSION['location'];
   
 $count = 0;
 
  echo "<table><thead><tr><th>Connection Name</th><th>Present Location</th></tr></thead><tbody>"; 
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
  print("</tbody></table>"); 
 
  if($count >= 1)
  print "<h2>$count of your connections stays in $placename, would you like to meet them?</h2>";
  
  $goToUrl = 'http://54.225.92.231/app/foursquarenew.php';
  $goToUrl1 = 'http://54.225.92.231/app/start.php';
    
?>

  <input type="button" onClick="return window.location='<?php echo $goToUrl;?>';" value="Yes" /> 
  <input type="button" onClick="return window.location='<?php echo $goToUrl1;?>';" value="No" />
  
<?php

if($count == 0)
//header('Location: /app/nothingfound.php');

?>




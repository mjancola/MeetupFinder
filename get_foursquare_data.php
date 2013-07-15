<?php
  session_start();      
  require_once 'HTTP/Client.php';
  //require_once 'http_client.inc';
  //define('SCOPE', 'r_basicprofile r_fullprofile r_network r_emailaddress rw_nus');
  
  $connectionsURL = 'https://api.foursquare.com/v2/venues/search?v=20130319&near=19333&categoryId=4bf58dd8d48988d14e941735&limit=10&radius=16093.4';
 print("<h2>$connectionsURL</h2>");
  
  $accessToken = $_SESSION['access_token'];
 print("<p>accessToken=$accessToken</p>\n"); 
  $redirectUriPath = '/get_foursquare_data.php';

  //Linkedin requires these
  $params = array(
    'oauth_token' => $accessToken,
    'format' => 'json',
    'redirect_uri' => (isset($_SERVER['HTTPS'])?'https://':'http://') .
      $_SERVER['HTTP_HOST'] . $redirectUriPath,
      );

  $httpClient = new Http_Client();
  $responseRaw = $httpClient->get($connectionsURL, $params);


  $all=$httpClient->currentResponse();
  $body=$all['body'];
  //print "$body";
  $resCode=$all['code'];
  print("<p>ResponseCode=$resCode</p>");

 $responseArray = json_decode($body, TRUE);
 $connectionsList = $responseArray['response']; 
 print_r($connectionsList);
//$placename = $_POST["placename"]; 
 //print "$placename";
 //$count = 0;
                                
//$beforeCount = count($venueslist);
//print("Total no of connections = $beforeCount");
//print("Please enter the your friend's location");  
 print("<table>");
 foreach ($connectionsList as $venue) 
  {
    echo $id;
    $name = $venue['name'];       
    //$hometown = $person['location']['name'];
   // if(preg_match("/$placename/i", $hometown) && $placename!= "")
    //{
    print ("<tr><td>".$name."</td><td>");
   // $count= $count+1;
   // }       
  }
  print("</table>"); 
 
  //if($count >= 1)
  //print "<h2>$count of your connections stays in $placename, would you like to meet them?</h2>";   */
   
?>
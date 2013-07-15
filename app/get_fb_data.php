<?php
  session_start();
  //require_once 'http_client.inc';
  require_once 'HTTP/Client.php';

  // Facebook requires us to validate the tokens
  // the response will give us the userId, needed for other queries
//  $accessTokenInspectUrl = 'https://graph.facebook.com/debug_token';
  $friendsURL = 'https://graph.facebook.com/me/friends?fields=hometown,location,name';
 
  //print("<h2>$friendsURL</h2>"); 
  
  $accessToken = $_SESSION['access_token'];
  $expires = $_SESSION['expires'];
  // print("<p>expires=$expires</p>\n");  
  $redirectUriPath = '/app/get_fb_data.php';

  //Facebook requires these
  $params = array(
    'access_token' => $accessToken,
    'redirect_uri' => (isset($_SERVER['HTTPS'])?'https://':'http://') .
      $_SERVER['HTTP_HOST'] . $redirectUriPath);

  $httpClient = new Http_Client();
  $responseRaw = $httpClient->get($friendsURL, $params);


  $all=$httpClient->currentResponse();
  $body=$all['body'];
  $resCode=$all['code'];
  // print("<p>ResponseCode=$resCode</p>");

  $responseArray = json_decode($body, TRUE);
  $friendsList = $responseArray['data'];
  $beforeCount = count($friendsList);


  $name = $_SESSION['name'];
  $location = $_SESSION['location'];

  //print("<h2>name=$name</h2>");
  //print("<h2>location=$location</h2>");
  print("<h2><b>$name</b>, here are your connections from Facebook, residing in <b>$location</b></h2>");
  print("<table>");
  $count = count($friendsList);
  for($i=$count; $i > 0; $i--) {
  //foreach ($friendsList as $friend) {
    // do something with the friend, but you only have id and name
    $id = $friendsList[$i]['id'];
    $name = $friendsList[$i]['name'];
    $hometown = $friendsList[$i]['hometown']['name'];
    //if ($hometown != "") {
    if(stristr($hometown,$location) !== FALSE) {
      print ("<tr><td>".$name."</td><td>".$hometown."</td></tr>");
    }
    else {
      unset($friendsList[$i]);
    }
    
  }
  print("</table>");
  $afterSize=count($friendsList);
  //print("<p>AfterSize=$afterSize</p>");

  // not sure how to pull the current userid - not sure if we even need to
  $user_id = $responseArray['data']['user_id'];
  $_SESSION['user_id'] = $user_id;;
  //print("<p>Client=$user_id</p>");

  $redirectUriPath = '/linkedin.php';
  $goToUrl = (isset($_SERVER['HTTPS'])?'https://':'http://') .  $_SERVER['HTTP_HOST'] . $redirectUriPath;


  if($afterSize >= 1)
  {
    print "<h3>Total count=$afterSize</h3><h2> Would you like to find a place to meet them?</h2>";
    $goToUrl = 'http://54.225.92.231/app/foursquarenew.php';
  }  
?>
  <input type="button" onClick="return window.location='<?php echo $goToUrl;?>';" value="Yes" /> 
  <input type="button"  value="No" />

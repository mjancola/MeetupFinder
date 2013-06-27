<?php
  session_start();      
  require_once 'http_client.php';
  
  
  // Facebook requires us to validate the tokens
  // the response will give us the userId, needed for other queries
//  $accessTokenInspectUrl = 'https://graph.facebook.com/debug_token';
  $friendsURL = 'http://api.linkedin.com/v1/people/~/connections';
 
  print("<h2>$friendsURL</h2>");   
  
  $accessToken = $_SESSION['access_token'];
  print("<p>accessToken=$accessToken</p>\n");  
  $redirectUriPath = '/get_linkedin_data.php';

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
  print("<p>ResponseCode=$resCode</p>");

  $responseArray = json_decode($body, TRUE);
  $friendsList = $responseArray['data'];
  print("<table>");
  foreach ($friendsList as $friend) {
    // do something with the friend, but you only have id and name
    $id = $friend['id'];

    // do something with the friend, but you only have id and name
    $id = $friend['id'];
    $name = $friend['name'];       
    $hometown = $friend['hometown']['name'];
    print ("<tr><td>".$name."</td><td>".$hometown."</td></tr>");
  }
  print("</table>");

  // not sure how to pull the current userid - not sure if we even need to
  $user_id = $responseArray['data']['user_id'];
  $_SESSION['user_id'] = $user_id;;
  print("<p>Client=$user_id</p>");

  //header('Location: /show_fb_user.php');     
?> 
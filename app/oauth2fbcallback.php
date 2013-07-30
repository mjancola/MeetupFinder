<?php
  session_start(); 

  require_once 'HTTP/Client.php';
  
 // echo $_SERVER['QUERY_STRING'];
  $url=$_SERVER['QUERY_STRING'];
  $decodeURL = urldecode($url);
  $decodeURL =explode("&", $decodeURL );
  //var_dump($decodeURL );
   $isAccepted=true;
  echo $isAccepted."before";
  foreach($decodeURL as $key => $b)
  {
     $b = split('=', $b);
     if($b[0]=='error'&& $b[1]=='access_denied')
     {
        $isAccepted= FALSE;
      }    
 
  } 
   
  
 if(!$isAccepted)
  {
     echo $isAccepted."isaccepted value";
     header("Location: /app/gotLocation.php"); 
  }
  else
  {  
    $code = $_GET['code'];
    $state = $_GET['state'];


    error_log("got code=" + $code, 3, "~/error.log");
    error_log("got state=" + $state, 4);

    // Verify the 'state' value is the same random value we created when initiating the authorization request.
    if ((! is_numeric($state)) || ($state != $_SESSION['state']))
      throw new Exception('Error validating state. Possible CSRF.'
  );

  $accessTokenExchangeUrl = 'https://graph.facebook.com/oauth/access_token';
  $redirectUriPath = 'meetup.hopto.org/app/oauth2fbcallback.php';


  // Facebook requires the following parameters
  $accessTokenExchangeParams = array(
    'redirect_uri' => (isset($_SERVER['HTTPS'])?'https://':'http://') . $redirectUriPath,
    'client_id' => 'yyy', 
    'client_secret' => 'yyy',
    'code' => $code);

  $httpClient = new Http_Client();
  $responseRaw = $httpClient->get($accessTokenExchangeUrl, $accessTokenExchangeParams);
  $all=$httpClient->currentResponse();
  $body=$all['body'];
  $resCode=$all['code'];
  print("<h2>body=$body</h2>");
  print("<h2>resCode=$resCode</h2>");
  print("<h1>response=$responseRaw</h1>");
 // print("<h1>code=$code</h1>");

  // helper automatically parses into variables named like the query keys  
  parse_str($body);
  $_SESSION['fb_token'] = $access_token;
  //$_SESSION['fb_expires'] = $expires;
  $_SESSION['fb_expires'] = $expires + time();
  $claimed_id = $_SESSION['claimed_id'];

  // local variable so we don't have to deal with nested quotes in the mysql query 
  $fb_expires = $_SESSION['fb_expires'];
  
  Print "<p>accesToken=".$access_token."</p>";
  Print "<p>expires=".$expires."</p>";
  Print "<p>claimed_id=".$claimed_id."</p>";

  // save the values to the DB!
  mysql_connect("localhost", "root", "") or die(mysql_error()); 
  mysql_select_db("meetupfinder_2") or die(mysql_error()); 
  $query="UPDATE users SET facebook_token='".$access_token."', facebook_expires=".$fb_expires." where claimed_id ='".$claimed_id."'";
  Print "<p>QUERY=".$query."</p>";
  mysql_query($query);

  header('Location: /app/get_fb_data.php');
}
?> 

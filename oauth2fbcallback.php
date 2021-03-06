<?php
  session_start(); 
  require_once 'HTTP/Client.php';
  //include 'http_client.inc';
  $code = $_GET['code'];
  $state = $_GET['state'];


  error_log("got code=" + $code, 3, "~/error.log");
  error_log("got state=" + $state, 4);

  // Verify the 'state' value is the same random value we created when initiating the authorization request.
  if ((! is_numeric($state)) || ($state != $_SESSION['state']))
    throw new Exception('Error validating state. Possible CSRF.'
  );

  $accessTokenExchangeUrl = 'https://graph.facebook.com/oauth/access_token';
  $redirectUriPath = '/oauth2fbcallback.php';


  // Facebook requires the following parameters
  $accessTokenExchangeParams = array(
    'redirect_uri' => (isset($_SERVER['HTTPS'])?'https://':'http://') .
		$_SERVER['HTTP_HOST'] . $redirectUriPath,
    'client_id' => '146448285541021', 
    'client_secret' => 'ae2d8ff88efc0bd1d24eb2b2e320d4e6',
    'code' => $code);

  $httpClient = new Http_Client();
  $responseRaw = $httpClient->get($accessTokenExchangeUrl, $accessTokenExchangeParams);
  $all=$httpClient->currentResponse();
  $body=$all['body'];
  $resCode=$all['code'];
  print("<h2>body=$body</h2>");
  print("<h2>resCode=$resCode</h2>");
  print("<h1>response=$responseRaw</h1>");
  print("<h1>code=$code</h1>");

  // helper automatically parses into variables named like the query keys  
  parse_str($body);
  $_SESSION['access_token'] = $access_token;
  $_SESSION['expires'] = $expires;

  print("<h1>access=$accessToken</h1>");
  print("<h2>expires=$expires</h2>");
  error_log("accessToken=" + $accessToken, 0);
  header('Location: /get_fb_data.php');
?> 

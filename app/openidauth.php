<?php
  session_start();

  $authorizationUrlBase = 'https://www.google.com/accounts/o8/id';

// manual method
  require_once 'HTTP/Client.php';

  $httpClient = new Http_Client();
  $responseRaw = $httpClient->get($authorizationUrlBase);
  $all=$httpClient->currentResponse();
  $body=$all['body'];
  $resCode=$all['code'];
  //print("<h2>body=$body</h2>");
  //print("<h2>resCode=$resCode</h2>");

  $xml = simplexml_load_string($body); 
  print_r($xml);
  $login = $xml->XRD->Service->URI;
  // echo $login;
  $url6=$login.'?openid.ns=http://specs.openid.net/auth/2.0&openid.identity=http://specs.openid.net/auth/2.0/identifier_select&openid.claimed_id=http://specs.openid.net/auth/2.0/identifier_select&openid.mode=checkid_setup&openid.realm=http://54.225.92.231/app/openidresponse.php&openid.assoc_handle=ABSmpf6DNMw&openid.return_to=http://54.225.92.231/app/openidresponse.php&hl=en&from_login=1&as=-2d8c373003231ff2&pli=1&authuser=1&openid.ui.ns=http://specs.openid.net/extensions/ui/1.0&openid.ui.mode=popup&openid.ui.icon=true&openid.ns.ax=http://openid.net/srv/ax/1.0&openid.ax.mode=fetch_request&openid.ax.type.email=http://axschema.org/contact/email&openid.ax.type.language=http://axschema.org/pref/language&openid.ax.type.firstname=http://axschema.org/namePerson/first&openid.ax.type.country=http://axschema.org/contact/country/home&openid.ax.required=email,language,firstname,country';
  //$fp = fopen($url6, 'r', false);
  // $fileContents = stream_get_contents($fp);
  //echo $fileContents;
  // print($login); 
  header("Location:$url6");
?>

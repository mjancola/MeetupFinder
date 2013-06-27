<?php
  session_start();

  $authorizationUrlBase = 'https://www.google.com/accounts/o8/id';
// Using XrdsSimpleParser
//  require_once 'XrdsSimpleParser.php';
//  $rddXml = XrdsSimpleParser::fetchRdd($authorizationUrlBase);
 
  // look in the RDD for a Service URI with a given Type
//  $url = XrdsSimpleParser::getServiceByType($rddXml, 'http://specs.openid.net/auth/2.0/server');

//  print("<h2>found URI=$url</h2>");

// manual method
  require_once 'HTTP/Client.php';

  $httpClient = new Http_Client();
  $responseRaw = $httpClient->get($authorizationUrlBase);
  $all=$httpClient->currentResponse();
  $body=$all['body'];
  $resCode=$all['code'];
  print("<h2>body=$body</h2>");
  print("<h2>resCode=$resCode</h2>");
?>

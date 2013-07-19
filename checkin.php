<?php
session_start(); 
require_once 'HTTP/Client.php';
$authopts = array(
  'http'=>array(
    	'Content-Type'=>'application/x-www-form-urlencoded',
    'Accept'=>'text/html en\r\n' ,
    )                           
);

//echo $_SERVER['QUERY_STRING'];
$venue=$_GET["vote"];
//echo "hi".$venue;
$accessToken = $_SESSION['access_token'];
$addCheckinURL='https://api.foursquare.com/v2/checkins/add?oauth_token='.$accessToken.'&venueId='.$venue.'&v=20130713';
//echo $addCheckinURL;
$httpClient = new Http_Client();
$userresponseRaw = $httpClient->post($addCheckinURL, $params_checkin );
       

$addcheckinresp=$httpClient->currentResponse();
 $all=$httpClient->currentResponse();
  $body=$addcheckinresp['body'];
  print "$body";
 
 $resCode=$addcheckinresp['code'];
 print("<p>ResponseCode=$resCode</p>");
 $response="Checkin success";
//echo $response;
  $responseArray = json_decode($user_body, TRUE);
  print_r( $responseArray );
?>
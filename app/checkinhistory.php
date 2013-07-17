<?php
 session_start(); 
 $accessToken = $_SESSION['fs_token'];
require_once 'HTTP/Client.php';
 $userinfoURL='https://api.foursquare.com/v2/users/self/checkins?';  //To retrieve Checkin information from user profile
$params_checkin = array(
    'method'=>'GET',
    'oauth_token' => $accessToken,
    'format' => 'json',
    'v'=>'20130711'    
      );

  $httpClient = new Http_Client();
  $userresponseRaw = $httpClient->get($userinfoURL, $params_checkin );

  // var_dump($userresponseRaw);
  $all=$httpClient->currentResponse();
  $user_body=$all['body'];
  //print "$user_body";
  $resCode=$all['code'];
  //print("<p>ResponseCode=$resCode</p>");

   $responseArray = json_decode($user_body, TRUE);
 
 $userprofile = $responseArray['response']; 
 //echo "this is the connnectionlist";
  //print_r($userprofile );
    echo "Total Checkins <br>";
  print_r($userprofile ['checkins']['count']);
  
 foreach($userprofile as $key => $b)
{
   //echo $key."hello".$b;
   
   foreach($b as $checkkey => $value)
    {
    // echo $checkkey ."value".$value;

       foreach($value as $test => $tvalue)
        {
         
       	//echo $test ."insidechecks".$tvalue;            
                foreach($tvalue as $venue => $venuevalue)
                 {
	              if($venue == 'venue')
                      {
                            //echo $venue ."#venue#".$venuevalue;
			         foreach($venuevalue as $vkey => $details)
       	                  { 
                                     if($vkey=='name')
 					   echo "<BR>".$vkey."-->".$details."<BR>";
				    }
                       }			  
              
                 } 
  
        } 
   } 

 
}
 ?>
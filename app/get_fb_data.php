<?php
  session_start();
  //require_once 'http_client.inc';
  require_once 'HTTP/Client.php';

  // Facebook requires us to validate the tokens
  // the response will give us the userId, needed for other queries
//  $accessTokenInspectUrl = 'https://graph.facebook.com/debug_token';
  $friendsURL = 'https://graph.facebook.com/me/friends?fields=hometown,location,name';
 
  //print("<h2>$friendsURL</h2>"); 
  
  $accessToken = $_SESSION['fb_token'];
  $expires = $_SESSION['fb_expires'];
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
  // echo $body;
   
//To check if response has error -Might be the session token is invalid bcz application is deauthorized,session expired,or changed the password
  if(array_key_exists('code', $all))      
       { 
              // echo $all['code'];
               if($all['code']==400)//has an error in response
		 {  
                 
                  echo "hello";
                  $responseArray = json_decode($body, TRUE);
                  print_r($responseArray['error']['message']);
		   $authorizationUrlBase = 'https://www.facebook.com/dialog/oauth';
                 $redirectUri4auth = '/app/oauth2fbcallback.php';

   		  //Facebook requires client_id = app_id and a redirect uri
  		   $queryParams = array(
  					   'client_id' => '146448285541021',  // app_id from Facebook
    		 			 'redirect_uri' => (isset($_SERVER['HTTPS'])?'https://':'http://') .
 	        			 $_SERVER['HTTP_HOST'] . $redirectUri4auth ,
      					// optional params
   					   'state' => $_SESSION['state'],
  					    'response_type' => 'code',
     						 'scope' => 'friends_hometown'
                                      );

     	            $goToUrl = $authorizationUrlBase . '?' . http_build_query($queryParams);
      
                  //echo $goToUrl;
                  header("Location:$goToUrl ");
       
                 
 		  }
         }

  // print("<p>body=$body</p>");
  //print("<p>ResponseCode=$resCode</p>");

  $responseArray = json_decode($body, TRUE);
  $friendsList = $responseArray['data'];
  $beforeCount = count($friendsList);


  $name = $_SESSION['name'];
   //echo $name."this is name";
  $location = $_SESSION['location'];
  $splitted = split(",", $location);
  $cityfromUser = $splitted[0];
  $countryfromUser = $splitted[1];
   //print_r("$cityfromUser,$countryfromUser");

  print "<html><body bgcolor=#CCFFFF>";
  print "<button style='background-color:#CD2222;color:white' onclick='home()'>Home</button>";
  print "&nbsp;";
  print "<button style='background-color:#CD2222;color:white' onclick='signout()'>Log Out</button>";

  //print("<h2>name=$name</h2>");
  //print("<h2>location=$location</h2>");

  print("<h2><b>$name</b>, here are your connections from Facebook, residing in <b>$location</b></h2>");
  print("<table>");
  $numofFriends=0;
  $filteredFrnds = array();
  $totalfriends = count($friendsList);
  print(" <font size=\"5\"><i> Hi $name , you got total </font><font size=\"30\">$totalfriends </font> <font size=\"5\"> FB friends </font> </i>");
   //var_dump($friendsList);
  foreach ($friendsList as $friend) 
  {
    //var_dump($friend);

         if(array_key_exists('hometown', $friend))
             {
              //echo "friend info from response".$friend['hometown']['name']."<BR>";
               $b = split(',',$friend['hometown']['name']);
               
               //echo "{$b[0]} value {$b[1]}\n";

               if(strtolower($b[0])== strtolower($cityfromUser))
                {
               //echo $friend['name']."@".$friend['hometown']['name'];
               $filteredFrnds[$friend['name']] =$friend['hometown']['name'];
              // echo "<BR>";
               $numofFriends=$numofFriends+1;
                }
             }elseif(array_key_exists('location', $friend)){
               //echo "friend info from response".$friend['location']['name']."<BR>";
               $b = split(',',$friend['location']['name']);
               
               //echo "{$b[0]} value {$b[1]}\n";

               if(strtolower($b[0])== strtolower($cityfromUser))
                {
               //echo $friend['name']."@".$friend['location']['name'];
               $filteredFrnds[$friend['name']] =$friend['location']['name'];
              // echo "<BR>";
               $numofFriends=$numofFriends+1;
                }
                 
          }
     }
   //var_dump($filteredFrnds);
   print_r( "<font size=\"5\"> and </font> <font size=\"20\"> $numofFriends </font><font size=\"5\">(friends|friend) at $location  !!!!! <BR>*please see below* </font><BR><BR>");
   $i=1;
   foreach($filteredFrnds as $name=>$fromplace)
    { 
     print_r(" $i => $name  @  $fromplace");
     echo "<BR>";
     $i++;
     }

 print("</table>");
   
 $countoffilterdfrnds=  count($filteredFrnds );

  if($countoffilterdfrnds>= 1)
  {
    print "<h2> <BR> Would you like to find a place to meet them?</h2>";
    $url2Connect4square = 'http://54.225.92.231/app/foursquarenew.php';
?>
    <button  value "connectFS" onclick="connectFourSq()">Yes</button>
    <button value="back" onclick="return window.location='http://54.225.92.231/app/start.php';">No--GoBack</button>
<?php 
  }
  else
  {
    print "<h2>No Connections found.  Search for venues anyway?</h2>";
?>
    <button  value "connectFS" onclick="connectFourSq()">Yes</button>
    <button onclick="return window.location='http://54.225.92.231/app/start.php';">goBack</button> to enter different location
<?php
  }
  print "</body></html>";
?>
<script>
function home()
{
  window.location="http://54.225.92.231/app/start.php";
}
function signout()
{
  window.location="https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://54.225.92.231/app/meetupfinder";
}

function connectFourSq()
{
window.location="http://54.225.92.231/app/foursquarenew.php";
}
</script>

<?php
  session_start();      
  require_once 'HTTP/Client.php';
  //require_once 'http_client.inc';
  //define('SCOPE', 'r_basicprofile r_fullprofile r_network r_emailaddress rw_nus');
  
    //$connectionsURL = 'https://api.foursquare.com/v2/venues/search?v=20130319&near=Villanova,PA&categoryId=4bf58dd8d48988d14e941735&limit=10&radius=16093.4';
    $location=$_SESSION['location'];
    $connectionsURL = 'https://api.foursquare.com/v2/venues/search?v=20130319&near='.$location.'&categoryId=4bf58dd8d48988d14e941735&limit=10&radius=16093.4';
    echo $location;
     print("<h2>$connectionsURL</h2>");
 
   $accessToken =  $_SESSION['fs_token'];
 //print("<p>accessToken=$accessToken</p>\n"); 
  $redirectUriPath = '/get_foursquare_data.php';

  //Foursquare requires these
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
  //print("<p>ResponseCode=$resCode</p>");

 $responseArray = json_decode($body, TRUE);
 $connectionsList = $responseArray['response']; 
 //echo "this is the connnectionlist";
 $count = count($connectionsList);
 //echo $count;
// print_r($connectionsList['venues']);
 
 //print_r($connectionsList);

 //print("<table>");
echo "<h3>The top 10 restaurants around ".$location." with a radius of 10 miles are : </h3> "; //print("/n");
//echo " Name  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp    Address <BR>"; 
?>
<html>
<head>
<script>

function signout()
{
 
  window.location="https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://54.225.92.231/app/meetupfinder";
  
}
function checkin_here(name)
{
  // alert("Welcome " + name );
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById(name).innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","checkin.php?vote="+name,true);
xmlhttp.send();
}
</script>
<button style="position: absolute; top: 0; right: 0;background-color:#CD2222;color:white" onclick="signout()">Log Out</button>
</head>
<body>
<marquee behavior="alternate" style="background-color:green;color:white">Press the restaurant to checkin to your Foursquare account </marquee>
<form>
<table> 
<?php foreach ($connectionsList as $venue) 
  {
   //print_r($venue);
     foreach($venue as $narray)
	  { 
              $venueid = $narray['id'];
		// print_r($venueid );
             	echo "  &nbsp  ";
		$name = $narray['name'];
		// print_r($name);	echo "   --  ";
		$location =  $narray['location'];	
		//print_r($location['address']);
              $address = NULL;
             if(array_key_exists('address', $location))
             {
               $address=$address.$location['address'];
             }
             if(array_key_exists('city', $location))
             {
               $address=$address.",".$location['city'];
             }
		if(array_key_exists('state', $location))
             {
               $address=$address.",".$location['state'];
             }
		if(array_key_exists('cc', $location))
             {
               $address=$address.",".$location['cc'];
             }
              if(array_key_exists('postalCode', $location))
             {
               $address=$address.",".$location['postalCode'];
             }

		
             // $address=$location['address'].",".$location['city'].",".$location['state'].",".$location['cc'].",".$location['postalCode'];
		print("<br>");
		?>
		
		<tr><h><BR><button type="button" value="<?php echo $venueid ?>" onclick="checkin_here(this.value)" style="width: 250px" ><?php echo "<b>".$name."</b>"."\n@".$address;?></button></h>
        <h><span id="<?php echo $venueid ?>"></span></p></h></tr>
    </table>
    </form>
    </body>
 </html>
<?php }	
 

break;
  }
	  
  
  //bharath
 // echo "<BR><b><i><u> *** Hi Sashank I appended code to add checkin,retrieve the users checkin information and changed the url form pincode (very very small change ) --Bharath  results are below*** </u></i></b><BR><BR>";

//*********//
//********//
/* $userinfoURL='https://api.foursquare.com/v2/users/self/checkins?';  //To retrieve Checkin information from user profile
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
 */   
?>

<html>
<head>
<script>
function checkin_his()
{
  // alert("Welcome " + name );
//document.getElementById("results").reset();
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("results").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("POST","checkinhistory.php",true);
xmlhttp.send();
}
</script>
</head>
<body>


<form>
<table>
<tr><h><center>press <button type="button" style="background-color:#C0C0C0;color:white value=" " onclick="checkin_his()">CheckinHistory</button> to see the checkin history</center></h>
        <div id="results"></div></p></tr>

 </table>
    </form>
    </body>
 </html>

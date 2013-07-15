<?php
  session_start();      
  require_once 'HTTP/Client.php';
  //require_once 'http_client.inc';
  //define('SCOPE', 'r_basicprofile r_fullprofile r_network r_emailaddress rw_nus');
  
  //$connectionsURL = 'https://api.foursquare.com/v2/venues/search?v=20130319&near=19333&categoryId=4bf58dd8d48988d14e941735&limit=10&radius=16093.4';
    $connectionsURL = 'https://api.foursquare.com/v2/venues/search?v=20130319&near=Villanova,PA&categoryId=4bf58dd8d48988d14e941735&limit=10&radius=16093.4';

 print("<h2>$connectionsURL</h2>");
  
  $accessToken = $_SESSION['access_token'];
 print("<p>accessToken=$accessToken</p>\n"); 
  $redirectUriPath = '/get_foursquare_data.php';

  //Linkedin requires these
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
 print_r($connectionsList['venues']);
 
 //print_r($connectionsList);

 //print("<table>");
 echo "<h3>The top 10 restaurants arround ur location with a radius of 10 miles are : </h3> ";
 //print("/n");
echo "Venues ID &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  Name  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp    Address <BR>"; 
?>
<html>
<head>
<script>
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
    document.getElementById("status").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","checkin.php?vote="+name,true);
xmlhttp.send();
}
</script>
</head>
<body>


<form>
<table>

<?php foreach ($connectionsList as $venue) 
  {
   //print_r($venue);
     foreach($venue as $narray)
	  { 
              $venueid = $narray['id'];
		 //print_r($venueid );	echo "  &nbsp  ";
		$name = $narray['name'];
		// print_r($name);	echo "   --  ";
		$location =  $narray['location'];	
		//print_r($location['address']);
		print("<br>");
		?>
		
		<tr><h><button type="button" value="<?php echo $venueid ?>" onclick="checkin_here(this.value)"><?php echo $name ?></button></h>
        <h><span id="status"></span></p></h></tr>

<?php }	
 

break;
  }
	  
  //print("</table>"); 
 
  //if($count >= 1)
  //print "<h2>$count of your connections stays in $placename, would you like to meet them?</h2>";   */

  //bharath
  echo "<BR><b><i><u> *** Hi Sashank I appended code to add checkin,retrieve the users checkin information and changed the url form pincode (very very small change ) --Bharath  results are below*** </u></i></b><BR><BR>";

//*********//
//TO checkin manually by passing a venueID

$params_checkin= array(
  'http'=>array(
    	'Content-Type'=>'application/x-www-form-urlencoded',
    'Accept'=>'text/html en\r\n' ,
    )                           
);

//$addCheckinURL='https://api.foursquare.com/v2/checkins/add?oauth_token='.$accessToken.'&venueId=4b073aebf964a52031fa22e3&shout=bharathtest&v=20130713';
//echo $addCheckinURL;
//$httpClient = new Http_Client();
//$userresponseRaw = $httpClient->post($addCheckinURL, $params_checkin );
    //$addcheckinresp=$httpClient->currentResponse();
 //$user_body=$addcheckinresp['body'];
 // print "$user_body";
 $resCode=$addcheckinresp['code'];
 //print("<p>ResponseCode=$resCode</p>");

  //$responseArray = json_decode($user_body, TRUE);
  //print_r( $responseArray );

//********//
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
  print_r($userprofile );
    echo "Total Checkins <br>";
  print_r($userprofile ['checkins']['count']);
  
 foreach($userprofile as $key => $b)
{
   //echo $key."hello".$b;
   
   foreach($b as $checkkey => $value)
    {
     echo $checkkey ."value".$value;

       foreach($value as $test => $tvalue)
        {
         
       	echo $test ."insidechecks".$tvalue;            
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
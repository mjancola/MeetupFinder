<?php
  session_start();      
  require_once 'HTTP/Client.php';
  //require_once 'http_client.inc';
  //define('SCOPE', 'r_basicprofile r_fullprofile r_network r_emailaddress rw_nus');
  
  //$connectionsURL = 'https://api.foursquare.com/v2/venues/search?v=20130319&near=Villanova,PA&categoryId=4bf58dd8d48988d14e941735&limit=10&radius=16093.4';
  $location=$_SESSION['location'];  
  
  // replace spaces with % encodings!!!!
  $urlLocation = urlencode($location);

  print "<html><body bgcolor=#CCFF99>";
  print "<button style='background-color:#CD2222;color:white' onclick='home()'>Home</button>";
  print "&nbsp;";
  print "<button style='background-color:#CD2222;color:white' onclick='signout()'>Log Out</button>";
  //echo $location;
  //print("<h2>$connectionsURL</h2>");
 
  $connectionsURL = "https://api.foursquare.com/v2/venues/search?v=20130319&near='".$urlLocation."'&categoryId=4bf58dd8d48988d14e941735&limit=10&radius=16093.4";

  $accessToken =  $_SESSION['fs_token'];
  //print("<p>accessToken=$accessToken</p>\n"); 
  $redirectUriPath = 'meetup.hopto.org/app/get_foursquare_data.php';

  //Foursquare requires these
  $params = array(
    'oauth_token' => $accessToken,
    'format' => 'json',
    'redirect_uri' => (isset($_SERVER['HTTPS'])?'https://':'http://') . $redirectUriPath,
      );


  $httpClient = new Http_Client();
  $responseRaw = $httpClient->get($connectionsURL, $params);
  $all=$httpClient->currentResponse();
  $body=$all['body'];

  //print "$body";
  $resCode=$all['code'];
  //print("<p>ResponseCode=$resCode</p>");
if($resCode !=200)
{
     $errorResponseArray = json_decode($body, TRUE);
      $errorBody=$errorResponseArray ['meta'];
      //var_dump($errorBody);
      echo "<BR><BR><BR>ErrorCode:".$errorBody['code'];
      echo "<BR>ErrorType:".$errorBody['errorType'];
      echo "<BR>ErrorType:".$errorBody['errorDetail'];

     //print_r("Response:$errorResponseArray ");
     //print_r("<p>ResponseCode=$resCode</p>");

 }else
{

 $responseArray = json_decode($body, TRUE);
 $connectionsList = $responseArray['response']; 
 //echo "this is the connnectionlist";
 $count = count($connectionsList);
 //echo $count;
 //print_r($connectionsList['venues']);
 
 //print_r($connectionsList);

 //print("<table>");
echo "<h3>The top 10 American restaurants around ".$location." with a radius of 10 miles are : </h3> "; //print("/n");
//echo " Name  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp    Address <BR>"; 
?>
<html>
<head>
<script>
function home()
{
  window.location="http://meetup.hopto.org/app/start.php";
}
function signout()
{
  window.location="https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://meetup.hopto.org/app/meetupfinder.php";
}

function popitup(url) {
	newwindow=window.open(url,'name','height=800,width=800');
	if (window.focus) {newwindow.focus()}
	return false;
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
</head>
<body bgcolor=#CCFFFF>
<marquee behavior="alternate" style="background-color:green;color:white">Press the restaurant to checkin to your Foursquare account </marquee>
<form>
<table boder="1"> 
<?php 
  foreach ($connectionsList as $venue) 
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
              $restUrl;
              $menu;
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

           /* new Changes bharath */

            if(array_key_exists('canonicalUrl', $narray))
              {
              //print_r($narray['canonicalUrl']);
              $restUrl=$narray['canonicalUrl'];
              }
             if(array_key_exists('url', $narray))
		{
             // print_r($narray['url']);
              }  
             if(array_key_exists('menu', $narray))
		{
             if(isset($narray['menu']['mobileUrl']))
                  {
  			 //print_r($narray['menu']['mobileUrl']);
 			$menu=$narray['menu']['mobileUrl'];
                   }
               else{
                      //print_r($narray['menu']['url']);
                      $menu=$narray['menu']['url'];
                   }
              }
              if(array_key_exists('phone', $narray['contact']))
              {
              //print_r($narray['contact']['formattedPhone']);
              $address=$address.",".$narray['contact']['formattedPhone'];
              }


		
    // $address=$location['address'].",".$location['city'].",".$location['state'].",".$location['cc'].",".$location['postalCode'];
    //print("<p>&nbsp;</p>");
?>
		
		<tr><td><h><button type="button" value="<?php echo $venueid ?>" onclick="checkin_here(this.value)" style="width: 250px" ><?php echo "<b>".$name."</b>"."\n@".$address;?></button></h>
              <h><span id="<?php echo $venueid ?>"></span></p></h></td>
              <td><h><button style="background-color:#E0DDDD;color:#2398C9;width: 160px;font-size:15px" onclick="return popitup('<?php echo $restUrl;?>')" <?php echo "<b>".$name."</b>&nbsp"?>'s website</button></h></td>
              <td> <align="center"  border = "1" cellpadding="1" ><td  align="center" width="10"><style type="text/css">.a2 A:link {text-decoration: none} .a2 A:visited {text-decoration: none} .a2 A:active {text-decoration: none} .a2 A:hover {text-decoration: underline ; color: red;}</style><span class="a2"><a href="<?php echo $menu;?>" onclick="return popitup('<?php echo $menu;?>')">Menu</a></span><br></td>
             </tr>              
    
<?php }?>	
       </table>
    </form>
    </body>
 </html>
 
<?php
break;
  }
	  
} 
  //bharath
 
//*********//
//********//
  
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
<tr><h><center><BR>press <button type="button" style="background-color:#C0C0C0;color:white value=" " onclick="checkin_his()">CheckinHistory</button> to see the checkin history</center></h>
        <div id="results"></div></p></tr>

 </table>
    </form>
    </body>
 </html>

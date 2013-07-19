<?php
  session_start();      
  require_once 'HTTP/Client.php';
  //require_once 'http_client.inc';
  //define('SCOPE', 'r_basicprofile r_fullprofile r_network r_emailaddress rw_nus');
  //$location = $_SESSION['location'];
  //$connectionsURL = 'https://api.foursquare.com/v2/venues/search?v=20130319&near=19333&categoryId=4bf58dd8d48988d14e941735&limit=10&radius=16093.4';
    $connectionsURL = 'https://api.foursquare.com/v2/venues/search?v=20130319&near=Hyderabad,India&categoryId=4bf58dd8d48988d14e941735&limit=10&radius=16093.4';
    //$connectionsURL = 'https://api.foursquare.com/v2/venues/search?v=20130319&near='.$location.'&categoryId=4bf58dd8d48988d14e941735&limit=10&radius=16093.4';

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
  print("<p>ResponseCode=$resCode</p>");

 $responseArray = json_decode($body, TRUE);
 $connectionsList = $responseArray['response']; 
 //echo "this is the connnectionlist";
 $count = count($connectionsList);
 //echo $count;
// print_r($connectionsList['venues']);
 
 //print_r($connectionsList);

 //print("<table>");
 echo "<h3>The top 10 restaurants arround ur location with a radius of 10 miles are : </h3> ";
 //print("/n");
echo "Venues ID &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  Name  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp    Address <BR>"; 
?>
<html>
<head>
<script>

function popitup(url) {
	newwindow=window.open(url,'name','height=600,width=600');
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
<body>


<form>
<table>

<?php
 
 foreach ($connectionsList as $venue) 
  {
    // print_r($venue);
     foreach($venue as $narray)
	  {  
            // print_r($narray);
              $venueid = $narray['id'];
		 //print_r($venueid );	echo "  &nbsp  ";
		$name = $narray['name'];
		// print_r($name);	echo "   --  ";
		$location =  $narray['location'];	
		/*print_r($location['address']);
              print_r($location['city']);              
              print_r($location['state']);
		print_r($location['cc']);
              print_r($location['postalCode']);*/
              $restUrl;
              $restphone;
              $menu;
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
  			 print_r($narray['menu']['mobileUrl']);
 			$menu=$narray['menu']['mobileUrl'];
                   }
               else{
                      print_r($narray['menu']['url']);
                      $menu=$narray['menu']['url'];
                   }
              }
              if(array_key_exists('phone', $narray['contact']))
              {
              //print_r($narray['contact']['formattedPhone']);
              $restphone=$narray['contact']['formattedPhone'];
              }
            
             $address=$location['address'].",".$location['city'].",".$location['state'].",".$location['cc'].",".$location['postalCode'].",phno:".$restphone;
		print("<br>");
		?>
		
		<tr><h><button type="button"   value="<?php echo $venueid ?>" onclick="checkin_here(this.value)" style="width: 250px"><?php echo "<b>".$name."</b>"."@".$address;?></button></h>
			<!--<h><button type="button" value="" ><?php echo $address; ?></button></h>-->
 			<h><button style="background-color:#E0DDDD;color:#2398C9;width: 150px;font-size:15px" onclick="window.open('<?php echo $restUrl;?>');"> <?php echo "<b>".$name."</b>&nbsp"?>'s website</button></h>
                     <a href ='<?php echo $menu;?>'> see menu </a></h>
                      <align="center" cellpadding="10" border="1"><tr><td bgcolor="#FFFFFF" align="center" width="200"><style type="text/css">.a2 A:link {text-decoration: none} .a2 A:visited {text-decoration: none} .a2 A:active {text-decoration: none} .a2 A:hover {text-decoration: underline ; color: red;}</style><span class="a2"><a href="<?php echo $menu;?>" onclick="return popitup('<?php echo $menu;?>')">Menu</a></span></td></tr><br>
                <!--<h style="color:#2398C9;font-size:15px" ><a href ='<?php echo $restUrl;?>');'> <?php echo "<b>".$name."</b>&nbsp"?>'s website</a></h>-->
                <!--<h><a href="<?php echo $restUrl ?>"><?php echo $name;  ?></a> </h>-->
              <h><span id="<?php echo $venueid ?>"></span></p></h></tr>
</table>
</form>
</body>
</html>

   <?php break;}	
 
break;
  }
	  
  
  //bharath
 // echo "<BR><b><i><u> *** Hi Sashank I appended code to add checkin,retrieve the users checkin information and changed the url form pincode (very very small change ) --Bharath  results are below*** </u></i></b><BR><BR>";

//*********//
//TO checkin manually by passing a venueID

/*$params_checkin= array(
  'http'=>array(
    	'Content-Type'=>'application/x-www-form-urlencoded',
    'Accept'=>'text/html en\r\n' ,
    )                           
);*/

//$addCheckinURL='https://api.foursquare.com/v2/checkins/add?oauth_token='.$accessToken.'&venueId=4b073aebf964a52031fa22e3&shout=bharathtest&v=20130713';
//echo $addCheckinURL;
//$httpClient = new Http_Client();
//$userresponseRaw = $httpClient->post($addCheckinURL, $params_checkin );
//   $addcheckinresp=$httpClient->currentResponse();
// $user_body=$addcheckinresp['body'];
//  print "$user_body";
// $resCode=$addcheckinresp['code'];
// print("<p>ResponseCode=$resCode</p>");

  //$responseArray = json_decode($user_body, TRUE);
  //print_r( $responseArray );

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
<tr><h><button type="button" value=" " onclick="checkin_his()">Checkhistory</button></h>
        <div id="results"></div></p></tr>

 </table>
    </form>
    </body>
 </html>

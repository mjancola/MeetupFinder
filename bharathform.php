
<?php 
//echo $_SERVER['REQUEST_URI'];
$url=$_SERVER['QUERY_STRING'];
 // echo gettype($_SERVER['QUERY_STRING']);
  // echo gettype(parse_url($_SERVER['QUERY_STRING']));    
 //var_dump(parse_url($_SERVER['QUERY_STRING'])); 
//echo parse_url($_SERVER['QUERY_STRING'], PHP_URL_PATH);
//print_r(parse_url($url)); explode("&", $url);
$decodeURL = urldecode($url);
$decodeURL =explode("&", $decodeURL );
//var_dump($decodeURL );
foreach($decodeURL as $key => $b)
{
   $b = split('=', $b);
    if($b[0]=='openid.mode'&& $b[1]=='cancel')
           header("Location:http://54.225.92.231/openid/meetupfinder");
   if($b[0]=='openid.ext1.value.email')
  echo "{$b[1]}";
   if($b[0]=='openid.ext1.value.country')
  echo "{$b[1]}\n";
    if($b[0]=='openid.ext1.value.firstname')
  echo "{$b[1]}\n";
 
} 
//var_dump($pieces);
 ?>

<html>
<head>
<script>
function signout()
{
window.location="https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://54.225.92.231/openid/meetupfinder";
}
</script>
</head>
<body>

<p>Click the button to signout from google account and takes to home page</p>

<button onclick="signout()">Log Out</button>

<p id="demo"></p>

</body>
</html>


   




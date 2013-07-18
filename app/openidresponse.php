<?php 
  // clear the session
  session_unset();
  session_start();
  
  $url=$_SERVER['QUERY_STRING'];
  $responseURL = urldecode($url);
  $decodeURL =explode("&", $responseURL );
  $isOIDmode= true;
  foreach($decodeURL as $key => $b)
  {
    $b = split('=', $b);
     //echo "{$b[0]} value {$b[1]}\n";
      if($b[0]=='openid.mode'&& $b[1]=='cancel')
      {
          $isOIDmode=false;
          
      } 
      elseif($b[0]=='openid.ext1.value.email')
      {
        //echo "{$b[1]}\n";
        $_SESSION['email'] = $b[1];
        $email = $b[1];
      }
      elseif($b[0]=='openid.ext1.value.country')
      {
        //echo "{$b[1]}\n";
        $_SESSION['country'] = $b[1];
        $country = $b[1];
      }
      elseif ($b[0]=='openid.ext1.value.firstname')
      {
        //echo "{$b[1]}\n";
        $_SESSION['name'] = $b[1];
        $name = $b[1];
      }
      elseif ($b[0]=='openid.claimed_id')
      {
        //echo "{$b[2]}\n";
        $_SESSION['claimed_id'] = $b[2];
        $claimed_id = $b[2];
      }
  } 

  if($isOIDmode)
  {
    header('Location: /app/start.php');
    exit();
  }
  else
  {
     header("Location:http://54.225.92.231/app/meetupfinder");        
  }

?>

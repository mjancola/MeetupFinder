<?php
  // $request  = new HttpRequest(' https://www.google.com/accounts/o8/ud', HttpRequest::METH_GET);
  // $request->setHeaders(array('Accept' => 'application/xrds+xml'));     
   //try {
    //$request->send();
    //if ($request->getResponseCode() == 200) {
        //file_put_contents('D:\test.txt', $request->getResponseBody());
    //}
//} catch (HttpException $ex) {
  //  echo $ex;
//}
     $opts = array(
  'http'=>array(
    'method'=>'POST',
    'Accept'=>'text/html en\r\n' ,
    'openid.ns'=>'http://specs.openid.net/auth/2.0\r\n'      
  )                           
);
     $url ='https://www.google.com/accounts/o8/id';
    $url3='https://www.google.com/accounts/o8/ud?openid.ns=http://specs.openid.net/auth/2.0&openid.claimed_id=http://specs.openid.net/auth/2.0/identifier_select&openid.identity=http://specs.openid.net/auth/2.0/identifier_select&openid.return_to=http://54.225.92.231/meetupfinder&openid.realm=http://54.225.92.231/meetupfinder&openid.assoc_handle=ABSmpf6DNMw&openid.mode=checkid_setup';
	$url4='https://accounts.google.com/o/openid2/auth?openid.ns=http://specs.openid.net/auth/2.0&openid.identity=http://specs.openid.net/auth/2.0/identifier_select&openid.claimed_id=http://specs.openid.net/auth/2.0/identifier_select&openid.mode=checkid_setup&openid.realm=http://54.225.92.231/meetupfinder&openid.assoc_handle=ABSmpf6DNMw&openid.return_to=http://54.225.92.231/meetupfinder&hl=en&from_login=1&as=-2d8c373003231ff2&pli=1&authuser=1';
	
              // $context = stream_context_create($opts);
               $fp = fopen($url4, 'r', false);
                   $fileContents = stream_get_contents($fp);
                echo $fileContents;
				header("Location".$fileContents);
   
?>

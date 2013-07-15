<?php
// Change these
define('CLIENT_ID',      'PU3V513OEAG4GXUQPRHV4FFCLJ4JXHUOXUKBDD4MNLWXJV5E'                      );
define('CLIENT_SECRET',   'MLBSU00CK5AQWRPTGIY21130NRVXCZBWBY2GMP2LO5PEEWFT'                                       );
define('REDIRECT_URI', 'http://54.225.92.231/foursquare.php'                              );

 
// You'll probably use a database
session_name('Foursquare');
session_start();

// OAuth 2 Control Flow

if (isset($_GET['error'])) {
    // Foursquare returned an error
    print $_GET['error'] . ': ' . $_GET['error_description'];
    exit;
} elseif (isset($_GET['code'])) {
    // User authorized your application
    if ($_SESSION['state'] == $_GET['state']) {
        // Get token so you can make API calls
        getAccessToken();
    } else {
        // CSRF attack? Or did you mix up your states?
        exit;
    }
} else {
    if ((empty($_SESSION['expires_at'])) || (time() > $_SESSION['expires_at'])) {
        // Token has expired, clear the state
        $_SESSION = array();
    }
    if (empty($_SESSION['access_token'])) {
        // Start authorization process
        getAuthorizationCode();
    }
}
 
echo "Congratulations! You have a valid token. Now fetch your profile <br>";
$accessToken=$_SESSION['access_token'];
print"$accessToken";
//$user = fetch('GET', '/v2/venues/search?near=19333&query=taco);
//print "Hello $user->firstName $user->lastName.";
exit;
 
function getAuthorizationCode() {
    $params = array('response_type' => 'code',
                    'client_id' => CLIENT_ID,
                    'scope' => '',
					'state' => uniqid('', true), // unique long string
                    'redirect_uri' => REDIRECT_URI,
              );
 
    // Authentication request
    $url = 'https://foursquare.com/oauth2/authenticate?' . http_build_query($params);
     
    // Needed to identify request when it returns to us
    $_SESSION['state'] = $params['state'];
 
    // Redirect user to authenticate
    header("Location: $url");
    exit;
}
     
function getAccessToken() {
    $params = array('grant_type' => 'authorization_code',
                    'client_id' => CLIENT_ID,
                    'client_secret' => CLIENT_SECRET,
                    'code' => $_GET['code'],
                    'redirect_uri' => REDIRECT_URI,
              );
    
    // Access Token request
    $url = 'https://foursquare.com/oauth2/access_token?' . http_build_query($params);
     
    // Tell streams to make a POST request
   $context = stream_context_create(
                    array('http' =>
                        array('method' => 'POST',
					    )
                    )
                );

    // Retrieve access token information
    $response = file_get_contents($url, false, $context);

	// Native PHP object, please
    $token = json_decode($response);

	$_SESSION['access_token'] = $token->access_token; // guard this!
  $_SESSION['expires_in'] = $token->expires_in; // relative time (in seconds)
   $_SESSION['expires_at']   = time() + $_SESSION['expires_in']; // absolute time

    return true;
}
 
function fetch($method, $resource, $body = '') {

    $params = array('oauth2_access_token' => $_SESSION['access_token'],
                    'format' => 'json',
              );
    
    // Need to use HTTPS
    $url = 'https://api.foursquare.com' . $resource . '?' . http_build_query($params);
    // Tell streams to make a (GET, POST, PUT, or DELETE) request
    $context = stream_context_create(
                    array('http' =>
                        array('method' => $method,
                        )
                    )
                );
 
 
    // Hocus Pocus
    //$response = file_get_contents($url, false, $context);
 echo $response
    // Native PHP object, please
    //return json_decode($response);	
}
?>

<?php
if (!isset($_POST['submit'])) {
?>  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
   "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title></title>
  </head>
  <body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      Sign in with your OpenID: <br/>
      <input type="text" name="id" size="30" />
      <br />
      <input type="submit" name="submit" value="Log In" />
    </form>
  </body>
</html>
<?php
} else {
  // check for form input
  if (trim($_POST['id'] == '')) {
    die("ERROR: Please enter a valid OpenID.");    
  }
  
  // include files
  require_once "Auth/OpenID/Consumer.php";
  require_once "Auth/OpenID/FileStore.php";
  
  // start session (needed for YADIS)
  session_start();
  
  // create file storage area for OpenID data
  $store = new Auth_OpenID_FileStore('./oid_store');
  
  // create OpenID consumer
  $consumer = new Auth_OpenID_Consumer($store);
  
  // begin sign-in process
  // create an authentication request to the OpenID provider
  $auth = $consumer->begin($_POST['id']);
  if (!$auth) {
    die("ERROR: Please enter a valid OpenID.");
  }
  
  // redirect to OpenID provider for authentication
  $url = $auth->redirectURL('http://consumer.example.com/', 'http://consumer.example.com/oid_return.php');
  header('Location: ' . $url);
}
?>    

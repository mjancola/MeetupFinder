<?php
  // check for form input
  if (trim($_GET['claimed_id'] == '')) {
    die("ERROR: Please enter at least a valid claimed_id");    
  }
  
  // Connect
  mysql_connect("localhost", "root", "CSC9010") or die(mysql_error()); 
  mysql_select_db("meetupfinder_prod") or die(mysql_error()); 

  // delete the old
  $query = "delete from users where claimed_id='".$_GET['claimed_id']."'";
  mysql_query($query);
 
  // redirect to display the db
  $redirectUriPath = '/app/db/listusers.php';
  $url = (isset($_SERVER['HTTPS'])?'https://':'http://') . $_SERVER['HTTP_HOST'] . $redirectUriPath;
  header('Location: ' . $url);
?>    

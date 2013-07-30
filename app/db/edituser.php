<?php

// loading the page - with or without data
if (!isset($_POST['submit']))
{
?>  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
   "DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title></title>
  </head>
  <body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  
    <h1>Fill in the form to add or update to the user db table:</h1><br/>
      <!-- original claim id, in case they change it -->
      <input type="hidden" name="old_claimed_id" value="<?php echo $_GET['claimed_id']; ?>"/>

    <table>
    <tr><td>Claimed_id</td><td>Name</td><td>Email</td><td>Facebook Token</td><td>FB Expires</td><td>LinkedIn Token</td><td>LI Expires</td><td>Foursquare Token</td><td>FS Expires</td></tr>
      <tr> 
      <td><input type="text" name="claimed_id" size="30" value="<?php echo $_GET['claimed_id']; ?>"/></td>
      <td><input type="text" name="name" size="30" value="<?php echo $_GET['name']; ?>"/></td>
      <td><input type="text" name="email" size="30" value="<?php echo $_GET['email']; ?>"/></td>
      <td><input type="text" name="fbtoken" size="30" value="<?php echo $_GET['fbtoken']; ?>"/></td>
      <td><input type="number" name="fbexpires" size="30" value="<?php echo $_GET['fbexpires']; ?>"/></td>
      <td><input type="text" name="litoken" size="30" value="<?php echo $_GET['litoken']; ?>"/></td>
      <td><input type="number" name="liexpires" size="30" value="<?php echo $_GET['liexpires']; ?>"/></td>
      <td><input type="text" name="fstoken" size="30" value="<?php echo $_GET['fstoken']; ?>"/></td>
      <td><input type="number" name="fsexpires" size="30" value="<?php echo $_GET['fsexpires']; ?>"/></td>
      </tr>
    </table>

      <input type="submit" name="submit" value="Add/Update" />
    </form>
  </body>
</html>
<?php
}
else // ADDING NEW or UPDATING - this is a SUBMIT
{
  // check for form input
  if (trim($_POST['claimed_id'] == '')) {
    die("ERROR: Please enter at least a valid claimed_id");    
  }
  
  $claimed_id = $_POST['claimed_id'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $fbtoken=$_POST['fbtoken'];
  $fbexpires=$_POST['fbexpires'];
  $litoken=$_POST['litoken'];
  $liexpires=$_POST['liexpires'];
  $fstoken=$_POST['fstoken'];
  $fsexpires=$_POST['fsexpires'];

  // Print "NAME:".$name." FBTOKEN:". $fbtoken." FBEXP:".$fbexpires." LITOKEN:".$litoken." LIEXP:".$liexpires." FSTOKEN:".$fstoken." FSEXP".$fsexpires;
  // Connect
  mysql_connect("localhost", "root", "") or die(mysql_error()); 
  mysql_select_db("meetupfinder_2") or die(mysql_error()); 

  // Is this an update?
  if (isset($_POST['old_claimed_id']))
  {
    // delete the old
    $query = "delete from users where claimed_id='".$_POST['old_claimed_id']."'";
    mysql_query($query);
  }
    
  $query="INSERT INTO users VALUES ('$name', '$email', '$claimed_id', '$fbtoken', '$fbexpires', '$litoken', '$liexpires', '$fstoken', '$fsexpires')";
  //print ("query=".$query);
  mysql_query($query);
  // Print "Added!"; 
 
  // redirect to display the db
  $redirectUriPath = '/app/db/listusers.php';
  $url = (isset($_SERVER['HTTPS'])?'https://':'http://') . $_SERVER['HTTP_HOST'] . $redirectUriPath;
  header('Location: ' . $url);
}
?>    

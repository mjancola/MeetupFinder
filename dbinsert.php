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
      Fill in the form to add to the user db table: <br/>
      <input type="text" name="name" size="30" value="string"/>
      <input type="text" name="fbtoken" size="30" value="string"/>
      <input type="number" name="fbexpires" size="30" value="integer"/>
      <input type="text" name="litoken" size="30" />
      <input type="number" name="liexpires" size="30" />
      <input type="text" name="fstoken" size="30" />
      <input type="number" name="fsexpires" size="30" />
      <br />
      <input type="submit" name="submit" value="Log In" />
    </form>
  </body>
</html>
<?php
} else {
  // check for form input
  if (trim($_POST['name'] == '')) {
    die("ERROR: Please enter at least a valid name.");    
  }
  
  $name = $_POST['name'];
  $fbtoken=$_POST['fbtoken'];
  $fbexpires=$_POST['fbexpires'];
  $litoken=$_POST['litoken'];
  $liexpires=$_POST['liexpires'];
  $fstoken=$_POST['fstoken'];
  $fsexpires=$_POST['fsexpires'];
  mysql_connect("localhost", "root", "CSC9010") or die(mysql_error()); mysql_select_db("meetupfinder") or die(mysql_error()); 
  //mysql_query("INSERT INTO users VALUES ($name,$_POST\['fbtoken'\],$POST\['fbexpires'\],$_POST\['litoken'\],$POST\['liexpires'\],$_POST\['fstoken'\],$POST\['fsexpires'\])"); 
  mysql_query("INSERT INTO users VALUES ($name,$fbtoken, $fbexpires, $litoken, $liexpires, $fstoken, $fsexpires))");
  Print "Added!"; 
 
  // redirect to display the db
  $redirectUriPath = '/dbtest.php';
  $url = (isset($_SERVER['HTTPS'])?'https://':'http://') . $_SERVER['HTTP_HOST'] . $redirectUriPath;
  header('Location: ' . $url);
}
?>    



<html>
<body>

<form action="Open_login.php" method="post">

<h1> Welcome to Meet up Finder</h1>
<b><?php echo $_POST["fname"]; ?> </b>
You are Looking for friends in: <b><?php echo $_POST["location"]; ?></b><br>
<p>Press a button to login using your account with of our affiliates</p>
<input type="submit" value="Google"/>
</form>
</body>
</html>

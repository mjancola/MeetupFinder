

<html>
<body>

<form action="openidauth.php" method="post">

<h2>Welcome to the Meetup Finder</h2>
<h1> Welcome to Meet up Finder</h1> <?php echo $_POST["fname"]; ?>
You are Looking for friends in <?php echo $_POST["location"]; ?> location. <br>
<p>Press a button to login using your account with of our affiliates</p>
<input type="button" onClick="return window.location='<?php echo $gotoUrl;?>';" value="Google" />
<input type="submit">
</form>

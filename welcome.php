<html>
<body>

<form action="fb2.php" method="post">

<h1> Welcome to Meet up Finder</h1> <?php echo $_POST["fname"]; ?>
You are Looking for friends in <?php echo $_POST["location"]; ?> location. <br>

<h1>We would like to access your facebook profile please click on submit to let us access your facebook friends</h1>

<input type="submit">
</form>




</body>
</html> 
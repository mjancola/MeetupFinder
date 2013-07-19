<html>
<body>
<style>
body 
{
  background: url(wix.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
p
{
text-align:center;
}

</style>
<form>
<br>
<br>
<br>
<br>
<br>
<br>
<center><h2>        Please let us access your Facebook friends</h2></center>
<p style="font-family:arial;color:white;font-size:30px;">
<b>To collate the data we need to access your friends and their hometown information.</b> 
<!-- <p>name=<?php // echo $_SESSION['name'];?></p> -->
<!-- <p>location=<?php // echo $_SESSION['location'];?></p> -->
</p>
<center><input type="button" onClick="return window.location='<?php echo $goToUrl;?>';" value="Let's Go" /></center>
</form>
</body>
</html> 


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


<br>
<br>
<br>
<br>
<br>
<br>
<br>
<form action="gotLocation.php" method="post" name="loc" onsubmit="return validateForm()">
<center><h1> Enter a location where you would like to meetup with your friends:</h1></center>
<center><h2>Location (ex:philadelphia, pa) <input type="text" name="location"><input type="submit" value="Let's Go!"> </h2></center>
</form>

<script type="text/javascript">
function validateForm()
{
var input =document.forms["loc"]["location"].value;
var valid = input.split(",");
if (input==null || input=="")
  {
  alert("Please enter location");
  return false;
  }
}
</script>


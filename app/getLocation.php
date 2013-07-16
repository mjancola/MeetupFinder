<form action="gotLocation.php" method="post" name="loc" onsubmit="return validateForm()">

<br /><h3> Enter a location where you would like to meetup with your friends:</h3>
<input type="text" name="location">
<input type="submit" value="Let's Go!"> 
</form>

<script type="text/javascript">
function validateForm()
{
var x=document.forms["loc"]["location"].value;
if (x==null || x=="")
  {
  alert("Location must be filled in");
  return false;
  }
}
</script>

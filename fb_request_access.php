<form>
<h2>Please let us access your Facebook friends</h2>
<p>To collate the data we need to access your friends and their hometown information.</p> 
<p>name=<?php echo $_SESSION['name'];?></p>
<p>location=<?php echo $_SESSION['location'];?></p> 

<input type="button" onClick="return window.location='<?php echo $goToUrl;?>';" value="Let's Go" />
</form>

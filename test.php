 <?php
echo "hello";
if(isset($_POST)){
echo "insidepost\n";
var_dump($POST);
echo $_GET['firstname'];
echo $_GET['openid.ext1.value.email'];}
echo "kafteroutput";
?>

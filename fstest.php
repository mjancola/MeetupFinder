<?php 
echo "hello";
foreach($result as $res)
{
echo "<form action=\"test.php\" name=\"".$res->name."\">";
 ?>
  <div>
  <label><?php echo $res->name;?></label>
  <input type="text" name="<php echo $res->val;?>">
  <input type="submit" value="submit"
  </div>
<?php
echo "</form>";
 }
?>
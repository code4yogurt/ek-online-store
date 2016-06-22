<html>
<title>EK Store</title>
<body>
<div style='width:100%'>
  <div style='background-color:#b5dcb3; width:100%'>
      <h1><a href='http://www.enchantedkingdom.ph'>Enchanted Kingdom</a></h1>
  </div>
 <div style='width:100%'>
  <div style='background-color:#b5dcb3; width:100%' align='center'>
      <a href='index.php'>| EK Store | </a>
      <a href='apparel.php'>APPAREL | </a>
      <a href='accessories.php'>ACCESSORIES | </a>
      <a href='drinkware.php'>DRINK WARE | </a>
      <a href='toys.php'>TOYS | </a>
  </div>
<div style="background-color:#aaa;height:500px;width:150px;float:left;">


  </div>

<?php

session_start();
require_once('../mysql_connect.php');


if (isset($_SESSION['type'])) {
        echo"<a href='myaccount.php'>My Account | </a>";
	echo"<a href='cart.php'>Cart | </a>";
	echo"<a href='logout.php'>Log out | </a>";
}
else{
	echo"<a href='creation.php'>Create Account</a>
	<a href='login.php'>Log In</a>";
}


$query="select * from products where status=1";
$result=mysqli_query($dbc,$query);

echo "<table border='1'>";


$counter=0;
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

$counter=$counter+1;

if($counter==1){
echo "<tr>";
}

echo"<td width=\"10%\"><div align=\"center\">
<img src='{$row['image']}' height='100' width='100'/>
";
?>
<form action="specificitem.php" method="GET">
<?php
echo"<input type='submit' name='submit' value='{$row['prod_name']}' />
</form>
{$row['prod_price']}
</div></td>";

if($counter==4){
echo"</tr>";
}

if($counter==4){
$counter=0;
}

}
echo '</table>';



?>
<?php
if(isset($_GET['submit'])){
 header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/specificitem.php");

}
?>

</body>
</html>
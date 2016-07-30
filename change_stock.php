<?php
session_start();
require_once('../mysql_connect.php');
?>
<b>LIST OF ACTIVE PRODUCTS:</b><br><br>
<!-- ERROR HANDLING-->
<?php
if(isset($_POST['product_change'])){

	if(empty($_POST['product'])){
		echo "<font color='red'>You forgot to choose a product!</font>";
	}
	else{
		$_SESSION['product']=$_POST['product'];
		header("Location: http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/change_stock2.php");
	}


}
?>
<!--GETTING NUMBER OF PAGES AND SETTING OF START OF ITEMS PER PAGE-->
<?php

$query="SELECT count(prod_code) as prod_count FROM products";
$result=mysqli_query($dbc,$query);
$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
$pages=$row['prod_count'] / 10;
$page_no=ceil($pages);

$start=0;
if(isset($_GET['go'])){
	$pn=$_GET['dropdown'];

$start=($_GET['dropdown']-1)*10;
}
else{
$pn=1;
}
echo "<br>Page: {$pn}	";


echo"
<table width='75%' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
<tr>
<td>
PRODUCTS
</td>
<td>
QUANTITY
</td>
</tr>
";


$query="select prod_code, prod_name from products where status=1 LIMIT $start,10";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
echo"
<tr>
<td>
<form action='{$_SERVER['PHP_SELF']}' method='POST'>
<input type='radio' name='product' value='{$row['prod_name']}'> {$row['prod_name']}
</td>
<td>
";


$query2="SELECT SUM(quantity) from inventory where prod_code ={$row['prod_code']} and change_type = 'in'";
$result2=mysqli_query($dbc,$query2);
$row2=mysqli_fetch_array($result2,MYSQLI_ASSOC);
$n1=$row2['SUM(quantity)'];

$query3="SELECT SUM(quantity) from inventory where prod_code ={$row['prod_code']} and change_type = 'out'";
$result3=mysqli_query($dbc,$query3);
$row3=mysqli_fetch_array($result3,MYSQLI_ASSOC);
$n2=$row3['SUM(quantity)'];

$quantity=$n1-$n2;

echo $quantity;

echo"
</td>
</tr>
";
}
echo"
</table>
<input type='submit' name='product_change' value='Proceed' />
</form>
";

echo"
<form action='{$_SERVER['PHP_SELF']}' method='GET'>
Page: <select name='dropdown'>
";
for($i=$page_no;$i>0;$i--){
	echo"
		<option value='{$i}' selected>{$i} </option>
	";
}
echo"
</select>
<input type='submit' name='go' value='Go' />
</form>
";
?>


<?php

session_start();
require_once('../mysql_connect.php');
$user=$_SESSION['type'];
if($user!='aac'){
  header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
}
$datetime= date("Y-m-d H:i:s");

$query="SELECT count(prod_code) as prod_count FROM products where status=1";
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


echo"
<p align='center'><b>TOTAL INVENTORY CHANGE HISTORY REPORT</p></b>
<p align='left'>$datetime</p>
<table width='75%' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
<tr>
<td>
PRODUCTS
</td>
<td>
STOCK
</td>
<td>

</td>
</tr>
";

$query="select prod_code, prod_name from products where status=1 LIMIT $start,10";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
echo"
<tr>
<td>
{$row['prod_name']}
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

echo"<p align='right'>{$quantity}</p>";

echo"
</td>
<td>
<form action='inventory_item_change.php' method='POST'>
			<button type='submit' name='item' value='{$row['prod_code']}'>View Changes</button>
			</form>
</td>
</tr>
";
}
echo"</table>";
if(isset($_GET['dropdown'])){
if($_GET['dropdown']==$page_no){
echo "<p align='center'><b>----END OF REPORT----</p></b>";
}
}
else{
	if($page_no==1){
		echo "<p align='center'><b>----END OF REPORT----</p></b>";
	}
}

echo "<p align='right'>Page: {$pn}	</p>";
echo"
<form action='{$_SERVER['PHP_SELF']}' method='GET'>
<p align='right'>Page: <select name='dropdown'></p>
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

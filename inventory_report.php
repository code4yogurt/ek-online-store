<?php

session_start();
require_once('../mysql_connect.php');

echo"
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

$query="select prod_code, prod_name from products where status=1";
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

echo $quantity;

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





?>

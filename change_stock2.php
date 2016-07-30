<?php
session_start();
require_once('../mysql_connect.php');

echo $_SESSION['product'];
?>
<!-- GET VARIABLES STAGE-->
<?php

$query="SELECT prod_code FROM products WHERE prod_name='{$_SESSION['product']}'";
$result=mysqli_query($dbc,$query);
$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
$item_code=$row['prod_code'];
$query="SELECT account_id FROM accounts WHERE username='{$_SESSION['username']}'";
$result=mysqli_query($dbc,$query);
$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
$admin_id=$row['account_id'];
$datetime= date("Y-m-d H:i:s");

?>
<!-- GETTING OF STOCK OF THE PRODUCT CHOSEN TO AVOID THE STOCK BEING NEGATIVE-->

<!-- ADDING AND REDUCING OF INVENTORY PROCESS -->
<?php

if(isset($_POST['change'])){

	$query="SELECT SUM(quantity) from inventory where prod_code =$item_code and change_type = 'in'";
	$result=mysqli_query($dbc,$query);
	$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
	$n1=$row['SUM(quantity)'];

	$query2="SELECT SUM(quantity) from inventory where prod_code =$item_code and change_type = 'out'";
	$result2=mysqli_query($dbc,$query2);
	$row2=mysqli_fetch_array($result2,MYSQLI_ASSOC);
	$n2=$row2['SUM(quantity)'];

	$quantity=$n1-$n2;

if ((!is_numeric($_POST['quantity']))||($_POST['quantity']<1))
{
    echo "<br><font color = 'red'>Error: Quantity must be a positive number</font>";
}
else
{
	if($_POST['dropdown']=='1')
	{
		$query="insert into inventory (change_type, quantity, event_date,prod_code,remarks,account_id) values ('in','{$_POST['quantity']}','{$datetime}','{$item_code}','Admin added stock','{$admin_id}')";
		$result=mysqli_query($dbc,$query);
		echo"<br><font color = 'red'>Successfully added {$_POST['quantity']} stock/s of {$_SESSION['product']}</font>";
	}
	else if($_POST['dropdown']=='2'  )
	{
		if($_POST['quantity']>$quantity){
			echo"<br><font color='red'>Deducting this much will result to a negative stock amount</font>";
		}
		else{
			$query="insert into inventory (change_type, quantity, event_date,prod_code,remarks,account_id) values ('out','{$_POST['quantity']}','{$datetime}','{$item_code}','Admin reduced stock','{$admin_id}')";
			$result=mysqli_query($dbc,$query);
			echo"<br><font color = 'red'>Successfully deducted {$_POST['quantity']} stock/s of {$_SESSION['product']}</font>";	
		}
		
	}
}
}

echo"
<form action='{$_SERVER['PHP_SELF']}' method='POST'>
<select name='dropdown'>
<option value='1' selected>Add Stock</option>
<option value='2'>Deduct Stock</option>
</select>
Quantity: <input type='text' name='quantity' />
<input type='submit' name='change' value='Change Stock' />
</form>
";


?>
<a href='admin.php'>Go Back to Dashboard</a>
<?php
session_start();
require_once('../mysql_connect.php');

if(isset($_POST['product_change'])){

	if(empty($_POST['product'])){
		echo 'You forgot to choose a product!';
	}
	else{
		$_SESSION['product']=$_POST['product'];
		header("Location: http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/change_stock2.php");
	}


}


$query="select prod_name from products LIMIT 0,10";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
echo"
<table border='1'>
<tr>
<td>
<form action='{$_SERVER['PHP_SELF']}' method='POST'>
<input type='radio' name='product' value='{$row['prod_name']}'> {$row['prod_name']}
</td></tr>
</table>
";
}
echo"
<input type='submit' name='product_change' value='Next' />
</form>
";

echo"
<form action='{$_SERVER['PHP_SELF']}' method='GET'>

<input type='submit' name='page' value='Next Page' />
</form>
";
?>
<a href='change_stock.php?=2'>Next Page</a>

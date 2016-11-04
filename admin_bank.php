<?php

session_start();
require_once('../mysql_connect.php');

$user=$_SESSION['type'];
if($user!='aac'){
  header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
}

//START OF VIEWING PENDING ORDERS


echo"
<p align='center'><b>LIST OF PENDING ORDERS</p></b>

<table width='75%' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
<tr>
<td>
ORDER #
</td>
<td>
PAYMENT CODE
</td>
<td>
PAYMENT AMOUNT
</td>
<td>
</td>
</tr>
";

$query="select   distinct(c.cart_id),p.payment_code,p.payment_amt,c.payment_id FROM cart c join pending_payment p on c.payment_id = p.payment_id where c.cart_status=0 AND p.payment_status = 0";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
echo"<tr>
<td>
{$row['cart_id']}
</td>
<td>
{$row['payment_code']}
</td>
<td>
{$row['payment_amt']}
</td>
<td>
				<form action='add_bank_2.php' method='POST'>
					<button type='submit' name='approve' value='{$row['payment_id']}'>APPROVE</button>
					</form>
			</td>
</tr>
";
}
?>
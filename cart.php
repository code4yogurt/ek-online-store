      <a href='index.php'>| EK Store | </a>
      <a href='apparel.php'>APPAREL | </a>
      <a href='accessories.php'>ACCESSORIES | </a>
      <a href='drinkware.php'>DRINK WARE | </a>
      <a href='toys.php'>TOYS | </a>


<?php
session_start();
require_once('../mysql_connect.php');
$username=$_SESSION['username'];
if (isset($_SESSION['type'])) {
        
	
        echo"<a href='myaccount.php'>My Account | </a>";
	echo"<a href='cart.php'>Cart | </a>";
	echo"<a href='logout.php'>Log out | </a>";
}
else{
	header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");

}
$query="select account_id from accounts where username='{$_SESSION['username']}'";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$user_id= $row['account_id'];
}
echo '<table width="75%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
<tr>
<td width="10%"><div align="center"><b>PRODUCT NAME
</div></b></td>
<td width="50%"><div align="center"><b>QUANTITY
</div></b></td>
<td width="50%"><div align="center"><b>SUBTOTAL 
</div></b></td>

</tr>';
$total=0;
$query="SELECT p.prod_name,sum(I.quantity),SUM(P.prod_price) FROM inventory I JOIN products P on I.prod_id=P.prod_id WHERE I.event_id in (select event_id from cart where account_id ='{$user_id}' AND cart_status=1)  group by I.prod_id,I.quantity";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
echo'<tr>';
echo '<td>';
echo $row['prod_name'];
echo '</td><td>';
echo $row['sum(I.quantity)'];
echo '</td><td>';
echo $row['SUM(P.prod_price)'];
$price=$row['SUM(P.prod_price)'];
$total=$total+$price;
echo '</td><td>';
echo"<form action='remove_cart.php' method='POST'>
<button type='submit' name='remove' value='{$row['prod_name']}'>Remove</button>
</form>";
echo '</td>';
}
if(isset($_POST['remove'])){
 header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/remove_cart.php");

}
echo"<br><br>
<form action='checkout.php' method='POST'>
<button type='submit' name='checkout' value='Checkout' align='right'>Checkout</button>
</form>";
echo 'Total: ';
echo $total;
?>




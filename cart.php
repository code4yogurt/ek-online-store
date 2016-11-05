
<?php
session_start();
require_once('../mysql_connect.php');
require_once('navbar.php');
?>
<div id="all">

        <div id="content">
            <div class="container">

<?php
$username=$_SESSION['username'];
if (isset($_SESSION['type'])) {
        
	
        
}
else{
	header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");

}
echo"<center><b><h2>YOUR SHOPPING CART</h2></center></b>";
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
<td></td>
</tr>';
$total=0;
$query="SELECT p.prod_name,sum(I.quantity),SUM(P.prod_price) FROM inventory I JOIN products P on I.prod_id=P.prod_id WHERE I.event_id in (select event_id from cart where account_id ='{$user_id}' AND cart_status=1)  group by I.prod_id,I.quantity";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
echo'<tr>';
echo '<td>';
echo $row['prod_name'];
echo '</td><td><div align="right">';
echo $row['sum(I.quantity)'];
echo '</div></td><td><div align="right">';
echo $row['SUM(P.prod_price)'];
$price=$row['SUM(P.prod_price)'];
$total=$total+$price;
echo '</div></td><td>';
echo"<form action='remove_cart.php' method='POST'>
<button type='submit' name='remove' value='{$row['prod_name']}' class='btn btn-primary'>Remove from<i class='fa fa-shopping-cart'></i></button>
</form>";
echo '</td>';
}
if(isset($_POST['remove'])){
 header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/remove_cart.php");

}
echo '<tr><td><b>TOTAL </td><td></td></td></td><td></td><td><div align="center"><b>₱';
echo $total;
echo '</div></td></tr></table>';

echo"<br><br><center>
<form action='checkout.php' method='POST'>
<button type='submit' name='checkout' value='Checkout' align='right'class='btn btn-primary'>Checkout</button>
</form>";
?>

</div>
<BR><BR><BR><BR><BR>
<?php
require_once('footer.php');
?>
</body>

</html>

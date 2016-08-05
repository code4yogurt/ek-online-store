<?php

session_start();
require_once('../mysql_connect.php');

echo"
<form action='{$_SERVER['PHP_SELF']}' method='POST'>View by: 
<select name='dropdown'>
<option value='product'>Product</option>
<option value='user' selected>User</option>
</select>
<button type='submit' name='view_type' value='button'>Go</button>
</form>
";

$user=$_SESSION['type'];
if($user!='aac'){
  header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
}
$datetime= date("Y-m-d H:i:s");


$view='product';
if(isset($_POST['dropdown'])){
	$view=$_POST['dropdown'];
	}
if($view=='product'){

$query="SELECT count(distinct(p.prod_name)) AS prod_count FROM cart c join inventory i on c.event_id=i.event_id join products p on i.prod_code=p.prod_code WHERE c.cart_status=0";
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
<p align='center'><b>PRODUCT SALES REPORT</p></b>
<p align='left'>$datetime</p>
<table width='75%' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
<tr>
<td>
PRODUCTS
</td>
<td>
QUANTITY
</td>
<td>
SALES
</td>
<td>
</td>
</tr>
";
$total=0;
$query="SELECT p.prod_code,p.prod_name,count(i.event_id) as quantity, (p.prod_price * count(i.event_id)) AS sales FROM cart c join inventory i on c.event_id=i.event_id join products p on i.prod_code=p.prod_code WHERE c.cart_status=0 GROUP BY p.prod_name ORDER BY `sales`  DESC LIMIT $start,10";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$total=$row['sales']+$total;
echo"
<tr>
<td>
{$row['prod_name']}
</td>
<td>
{$row['quantity']}
</td>
<td>
<p align='right'>{$row['sales']}</p>
</td>
<td>
<form action='item_sales_report.php' method='POST'>
			<button type='submit' name='item' value='{$row['prod_code']}'>View Details</button>
			</form>
</td>
</tr>
";
}
echo"</table>
<br><table width='75%' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
<tr>
<td>
<b>TOTAL SALES</b>
</td>
<td>
<b><p align='right'>{$total}</p></b>
</td>
</tr>
</table>
";

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
}


else{

	$query="SELECT count(distinct(c.account_id)) as id_count FROM accounts a join cart c on a.account_id=c.account_id join inventory i on c.event_id=i.event_id join products p on i.prod_code=p.prod_code WHERE c.cart_status=0";
$result=mysqli_query($dbc,$query);
$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
$pages=$row['id_count'] / 10;
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
<p align='center'><b>USER SALES REPORT</p></b>
<p align='left'>$datetime</p>
<table width='75%' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
<tr>
<td>
USER
</td>
<td>
QUANTITY
</td>
<td>
SALES
</td>
<td>
</td>
</tr>
";
$total=0;
$query="SELECT c.account_id,a.username,count(i.event_id) as quantity, (p.prod_price * count(i.event_id)) AS sales FROM accounts a join cart c on a.account_id=c.account_id join inventory i on c.event_id=i.event_id join products p on i.prod_code=p.prod_code WHERE c.cart_status=0 GROUP BY c.account_id ORDER BY `sales` DESC LIMIT $start,10";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$total=$row['sales']+$total;
echo"
<tr>
<td>
{$row['username']}
</td>
<td>
{$row['quantity']}
</td>
<td>
<p align='right'>{$row['sales']}</p>
</td>
<td>
<form action='specific-user-history.php' method='GET'>
			<button type='submit' name='specific-user' value='{$row['account_id']}'>View Details</button>
			</form>
</td>
</tr>
";
}
echo"</table>
";
echo"</table>
<br><table width='75%' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
<tr>
<td>
<b>TOTAL SALES</b>
</td>
<td>
<b><p align='right'>{$total}</p></b>
</td>
</tr>
</table>
";
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
}

?>

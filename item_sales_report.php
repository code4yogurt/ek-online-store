<?php

session_start();
require_once('../mysql_connect.php');



$user=$_SESSION['type'];
if($user!='aac'){
  header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
}
$datetime= date("Y-m-d H:i:s");

if(isset($_POST['item'])){
$item_code=$_POST['item'];
$_SESSION['inventory_item_change']=$item_code;
}
else{
	$item_code=$_SESSION['inventory_item_change'];
}
$query="select prod_name from products where prod_code=$item_code";
$result=mysqli_query($dbc,$query);
$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
$name=$row['prod_name'];

$query="SELECT count(distinct(i.event_id)) as event_count FROM cart c join inventory i on c.event_id=i.event_id join products p on i.prod_code=p.prod_code join accounts a on a.account_id = i.account_id WHERE c.cart_status=0 AND p.prod_code=$item_code";
$result=mysqli_query($dbc,$query);
$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
$pages=$row['event_count'] / 10;
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
<p align='center'><b>'{$name}' SALES REPORT</p></b>
<p align='left'>$datetime</p>
<table width='75%' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
<tr>
<td>
DATE
</td>
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
TOTAL
</td>
</tr>
";
$total=0;
$query="SELECT i.event_date,i.event_id,a.username,i.quantity,(p.prod_price*i.quantity) as sales FROM cart c join inventory i on c.event_id=i.event_id join products p on i.prod_code=p.prod_code join accounts a on a.account_id = i.account_id WHERE c.cart_status=0 AND p.prod_code=$item_code ORDER BY i.event_date DESC";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
	$total=$total+$row['sales'];
	}

$query="SELECT i.event_date,i.event_id,a.username,i.quantity,(p.prod_price*i.quantity) as sales FROM cart c join inventory i on c.event_id=i.event_id join products p on i.prod_code=p.prod_code join accounts a on a.account_id = i.account_id WHERE c.cart_status=0 AND p.prod_code=$item_code ORDER BY i.event_date DESC";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
echo"
<tr>
<td>
{$row['event_date']}
</td>
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
<p align='right'>{$total}</p>
";
$total=$total-$row['sales'];
echo"
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

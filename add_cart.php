<?php
session_start();
$cart_item=$_POST['add_item'];
require_once('../mysql_connect.php');
$query="select account_id from accounts where username='{$_SESSION['username']}'";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$user_id= $row['account_id'];
}
$query="select prod_code from products where prod_name='$cart_item'";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$prod_code= $row['prod_code'];
}
$year1=date('Y');
  	$month1=date('m');
  	$day1=date('d');

	$date=$year1 . '-' . $month1 . '-' . $day1;


$query="SELECT SUM(quantity) from inventory where prod_code =$prod_code and change_type = 'in'";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$n1=$row['SUM(quantity)'];
}
$query="SELECT SUM(quantity) from inventory where prod_code =$prod_code and change_type = 'out'";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$n2=$row['SUM(quantity)'];
}
$quantity=$n1-$n2;
if($quantity>0){
	$datetime= date("Y-m-d H:i:s");

$query="insert into inventory (change_type, quantity, event_date,prod_code,remarks,account_id) values ('out','1','{$datetime}','{$prod_code}','Added to cart','{$user_id}')";
$result=mysqli_query($dbc,$query);
$query="select event_id from inventory where event_date='{$datetime}' AND account_id='{$user_id}'";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$event=$row['event_id'];
}
$query="insert into cart (event_id,account_id,date) values ('{$event}','{$user_id}','{$date}')";
$result=mysqli_query($dbc,$query);




header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/cart.php");
}
else if($quantity<=0){
	header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
}

?>




<?php
session_start();
require_once('../mysql_connect.php');
$item=$_POST['remove'];

$query="select prod_id from size where size_id='{$item}'";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$remove_id=$row['prod_id'];
}

$query="select account_id from accounts where username='{$_SESSION['username']}'";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$user_id= $row['account_id'];
}
$query="SELECT count(event_id) FROM cart where cart_status=1 AND event_id in (select event_id from inventory where account_id='{$user_id}' AND size_id='{$item}')";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$quantity= $row['count(event_id)'];
}
$datetime= date("Y-m-d H:i:s");
$query1="insert into inventory (change_type, quantity, event_date,prod_id,size_id,remarks,account_id) values ('in','{$quantity}','{$datetime}','{$remove_id}','{$item}','Item removed from cart','{$user_id}')";
$result1=mysqli_query($dbc,$query1);
$query="delete from cart where cart_status=1 AND event_id in (select event_id from inventory where account_id='{$user_id}' AND size_id='{$item}')";
$result=mysqli_query($dbc,$query);

echo"$item";
header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/cart.php");

?>


QUANTITY PROBLEM!
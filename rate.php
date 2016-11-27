<?php
session_start();
require_once('../mysql_connect.php');
if(isset($_POST['star'])){
echo $_POST['star'];
$year1=date('Y');
  	$month1=date('m');
  	$day1=date('d');

	$date=$year1 . '-' . $month1 . '-' . $day1;

$query="select account_id from accounts where username='{$_SESSION['username']}'";
		$result=mysqli_query($dbc, $query);
		$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
		$account_id=$row['account_id'];

$query="insert into new_table (rating, rating_date, prod_id,account_id) values ('{$_POST['star']}','{$date}','{$_SESSION['prod_code']}','{$account_id}')";
$result=mysqli_query($dbc,$query);
header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
}
else{
	header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
}
?>
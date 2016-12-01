<?php
session_start();
require_once('../db_connect.php');
$prod_code=$_SESSION['prod_code'];
$username=$_SESSION['username'];
$comment=$_POST['content'];
$year1=date('Y');
    $month1=date('m');
    $day1=date('d');
    $date=$year1 . '-' . $month1 . '-' . $day1;

$query="insert into comments (prod_id,username,comment,date,status) values ('{$prod_code}','{$username}','{$comment}','{$date}',1) ";
$result=mysqli_query($dbc,$query);
header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");

?>
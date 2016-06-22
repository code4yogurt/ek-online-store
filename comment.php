<?php
session_start();
require_once('../mysql_connect.php');
$prod_code=$_SESSION['prod_code'];
$username=$_SESSION['username'];
$comment=$_POST['content'];
$query="insert into comments (prod_id,username,comment) values ('{$prod_code}','{$username}','{$comment}') ";
$result=mysqli_query($dbc,$query);
header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");

?>
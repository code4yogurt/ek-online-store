<?php
session_start();
require_once('../mysql_connect.php');

$user=$_SESSION['type'];
if($user!='aac'){
  header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
}

  $year=date('Y');
  $month=date('m');
  $day=date('d');
  $date=$year . '-' . $month . '-' . $day;
  
  $id=$_POST['remove'];

  $query="UPDATE featured_items SET date_end = '{$date}' where featured_id='$id'";
  $result=mysqli_query($dbc,$query);

  header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/featured_items.php");


?>


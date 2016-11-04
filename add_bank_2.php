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
  
  $id=$_POST['approve'];
  echo $id;
  echo $date;
  $query="UPDATE pending_payment SET payment_status = 1 where payment_id=$id";
  $result=mysqli_query($dbc,$query);

  $query="UPDATE cart SET cart_activity = 2 where payment_id =$id";
  $result=mysqli_query($dbc,$query);

 
?>
<?php
session_start();
require_once('../mysql_connect.php');

  $year=date('Y');
  $month=date('m');
  $day=date('d');
  $date=$year . '-' . $month . '-' . $day;
  
  $id=$_POST['add'];
  echo $id;
  echo $date;
  $query="INSERT INTO featured_items (prod_id, date_start, date_end) VALUES ('{$id}','{$date}', NULL)";
  $result=mysqli_query($dbc,$query);

 
  header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/featured_items.php");


?>
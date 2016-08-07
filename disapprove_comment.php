<?php
session_start();
require_once('../mysql_connect.php');

$user=$_SESSION['type'];
if($user!='aac'){
  header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
}

echo $_POST['disapprove']; 
 
$id=$_POST['disapprove']; 

$query="UPDATE comments SET status=0 ,status_approval='{$_SESSION['username']}' where comment_id=$id ";
$result=mysqli_query($dbc,$query);

header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/manage_comments.php");

?>
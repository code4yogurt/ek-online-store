<?php
session_start();
require_once('/connect.php');
//Sets logged-in status to 0, indicating that user is no longer logged in
if(isset($_SESSION['is_loggedin'])){
	$_SESSION['is_loggedin']=0;
	header("Location: http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/index.php");
}
?>
hello
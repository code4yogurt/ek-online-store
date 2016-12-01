<?php
session_start();
require_once('../db_connect.php');
$item_name=$_POST['suggested_item'];
$item_name = str_replace(' ', '+', $item_name);


$link="/specificitem.php?submit=";


$result = $link . $item_name;
echo $result;


header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF']).$result);
?>

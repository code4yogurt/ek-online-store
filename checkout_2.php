
      <a href='index.php'>| EK Store | </a>
      <a href='apparel.php'>APPAREL | </a>
      <a href='accessories.php'>ACCESSORIES | </a>
      <a href='drinkware.php'>DRINK WARE | </a>
      <a href='toys.php'>TOYS | </a>
<?php
session_start();

require_once('../mysql_connect.php');

$queryid="select account_id from accounts where username='{$_SESSION['username']}'";
		$resultid=mysqli_query($dbc, $queryid);

		while($row=mysqli_fetch_array($resultid,MYSQLI_ASSOC)){
			$account_id=$row['account_id'];

		}


if($_SESSION['checkout']!=1){

			header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
}
?>
<br>
<br>
Your order has been received. Please wait for the confirmation on your bank details through email. Thank you! 
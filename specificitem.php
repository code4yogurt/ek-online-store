
      <a href='index.php'>| EK Store | </a>
      <a href='apparel.php'>APPAREL | </a>
      <a href='accessories.php'>ACCESSORIES | </a>
      <a href='drinkware.php'>DRINK WARE | </a>
      <a href='toys.php'>TOYS | </a>
<?php
session_start();

$item=$_GET['submit'];
require_once('../mysql_connect.php');

$_SESSION['checkout']=0;

$ip= $_SERVER['REMOTE_ADDR'];
$query="select status from products where prod_name='$item'";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$status= $row['status'];
}

if($status!=1){
header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");

}
else{
$query="select prod_id from products where prod_name='$item'";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$prod_code= $row['prod_id'];
}
$_SESSION['prod_code']=$prod_code;

$comment_status=0;

if (isset($_SESSION['type'])) {
        
	$query="select account_id from accounts where username='{$_SESSION['username']}'";
	$result=mysqli_query($dbc,$query);
	while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
	$account_id=$row['account_id'];
	}
        echo"<a href='myaccount.php'>My Account | </a>";
	echo"<a href='cart.php'>Cart | </a>";
	echo"<a href='logout.php'>Log out | </a>";

	$output='add_cart.php';

	$year1=date('Y');
  	$month1=date('m');
  	$day1=date('d');

	$date=$year1 . '-' . $month1 . '-' . $day1;
	
	$query="insert into product_view (account_id,prod_code,view_date,ip_address) values('{$account_id}','{$prod_code}','{$date}','{$ip}')";
	$result=mysqli_query($dbc,$query);
	
}
else{
	echo"<a href='creation.php'>Create Account</a>
	<a href='login.php'>Log In</a>";
	$output='login.php';
	$year1=date('Y');
  	$month1=date('m');
  	$day1=date('d');

	$date=$year1 . '-' . $month1 . '-' . $day1;
	$query="insert into product_view (prod_code,view_date,ip_address) values('{$prod_code}','{$date}','{$ip}')";
	$result=mysqli_query($dbc,$query);
}
$query="select * from products where prod_name='$item'";
$result=mysqli_query($dbc,$query);

while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

echo "<h1>{$row['prod_name']}</h1><br>
<img src='{$row['image']}' height='200 width='100''/><br>";
echo $row['prod_desc'];
echo '<br>PHP: ';
echo $row['prod_price'];
$name=$row['prod_name'];
$id=$row['prod_id'];
}

$query="SELECT SUM(quantity) from inventory where prod_id =$id and change_type = 'in'";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$n1=$row['SUM(quantity)'];
}
$query="SELECT SUM(quantity) from inventory where prod_id =$id and change_type = 'out'";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$n2=$row['SUM(quantity)'];
}
$quantity=$n1-$n2;
if($quantity>0){
echo "<br>Add to Cart: ";
echo "<form action='$output' method='POST'>
<input type='submit' name='add_item' value='$name' />
</form>
";
}
else{
echo '<br>There are currently no stocks available';
}
$query="select username from accounts where account_id in(select account_id from official_receipt where account_id in(select account_id from cart where cart_status=0 AND event_id in (select event_id from inventory where prod_id='{$prod_code}')))";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$valid_user=$row['username'];
 
if(isset($_SESSION['username'])) {
if($_SESSION['username']==$valid_user){
	$comment_status=1;
}
}

}

if($comment_status==1) {
?>

<form action="comment.php" method="post">

<?php
echo"
Comment : <br />
<textarea rows='5' cols='50' name='content'>
</textarea>
<input type='submit' name='comment' value='Submit' />
</form>";
}
echo"<table border='1'>";
$query="select username,date,comment from comments where prod_id='{$prod_code}' AND status=2";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
	echo "<tr><td>";
	echo $row['username'];
	echo "</td><td>";
	echo $row['date'];
	echo "</td></tr>";
	echo"<tr><td width=\'90%\'><div align='center'>";
	echo $row['comment'];
	echo"</td></tr>";
}


}
?>



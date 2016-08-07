<?php

session_start();
require_once('../mysql_connect.php');

$user=$_SESSION['type'];
if($user!='aac'){
  header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
}

echo"
<form action='{$_SERVER['PHP_SELF']}' method='GET'>View by: 
<select name='dropdown'>
<option value='product'>Product</option>
<option value='user' selected>User</option>
</select>
<button type='submit' name='view_type' value='go'>Go</button>
</form>
";

if(isset($_GET['dropdown'])){
	$_SESSION['view']=$_GET['dropdown'];
	}
else if(isset($_SESSION['view'])){

}
else{
$_SESSION['view']='product';	
}
$datetime= date("Y-m-d H:i:s");


if($_SESSION['view']=='product'){

$query="select COUNT(distinct(v.prod_code)) as view_count from product_view v join products p on v.prod_code=p.prod_code";
$result=mysqli_query($dbc,$query);
$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
$pages=$row['view_count'] / 10;
$page_no=ceil($pages);

$start=0;
if(isset($_POST['go'])){
	$pn=$_POST['dropdown'];

$start=($_POST['dropdown']-1)*10;
}
else{
$pn=1;
}

echo"
<p align='center'><b>PRODUCT VIEWS REPORT</p></b>
<p align='left'>$datetime</p>
<table width='75%' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
<tr>
<td>
PRODUCTS
</td>
<td>
VIEWS
</td>
<td>
</td>
</tr>
";
$query="select v.prod_code, p.prod_name, count(v.prod_code) as views from product_view v join products p on v.prod_code=p.prod_code group by p.prod_name order by views desc LIMIT $start,10";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
echo"
<tr>
<td>
{$row['prod_name']}
</td>
<td>
{$row['views']}
</td>
<td>
<form action='item_views_report.php' method='POST'>
			<button type='submit' name='item' value='{$row['prod_code']}'>View Details</button>
			</form>
</td>
</tr>
";
}

echo"</table>";
if(isset($_POST['dropdown'])){
if($_POST['dropdown']==$page_no){
echo "<p align='center'><b>----END OF REPORT----</p></b>";
}
}
else{
	if($page_no==1){
		echo "<p align='center'><b>----END OF REPORT----</p></b>";
	}
}


echo "<p align='right'>Page: {$pn}	</p>";
echo"
<form action='{$_SERVER['PHP_SELF']}' method='POST'>
<p align='right'>Page: <select name='dropdown'></p>
";
for($i=$page_no;$i>0;$i--){
	echo"
		<option value='{$i}' selected>{$i} </option>
	";
}
echo"
</select>
<input type='submit' name='go' value='Go' />
</form>
";

}



else{

$query="select count(distinct(a.account_id)) as views from product_view v join accounts a on v.account_id=a.account_id";
$result=mysqli_query($dbc,$query);
$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
$pages=$row['views'] / 10;
$page_no=ceil($pages);

$start=0;
if(isset($_POST['go2'])){
	$pn=$_POST['dropdown2'];

$start=($_POST['dropdown2']-1)*10;
}
else{
$pn=1;
}


	echo"
<p align='center'><b>USER VIEWS REPORT</p></b>
<p align='left'>$datetime</p>
<table width='75%' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
<tr>
<td>
USER
</td>
<td>
VIEWS
</td>
<td>
</td>
</tr>
";
$query="select a.account_id, a.username, count(v.account_id) as views from product_view v join accounts a on v.account_id=a.account_id group by a.username order by views desc LIMIT $start,10";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
echo"
<tr>
<td>
{$row['username']}
</td>
<td>
{$row['views']}
</td>
<td>
<form action='user_views_report.php' method='POST'>
			<button type='submit' name='user' value='{$row['account_id']}'>View Details</button>
			</form>
</td>
</tr>
";
}

echo"</table>";
if(isset($_POST['dropdown2'])){
if($_POST['dropdown2']==$page_no){
echo "<p align='center'><b>----END OF REPORT----</p></b>";
}
}
else{
	if($page_no==1){
		echo "<p align='center'><b>----END OF REPORT----</p></b>";
	}
}

echo "<p align='right'>Page: {$pn}	</p>";
echo"
<form action='{$_SERVER['PHP_SELF']}' method='POST'>
<p align='right'>Page: <select name='dropdown2'></p>
";
for($i=$page_no;$i>0;$i--){
	echo"
		<option value='{$i}' selected>{$i} </option>
	";
}
echo"
</select>
<input type='submit' name='go2' value='Go' />
</form>
";



}
?>

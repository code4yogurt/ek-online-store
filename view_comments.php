<?php

session_start();
require_once('../mysql_connect.php');

$user=$_SESSION['type'];
if($user!='aac'){
  header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
}

echo"
<form action='{$_SERVER['PHP_SELF']}' method='POST'>View by: 
<select name='dropdown'>
<option value='product'>Product</option>
<option value='user' selected>User</option>
</select>
<button type='submit' name='view_type' value='go'>Go</button>
</form>
";

if(isset($_POST['dropdown'])){
	$_SESSION['comment_view']=$_POST['dropdown'];
	}
else if(isset($_SESSION['comment_view'])){

}
else{
$_SESSION['comment_view']='product';	
}

if($_SESSION['comment_view']=='product'){

$query="select COUNT(distinct(p.prod_code)) as comment_count from products P join comments C on p.prod_code=c.prod_id";
$result=mysqli_query($dbc,$query);
$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
$pages=$row['comment_count'] / 10;
$page_no=ceil($pages);

$start=0;
if(isset($_GET['go'])){
	$pn=$_GET['dropdown'];

$start=($_GET['dropdown']-1)*10;
}
else{
$pn=1;
}

echo"
<p align='center'><b>PRODUCT COMMENTS</p></b>
<table width='75%' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
<tr>
<td>
PRODUCTS
</td>
<td>
NUMBER OF COMMENTS
</td>
<td>
</td>
</tr>
";

$query="select p.prod_code, p.prod_name, count(c.prod_id) as count from products P join comments C on p.prod_code=c.prod_id group by prod_id LIMIT $start,10";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
echo"
<tr>
<td>
{$row['prod_name']}
</td>
<td>
{$row['count']}
</td>
<td>
<form action='product_comments.php' method='POST'>
			<button type='submit' name='specific_comment' value='{$row['prod_code']}'>View Comments</button>
			</form>
</td>
</tr>

";
}
echo "</table><p align='right'>Page: {$pn}	</p>";
echo"
<form action='{$_SERVER['PHP_SELF']}' method='GET'>
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

$query="SELECT count(distinct(c.username)) as user_count from accounts A join comments c on a.username=c.username";
$result=mysqli_query($dbc,$query);
$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
$pages=$row['user_count'] / 10;
$page_no=ceil($pages);

$start=0;
if(isset($_GET['go'])){
	$pn=$_GET['dropdown'];

$start=($_GET['dropdown']-1)*10;
}
else{
$pn=1;
}

	echo"
	<p align='center'><b>USER COMMENTS</p></b>

<table width='75%' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
<tr>
<td>
USER
</td>
<td>
NUMBER OF COMMENTS
</td>
<td>
</td>
</tr>
";

$query="SELECT a.account_id,a.username, count(c.username) as count from accounts A join comments c on a.username=c.username group by c.username LIMIT $start,10";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
echo"
<tr>
<td>
{$row['username']}
</td>
<td>
{$row['count']}
</td>
<td>
<form action='user_comments.php' method='POST'>
			<button type='submit' name='specific_comment' value='{$row['account_id']}'>View Comments</button>
			</form>
</td>
</tr>

";
}
echo "</table>";


echo "<p align='right'>Page: {$pn}	</p>";
echo"
<form action='{$_SERVER['PHP_SELF']}' method='GET'>
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
?>

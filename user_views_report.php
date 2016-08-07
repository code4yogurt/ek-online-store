<?php

session_start();
require_once('../mysql_connect.php');

$user=$_SESSION['type'];
if($user!='aac'){
  header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
}


if(isset($_POST['user'])){
$user_id=$_POST['user'];
$_SESSION['user_viewed']=$user_id;
}
else{
	$user_id=$_SESSION['user_viewed'];
}


$query="select username from accounts where account_id=$user_id";
$result=mysqli_query($dbc,$query);
$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
$name=$row['username'];


$query="SELECT count(v.view_id) as view_count FROM product_view v JOIN products p on v.prod_code=p.prod_code where v.account_id=$user_id";
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

$datetime= date("Y-m-d H:i:s");


echo"
<p align='center'><b>'{$name}' VIEWS REPORT</p></b>
<p align='left'>$datetime</p>
<table width='75%' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
<tr>
<td>
DATE VIEWED
</td>
<td>
PRODUCT
</td>
</tr>
";

$query="SELECT v.view_date,p.prod_name FROM product_view v JOIN products p on v.prod_code=p.prod_code where v.account_id=$user_id order by v.view_date desc LIMIT $start,10";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
echo"
<tr>
<td>
{$row['view_date']}
</td>
<td>
{$row['prod_name']}
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



?>

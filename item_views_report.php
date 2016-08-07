<?php

session_start();
require_once('../mysql_connect.php');

$user=$_SESSION['type'];
if($user!='aac'){
  header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
}

if(isset($_POST['item'])){
$item_code=$_POST['item'];
$_SESSION['item_viewed']=$item_code;
}
else{
	$item_code=$_SESSION['item_viewed'];
}

$query="select prod_name from products where prod_code=$item_code";
$result=mysqli_query($dbc,$query);
$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
$name=$row['prod_name'];

$query="select count(view_id) as view_count FROM product_view where prod_code=$item_code";
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
USER IP ADDRESS
</td>
<td>
USER
</td>
</tr>
";

$query="SELECT view_date,ip_address,account_id FROM product_view where prod_code=$item_code order by view_date desc LIMIT $start,10";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
echo"
<tr>
<td>
{$row['view_date']}
</td>
<td>
{$row['ip_address']}
</td>
<td>
";
if($row['account_id']==0){
	echo "GUEST";
}
else{
$query2="SELECT username from accounts where account_id={$row['account_id']}";
$result2=mysqli_query($dbc,$query2);
while($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
echo"
{$row2['username']}
";
}
}
echo"
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

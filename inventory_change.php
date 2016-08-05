<?php

session_start();
require_once('../mysql_connect.php');
$user=$_SESSION['type'];
if($user!='aac'){
  header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
}


$datetime= date("Y-m-d H:i:s");

$query="SELECT count(event_id) as event_id FROM inventory";
$result=mysqli_query($dbc,$query);
$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
$pages=$row['event_id'] / 10;
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
<p align='center'><b>INVENTORY CHANGE HISTORY REPORT</p></b>
<p align='left'>$datetime</p>
<table width='75%' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
<tr>
<td>
DATE
</td>
<td>
CHANGED BY
</td>
<td>
PRODUCT
</td>
<td>
CHANGE TYPE
</td>
<td>
QUANTITY
</td>
</tr>
";

$query="SELECT event_date, a.username, p.prod_name, change_type, quantity FROM accounts a join inventory i on a.account_id=i.account_id join products p on i.prod_code=p.prod_code order by event_date desc LIMIT $start,10";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
echo"
<tr>
<td>
{$row['event_date']}
</td>
<td>
{$row['username']}
</td>
<td>
{$row['prod_name']}
</td>
<td>
{$row['change_type']}
</td>
<td>
<p align='right'>{$row['quantity']}</p>
</td>

</tr>
";
}
echo"</table>";

if(isset($_GET['dropdown'])){
if($_GET['dropdown']==$page_no){
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

?>
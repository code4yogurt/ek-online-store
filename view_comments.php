<?php

session_start();
require_once('../mysql_connect.php');

echo"
<form action='{$_SERVER['PHP_SELF']}' method='GET'>View by: 
<select name='dropdown'>
<option value='product'>Product</option>
<option value='user' selected>User</option>
</select>
<button type='submit' name='view_type' value='go'>Go</button>
</form>
";

$view='product';
if(isset($_GET['dropdown'])){
	$view=$_GET['dropdown'];
	}
if($view=='product'){
echo"
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

$query="select p.prod_code, p.prod_name, count(c.prod_id) as count from products P join comments C on p.prod_code=c.prod_id group by prod_id";
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
}
else{
	echo"
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

$query="SELECT a.account_id,a.username, count(c.username) as count from accounts A join comments c on a.username=c.username group by c.username";
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
}
?>

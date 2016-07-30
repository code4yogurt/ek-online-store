<?php
session_start();
require_once('../mysql_connect.php');
?>
<a href='manage_comments.php'>Pending Comments</a> | 
<a href='manage_approved_comments.php'>Approved Comments</a> | 
<a href='manage_disapproved_comments.php'>Disapproved Comments</a>

<br><br><b>LIST OF APPROVED COMMENTS:</b><br><br>

<!--GETTING NUMBER OF PAGES AND SETTING OF START OF ITEMS PER PAGE-->

<?php

$query="SELECT count(comment_id) as comment_count FROM comments";
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
echo "<br>Page: {$pn}	";


echo"
<table width='75%' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
<tr>
<td>
DATE
</td>
<td>
USER
</td>
<td>
PRODUCT
</td>
<td>
COMMENT
</td>
<td>
</td>
</tr>
";


$query="select C.date, P.prod_name, C.username, C.comment, C.comment_id from products P JOIN comments C ON p.prod_code=c.prod_id where c.status = 2 LIMIT $start,10";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
	echo"
	<tr>
		<td>
		{$row['date']}
		</td>
		<td>
		{$row['prod_name']}
		</td>
		<td>
		{$row['username']}
		</td>
		<td>
		{$row['comment']}
		</td>
		<td>
			<form action='pending_comment.php' method='POST'>
			<button type='submit' name='pending' value='{$row['comment_id']}'>Move to Pending List</button>
			</form>

		</td>
	</tr>
	";
}




echo"
</table>
<form action='{$_SERVER['PHP_SELF']}' method='GET'>
Page: <select name='dropdown'>
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


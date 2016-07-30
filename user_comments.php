<?php

session_start();
require_once('../mysql_connect.php');

$id=$_POST['specific_comment'];
$query="select username from accounts where account_id=$id";
		$result=mysqli_query($dbc, $query);
		$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
$user=$row['username'];
echo "User: {$user}";

echo"
<table width='75%' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
<tr>
<td>
DATE
</td>
<td>
PRODUCT
</td>
<td>
COMMENT
</td>
<td>
STATUS
</td>
</tr>
";

$query="select c.date, p.prod_name, c.comment, c.status from comments c join products p on c.prod_id=p.prod_code where c.username='$user'";
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
{$row['comment']}
</td>
<td>
";
if($row['status']==0){
	echo"Unapproved";
}

else if($row['status']==1){
	echo"Pending";
}

else if($row['status']==2){
	echo"Approved";
}
echo"
</td>
</tr>
";

}
?>
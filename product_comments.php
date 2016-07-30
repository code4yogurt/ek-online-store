<?php

session_start();
require_once('../mysql_connect.php');

$id=$_POST['specific_comment'];
echo $id;

echo"
<table width='75%' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
<tr>
<td>
DATE
</td>
<td>
FROM
</td>
<td>
COMMENT
</td>
<td>
STATUS
</td>
</tr>
";

$query="select * from comments where prod_id=$id";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
echo"
<tr>
<td>
{$row['date']}
</td>
<td>
{$row['username']}
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
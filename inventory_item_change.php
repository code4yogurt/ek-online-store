<?php

session_start();
require_once('../mysql_connect.php');
$item=$_POST['item'];

echo"
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

$query="SELECT event_date, a.username, p.prod_name, change_type, quantity FROM accounts a join inventory i on a.account_id=i.account_id join products p on i.prod_code=p.prod_code where i.prod_code=$item order by event_date desc ";
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
{$row['quantity']}
</td>

</tr>
";
}

?>
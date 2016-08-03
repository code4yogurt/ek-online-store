<?php

session_start();
require_once('../mysql_connect.php');

echo"
<table width='75%' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
<tr>
<td>
DATE
</td>
<td>
EVENT ID
</td>
<td>
USER
</td>
<td>
PRODUCT
</td>
<td>
QUANTITY
</td>
<td>
SALES
</td>
<td>
TOTAL
</td>
</tr>
";
$total=0;
$query="SELECT i.event_date,i.event_id,a.username,p.prod_name,i.quantity,(p.prod_price*i.quantity) as sales FROM cart c join inventory i on c.event_id=i.event_id join products p on i.prod_code=p.prod_code join accounts a on a.account_id = i.account_id WHERE c.cart_status=0 ORDER BY i.event_date DESC";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
	$total=$total+$row['sales'];
	}

$query="SELECT i.event_date,i.event_id,a.username,p.prod_name,i.quantity,(p.prod_price*i.quantity) as sales FROM cart c join inventory i on c.event_id=i.event_id join products p on i.prod_code=p.prod_code join accounts a on a.account_id = i.account_id WHERE c.cart_status=0 ORDER BY i.event_date DESC";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
echo"
<tr>
<td>
{$row['event_date']}
</td>
<td>
{$row['event_id']}
</td>
<td>
{$row['username']}
</td>
<td>
{$row['prod_name']}
</td>
<td>
{$row['quantity']}
</td>
<td>
{$row['sales']}
</td>
<td>
{$total}
";
$total=$total-$row['sales'];
echo"
</td>
</tr>
";
}





?>

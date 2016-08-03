<?php

session_start();
require_once('../mysql_connect.php');


echo"
<table width='75%' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
<tr>
<td>
PRODUCTS
</td>
<td>
QUANTITY
</td>
<td>
SALES
</td>
<td>
</td>
</tr>
";
$total=0;
$query="SELECT p.prod_code,p.prod_name,count(i.event_id) as quantity, (p.prod_price * count(i.event_id)) AS sales FROM cart c join inventory i on c.event_id=i.event_id join products p on i.prod_code=p.prod_code WHERE c.cart_status=0 GROUP BY p.prod_name ORDER BY `sales`  DESC";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$total=$row['sales']+$total;
echo"
<tr>
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
<form action='item_sales_report.php' method='POST'>
			<button type='submit' name='item' value='{$row['prod_code']}'>View Details</button>
			</form>
</td>
</tr>
";
}
echo"
TOTAL SALES:        {$total}";




?>

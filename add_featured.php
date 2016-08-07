<?php
session_start();
require_once('../mysql_connect.php');
?>
<a href="featured_items.php">Back</a>
<?php
  $query="select count(prod_code) as prod_count from products where prod_code not in(select prod_id from featured_items where date_end is null)";
	$result=mysqli_query($dbc,$query);
	$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
	$pages=$row['prod_count'] / 10;
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
   <p align='center'><b>LIST OF PRODUCTS</p></b>
   <table width='75%' border='1' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000'>
   <tr>
   	<td>
   		PRODUCT
   	</td>
   	<td>
   	</td>
   	</tr>
   ";

   	$query="select prod_code,prod_name from products where prod_code not in(select prod_id from featured_items where date_end is null) LIMIT $start,10";
	$result=mysqli_query($dbc,$query);
	while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
		echo"
		<tr>
			<td>
			{$row['prod_name']}
			</td>
			<td>
				<form action='add_featured_2.php' method='POST'>
					<button type='submit' name='add' value='{$row['prod_code']}'>Feature this Item</button>
					</form>
			</td>
		</tr>
		";
	}
	echo"
	</table>
	";
	echo "Page: {$pn}	";
echo"
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


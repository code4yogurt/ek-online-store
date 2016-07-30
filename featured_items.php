<?php
session_start();
require_once('../mysql_connect.php');
?>
<b>LIST OF FEATURED PRODUCTS:</b><br><br>
<table width="75%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td>
			PRODUCT
		</td>
		<td>
			FEATURED SINCE
		</td>
		<td>
		</td>
	</tr>
<?php
	$query="SELECT F.featured_id,P.prod_name,F.date_start FROM featured_items F JOIN products P ON F.prod_id=P.prod_code WHERE F.date_end IS NULL";
	$result=mysqli_query($dbc,$query);
	while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
		echo"
			<tr>
				<td>
					{$row['prod_name']}
				</td>
				<td>
					{$row['date_start']}
				</td>
				<td>
					<form action='remove_featured.php' method='POST'>
					<button type='submit' name='remove' value='{$row['featured_id']}'>Remove</button>
					</form>
				</td>
			</tr>
		";
	}
?>
	<a href="add_featured.php">Add a Product</a>
<?php
session_start();
require_once('../mysql_connect.php');

$user=$_SESSION['type'];
if($user!='aac'){
  header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
}
?>
<?php
$query="SELECT count(F.featured_id) as featured_count FROM featured_items F JOIN products P ON F.prod_id=P.prod_code WHERE F.date_end IS NULL";
$result=mysqli_query($dbc,$query);
$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
$pages=$row['featured_count'] / 10;
$page_no=ceil($pages);

$start=0;
if(isset($_GET['go'])){
	$pn=$_GET['dropdown'];

$start=($_GET['dropdown']-1)*10;
}
else{
$pn=1;
}
?>
<a href="add_featured.php">Add a Product</a>
<p align='center'><b>LIST OF FEATURED PRODUCTS:</b><br><br></p>
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
	echo"</table>";



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
	
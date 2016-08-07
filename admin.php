<?php
session_start();
require_once('../mysql_connect.php');

$user=$_SESSION['type'];
if($user!='aac'){
  header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
}


echo "Welcome Admin: ";
echo $_SESSION['username'];
echo "<br><br>";
echo "<a href='change_stock.php'>Add/Deduct Stock</a><br>";
echo "<a href='inventory_change.php'>Inventory Change</a><br>";
echo "<a href='inventory_report.php'>Current Inventory</a><br>";
echo "<a href='views_report.php'>Item Views Report</a><br>";
echo "<a href='total_sales_report.php'>Total Sales Report</a><br>";
echo "<a href='sales_report.php'>Sales Report</a><br>";
echo "<a href='manage_comments.php'>Manage Product Reviews/Comments</a><br>";
echo "<a href='view_comments.php'>View Comments</a><br>";
echo"<a href='addproduct.php'>Add New Product</a><br><br>";
echo"<a href='selectProduct.php'>Edit Product</a><br><br>";
echo"<a href='deactivate.php'>Deactivate Product</a><br><br>";
echo"<a href='activate.php'>Activate Product</a><br><br>";
echo"<a href='featured_items.php'>Featured Products</a><br><br>";
echo"<a href='activateProducts.php'>View Active Products Product</a><br><br>";
echo"<a href='DeactivatedProducts.php'>View Deactivated Product</a><br><br>";
echo"<a href='logout.php'>Logout</a><br><br>";

?>
<!-- START OF CART EXPIRATION-->

<?php
$query="select account_id from accounts where username='{$_SESSION['username']}'";
  $result=mysqli_query($dbc,$query);
  while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
  $account_id=$row['account_id'];
  }

$query="select YEAR(date),MONTH(date),DAY(date) from cart where cart_status=1";
$result=mysqli_query($dbc,$query);
  while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
  $year1=$row['YEAR(date)'];
  $month1=$row['MONTH(date)'];
  $day1=$row['DAY(date)'];
  
  $year2=date('Y');
  $month2=date('m');
  $day2=date('d');

$date1=date_create($year1 . '-' . $month1 . '-' . $day1);
$date2=date_create($year2 . '-' . $month2 . '-' . $day2);
$diff=date_diff($date1,$date2);
$day_diff=$diff->format("%a");
echo $day_diff;
  if($day_diff>7){
    $date=$year1 . '-' . $month1 . '-' . $day1;
        $query3="select prod_code from inventory where event_id in(select event_id from cart where date='{$date}' AND cart_status=1)";
        $result3=mysqli_query($dbc,$query3);
         while($row=mysqli_fetch_array($result3,MYSQLI_ASSOC)){
          $prod_code=$row['prod_code'];
          $datetime= date("Y-m-d H:i:s");
          $query4="insert into inventory (change_type, quantity, event_date,prod_code,remarks,account_id) values ('in','1','{$datetime}','{$prod_code}','Cart expired','{$account_id}')";
          $result4=mysqli_query($dbc,$query4);
         }
         $query2="delete from cart where date='$date' AND cart_status=1";
        $result2=mysqli_query($dbc,$query2);
  }
        


}
?>



<?php
session_start();

$item=$_GET['submit'];
require_once('../mysql_connect.php');
require_once('navbar.php');
?>


    <div id="all">

        <div id="content">
            <div class="container">


<?php
$_SESSION['checkout']=0;

$ip= $_SERVER['REMOTE_ADDR'];
$query="select status from products where prod_name='$item'";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$status= $row['status'];
}

if($status!=1){
header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");

}
else{
$query="select prod_id from products where prod_name='$item'";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$prod_code= $row['prod_id'];
}
$_SESSION['prod_code']=$prod_code;

$comment_status=0;

if (isset($_SESSION['type'])) {
        
	$query="select account_id from accounts where username='{$_SESSION['username']}'";
	$result=mysqli_query($dbc,$query);
	while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
	$account_id=$row['account_id'];
	}
        

	$output='add_cart.php';

	$year1=date('Y');
  	$month1=date('m');
  	$day1=date('d');

	$date=$year1 . '-' . $month1 . '-' . $day1;
	
	$query="insert into product_view (account_id,prod_code,view_date,ip_address) values('{$account_id}','{$prod_code}','{$date}','{$ip}')";
	$result=mysqli_query($dbc,$query);
	
}
else{
	
	$output='login.php';
	$year1=date('Y');
  	$month1=date('m');
  	$day1=date('d');

	$date=$year1 . '-' . $month1 . '-' . $day1;
	$query="insert into product_view (prod_code,view_date,ip_address) values('{$prod_code}','{$date}','{$ip}')";
	$result=mysqli_query($dbc,$query);
}

$query="SELECT SUM(quantity) from inventory where prod_id =$prod_code and change_type = 'in'";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$n1=$row['SUM(quantity)'];
}
$query="SELECT SUM(quantity) from inventory where prod_id =$prod_code and change_type = 'out'";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$n2=$row['SUM(quantity)'];
}
$quantity=$n1-$n2;


$query="select * from products where prod_name='$item'";
$result=mysqli_query($dbc,$query);

while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
?>
 <div class="col-lg-9">
                     

                    <div class="row" id="productMain">
                       

                        <div class="col-lg-6">
                            <div id="mainImage">
                                <img src="<?php echo "{$row['image']}";?>" alt="" class="img-responsive">
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="box">
                                <h1 class="text-center"><?php echo "{$row['prod_name']}";?></h1>
                                
                                <p class="price">₱<?php echo "{$row['prod_price']}";?></p>
                                <?php
                                $name=$row['prod_name'];
                                if(isset($_SESSION['type'])){
                                	if($quantity>0){
								
									echo "<center><form action='$output' method='POST'>
									<button type='submit' name='add_item' value='$name' class='btn btn-primary'><i class='fa fa-shopping-cart'></i>ADD TO CART</button>
									</form></center>
									";

									}
									else{
									echo '<br><center>There are currently no stocks available</center>';
									}	
                                }
                                else{
                                	echo '<center>Login first to add to cart</center>';	
                                }
                                

                                ?>
                            </div>

                        </div>

                    </div>

                    <div class="box" id="details">
                        <p>
                            <h4>Product Information</h4>
                            <p><?php echo "{$row['prod_desc']}";?>
                        </p>
                            
                    </div>

                

                </div>

                <!-- /.col-md-9 -->
            </div>
            <?php  ?>
            <!-- /.container -->
            
        </div>

            
        <!-- /#content -->
<?php

$id=$row['prod_id'];
}



$query="select username from accounts where account_id in(select account_id from official_receipt where account_id in(select account_id from cart where cart_status=0 AND event_id in (select event_id from inventory where prod_id='{$prod_code}')))";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$valid_user=$row['username'];
 
if(isset($_SESSION['username'])) {
if($_SESSION['username']==$valid_user){
	$comment_status=1;
}
}

}

if($comment_status==1) {
?>

<form action="comment.php" method="post">

<?php
echo"
Comment : <br />
<textarea rows='5' cols='50' name='content'>
</textarea>
<input type='submit' name='comment' value='Submit' />
</form>";
}
echo"<table border='1'>";
$query="select username,date,comment from comments where prod_id='{$prod_code}' AND status=2";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
	echo "<tr><td>";
	echo $row['username'];
	echo "</td><td>";
	echo $row['date'];
	echo "</td></tr>";
	echo"<tr><td width=\'90%\'><div align='center'>";
	echo $row['comment'];
	echo"</td></tr>";
}


}
?>

<?php
require_once('footer.php');
?>
</body>

</html>

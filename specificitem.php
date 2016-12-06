
<?php
session_start();
if(isset($_GET['submit'])){
$_SESSION['item']=$_GET['submit'];
}
require_once('../db_connect.php');
require_once('navbar.php'); 
?>


<?php
$_SESSION['checkout']=0;
$ip= $_SERVER['REMOTE_ADDR'];
$query="select status from products where prod_name='{$_SESSION['item']}'";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$status= $row['status'];
}
if($status!=1){
header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
}
else{
$query="select prod_id from products where prod_name='{$_SESSION['item']}'";
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
    
    $query="insert into product_view (account_id,prod_id,view_date,ip_address) values('{$account_id}','{$prod_code}','{$date}','{$ip}')";
    $result=mysqli_query($dbc,$query);
    
}
else{
    
    $output='login.php';
    $year1=date('Y');
    $month1=date('m');
    $day1=date('d');
    $date=$year1 . '-' . $month1 . '-' . $day1;
    $query="insert into product_view (prod_id,view_date,ip_address) values('{$prod_code}','{$date}','{$ip}')";
    $result=mysqli_query($dbc,$query);
}
//--------------------------------------------------------------------------------------------------------------------
if(isset($_POST['check_size'])){
$query="SELECT SUM(quantity) from inventory where size_id ='{$_POST['sizes']}' and change_type = 'in'";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$n1=$row['SUM(quantity)'];
}
$query="SELECT SUM(quantity) from inventory where size_id ='{$_POST['sizes']}' and change_type = 'out'";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$n2=$row['SUM(quantity)'];
}
$quantity=$n1-$n2;
}
//---------------------------------------------------------------------------------------------------------------------
$query="select * from products where prod_name='{$_SESSION['item']}'";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
?>


<div id="all">
    <div id="content">
        <div class="container">

            <div class="col-lg-9">         
                <div class="row" id="productMain">
                    <div class="col-lg-6">
                        <div id="mainImage">
                            <img src="../admin/production/uploads/<?php echo "{$row['image']}";?>" alt="" class="img-responsive">
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="box">
                            <h1 class="text-center"><?php echo "{$row['prod_name']}";?></h1>
                                Size:
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <select name='sizes'>
                                            <?php
                                                $query2="select * from size where prod_id='{$prod_code}'";
                                                $result2=mysqli_query($dbc,$query2);
                                                while($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
                                                    echo"
                                                        <option value='{$row2['size_id']}' selected>{$row2['size']}</option>
                                                    ";
                                            }
                                            ?>
                                        <?php
                                        echo"
                                            </select>
                                            <button type='submit' name='check_size' value='$name' class='btn btn-primary'>Check Stock</button>
                                            </form>
                                        ";
                                        ?>

                                        <p class="price">₱<?php echo "{$row['prod_price']}";?></p>
                                        <?php
                                            $name=$row['prod_name'];
                                            if(isset($_SESSION['type'])){
                                                if(isset($quantity)){
                                                    if($quantity>0){
                                                        echo "<center><form action='$output' method='POST'>
                                                        <button type='submit' name='add_item' value='{$_POST['sizes']}' class='btn btn-primary'><i class='fa fa-shopping-cart'></i>ADD TO CART</button>
                                                        </form></center>
                                                        ";
                                                    }
                                                        else{
                                                            echo '<br><center>There are currently no stocks available</center>';
                                                        }   
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
                            <p><?php echo "{$row['prod_desc']}";?></p>
                                <h4>  Rate:</h4> 
                                    <div class="row"> 
                                        <div class="col-md-1">
                                            <form action="rate.php" method="post">
                                                <div class="stars">
                                                    <input type="radio" name="star" class="star-1" id="star-1" value='1'/>
                                                    <label class="star-1" for="star-1">1</label>
                                                    <input type="radio" name="star" class="star-2" id="star-2" value='2'/>
                                                    <label class="star-2" for="star-2">2</label>
                                                    <input type="radio" name="star" class="star-3" id="star-3" value='3'/>
                                                    <label class="star-3" for="star-3">3</label>
                                                    <input type="radio" name="star" class="star-4" id="star-4" value='4'/>
                                                    <label class="star-4" for="star-4">4</label>
                                                    <input type="radio" name="star" class="star-5" id="star-5" value='5'/>
                                                    <label class="star-5" for="star-5">5</label>
                                                    <span></span>
                                                    </p>
                                                </div>
                                                <button type='submit' name='rate' value='<?php '{$account_id}' ?>' class='btn btn-primary'>RATE</button>                          
                                            </form>
                                        </div>
                                    </div>
                                    </p>
                            </div>

                            <?php
                $id=$row['prod_id'];
                }
                $query="select username from accounts where account_id in (select account_id from cart where cart_activity>1 and event_id in (select event_id from inventory where prod_id=$prod_code))";
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



                    <div class="row">
                        <div class="col-md-12">
                               <h4>Write a Comment:</h4><br> 
                            <textarea rows='5' cols='50' name='content'></textarea>
                             <div class="row">
                        <div class="col-md-12">
                            <input type='submit' name='comment' value='Submit' class='btn btn-primary'>
                             </div>
                    </div>
                         </div>
                    </div>
                </form>
                 
                        </div>

                <!-- /.col-md-9 -->
                    
            
       

                    <div class="row">
                        <div class="col-md-12">
                <?php
                }
                echo"
                <div class='table-responsive'>
                  <table class='table'> 
                <h4>Comments</h4><br>
                <tr><th>Date</th><th>User</th><th>Comment</th></tr>";
                $query="select username,date,comment from comments where prod_id='{$prod_code}' AND status=2";
                $result=mysqli_query($dbc,$query);
                while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                    echo "<tr><td>";
                    echo $row['date'];
                    echo "</td><td>";
                    echo $row['username'];
                    echo "</td>";
                    echo"<td>";
                    echo $row['comment'];
                    echo"</td></tr>";
                }
                echo"</table>";
                }
                ?>

            </div>
        </div>


            <!-- /.container -->
            


                 </div>
             

            <div class="box" id="details">
            <h4>Suggested Items:</h4><br> 
            <?php
            
            $query="select category from products where prod_name='{$_SESSION['item']}'";
            $result=mysqli_query($dbc,$query);
            while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                $category=$row['category'];
            }
            echo"<table><tr>";
            $query="select *, count(pv.prod_id),p.prod_name from products p join product_view pv on p.prod_id=pv.prod_id where category = '{$category}' and pv.prod_id != '{$_SESSION['prod_code']}' and p.status=1 group by prod_name order by count(pv.prod_id) asc LIMIT 4";
            $result=mysqli_query($dbc,$query);
            while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
            echo"
            <td>
             <img src='{$row['image']}' height='200' width='200' alt='' class='img-responsive'>
            <center><form action='suggested.php' method='POST'>
                                        <p class='buttons'>
                                        <button type='submit'  class='btn btn-primary' name='suggested_item' value='{$row['prod_name']}'>{$row['prod_name']}</button>
                                    </form></center>
                                    </td>
            ";
            }
                ?>
            </table>
            </div>
            </div>

        <!-- /#content -->
                

<?php
require_once('footer.php');
?>
</body>

</html>
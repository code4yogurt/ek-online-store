
<?php
session_start();
require_once('../db_connect.php');
if (isset($_SESSION['type'])) {
      $username=$_SESSION['username'];  
  
        
}
else{
  header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
}
require_once('navbar.php');

?>
<div id="all">

        <div id="content">
            <div class="container">




<?php
$query="select account_id from accounts where username='{$_SESSION['username']}'";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
$user_id= $row['account_id'];
}
?>
  <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">


              <div class="col-md-9" id="basket">

                    <div class="box">

                       

                            <h1>YOUR SHOPPING CART</h1>
                           
                            <?php
                            /*This gets the number of items in your cart*/
                            $query1="SELECT count(event_id) AS cartCount FROM cart WHERE account_id='{$user_id}' and cart_status=1 ";
                            $result1=mysqli_query($dbc,$query1);
                            while($row1=mysqli_fetch_array($result1,MYSQLI_ASSOC)){   
                            ?>
                            <p class="text-muted">You currently have <?php echo "{$row1['cartCount']}";?> item(s) in your cart.</p> 
                            
                                <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th> </th>
                                            <th>PRODUCT</th>
                                            <th>QUANTITY</th>
                                            <th>UNIT PRICE</th>
                                            <th colspan="2">SUBTOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $total=0;
                                      $query="SELECT p.image, p.prod_name,sum(I.quantity),SUM(P.prod_price),p.prod_price FROM inventory I JOIN products P on I.prod_id=P.prod_id WHERE I.event_id in (select event_id from cart where account_id ='{$user_id}' AND cart_status=1)  group by I.prod_id,I.quantity";
                                      $result=mysqli_query($dbc,$query);
                                      while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                                      ?>

                                        <tr>
                                            <td>
                                                <a href="#">
                                                   <img src="<?php echo"{$row['image']}";?>" >
                                                </a>
                                            </td>
                                            <td><a href="#"><?php echo"{$row['prod_name']}";?></a>
                                            </td>
                                            <td align="center">
                                                <?php echo"{$row['sum(I.quantity)']}";?>
                                            </td >
                                            <td ><?php echo"{$row['prod_price']}";?></td>
                                            
                                            <td align="right"><?php echo"{$row['SUM(P.prod_price)']}";?></td>
                                            <td>

                                            


                                              <form action='remove_cart.php' method='POST'>
                                              <button type='submit' name='remove' value=<?php echo"'{$row['prod_name']}'";?> class='btn btn-primary'><i class="fa fa-trash-o"></i></button>
                                              </form>
                                              </td>
                                              <?php 
                                              if(isset($_POST['remove'])){
                                               header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/remove_cart.php");
                                              }
                                              ?>

                                            </td>
                                        </tr>
                                        <?php  
                                        $price=$row['SUM(P.prod_price)'];
                                        $total=$total+$price;
                                          
                                }

                                         ?>

                                    </tbody>
                                    <tfoot>

                                       <?php 
                                        if (isset($_POST['useCoupon'])){ ?>

                                         <tr>
                                           <th colspan="6"></th>
                                         </tr>
                                          <th colspan="4">Subtotal</th>
                                            
                                            <th>₱ <?php echo"{$total}";?></th>
                                        </tr>
                                         <tr>
                                           <th colspan="6"></th>
                                         </tr>

                                          <th colspan="4">Discount</th>
                                          <th>₱ <?php echo"{$total}";?></th>
                                        </tr>


                                          <tr>
                                           <th colspan="6"></th>
                                         </tr>

                                        <th colspan="4">Total</th>
                                            
                                            <th>₱ <?php echo"{$total}";?></th>
                                             <tr>
                                           <th colspan="6"></th>
                                         </tr>
                                          <?php }else { ?>
                                        <tr>
                                           <th colspan="6"></th>
                                         </tr>
                                          <th colspan="4">Total</th>
                                            
                                            <th>₱ <?php echo"{$total}";?></th>
                                        </tr>

                                       
                                    </tfoot>
                                    <?php } ?>
                                </table>
                                <?php } ?>

                            </div>
                            <!-- /.table-responsive -->

                            <div class="box-footer">
                                <div class="pull-left">
                                    <a href="index.php" class="btn btn-default"><i class="fa fa-chevron-left"></i> Continue shopping</a>
                                </div>
                                <div class="pull-right">
                                  <form action='checkout.php' method='POST'>
                                  <button type='submit' class="btn btn-primary "name='checkout' value='Checkout' align='center'class='btn btn-primary'>Proceed to Checkout<i class="fa fa-chevron-right"></i></button>
                                  </form>
                                   
                                    
                                </div>
                            </div>
                          </div>
                        </div>

                      

                     


                     <div class="col-md-3">

                     <div class="box">
                        <div class="box-header">
                            <h4 align="center">Coupon Code</h4>
                        </div>
                        <p class="text-muted">
                          <p align='center'>If you have a coupon code, please enter it in the box below.</p>
                        
                          <?php
                          if (isset($_POST['couponButton'])){
                            if(empty($_POST['checkCoupon'])){
                              $couponCode=FALSE;
                              $valid=0;
                              $message="Please try again!";
                              echo "<p align = 'center'> <font color ='red'>" . $message. "</font> </p>";
                              }else{
                              $couponCode=$_POST['checkCoupon'];

                              $query="SELECT * FROM coupon  WHERE coupon_code='{$couponCode}' and (account_id='{$_SESSION['acc_id']}' or account_id='NULL') and coupon_status='1' ";
                              $result=mysqli_query($dbc,$query); 
                              if (!mysqli_num_rows($result)==0) {
                              while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                                
                                 echo "<p align='center'> <font color='green'>  Coupon is Valid! </font> </p>";
                                 $valid=1;


                                  }
                                  }else{
                                    $valid=0;

                                  echo "<p align='center'> <font color='red'>  Coupon is Invalid! </font> </p>";
                                  }
                                }
                              }

                              if (isset($_POST['useCoupon'])){

                                echo "<p align='center'> <font color='green'>"  .$_POST['checkCoupon']. " USED! </font> </p>";

                              }

                              if(isset($_POST['useCoupon'])){
                               $_SESSION['finalCoupon']=$_POST['checkCoupon'];

                                  $queryCoupon="SELECT prod_id from coupon where prod_id='{$_SESSION['finalCoupon']}'";
                                            $resultCoupon=mysqli_query($dbc,$queryCoupon);
                                            while($rowCoupon=mysqli_fetch_array($resultCoupon,MYSQLI_ASSOC)){

                                              $queryFind="SELECT p.image, p.prod_name,sum(I.quantity),SUM(P.prod_price),p.prod_price FROM inventory I JOIN products P on I.prod_id=P.prod_id WHERE I.event_id in (select event_id from cart where account_id ='{$user_id}' AND cart_status=1)  group by I.prod_id,I.quantity where P.prod_id = '{$rowCoupon['prod_id']}' ";
                                              $resultFind=mysqli_query($dbc,$queryFind);
                                              while($rowFind=mysqli_fetch_array($resultFind,MYSQLI_ASSOC)){
                                                echo "{$rowFind['prod_id']}";

                                                if (!mysqli_num_rows($resultFind)==0) {

                                                   echo "<p align = 'center'> <font color ='red'>" . "Item is not in your cart!". "</font> </p>";

                                            
                                        }else{
                                           echo "<p align='center'> <font color='green'>"  .$_SESSION['finalCoupon']. " USED!</font> </p>";

                                        }
                                      }
                                    }
                                  }
                                 




                               

                              
                           

                                         
                  
                          ?>
                         <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="input-group">

                                <input type="text" value='<?php if(isset($_POST['couponButton'])){echo "{$_POST['checkCoupon']}";}?>' name='checkCoupon'class="form-control">

                                <span class="input-group-btn">

                                <button type='submit' name='couponButton' class="btn btn-primary" type="button"><i class="fa fa-gift"></i></button>

                                  </span>

                            </div>
                            <br>
                            
                            <?php
                            if(isset($_POST['couponButton'])){
                              if($valid==1){


                                ?>



                             <div class="input-group">

                             

                                <span class="input-group-btn">

                                <button type='submit' align='right' name='useCoupon' class="btn btn-primary" type="button">Use Coupon<i class="fa fa-default"></i></button>

                                  </span>

                            </div>
                                    <?php
                                  }

                                }
                                  
                                    ?>
                            <br>


                            

                            <!-- /input-group -->
                        </form>

                    </div>

                  </div>


                </div>
              </div>
            </div>
          </div>
          </div>
    
      
                      
                      
                    <!-- /.box -->

                    


<?php
require_once('footer.php');
?>
</body>


</html>
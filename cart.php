
<?php

require_once('../db_connect.php');
require_once('nanbarCarlos.php');
?>
<div id="all">

        <div id="content">
            <div class="container">


<?php
$username=$_SESSION['username'];
?>

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
                            $query1="SELECT count(event_id) AS cartCount FROM cart WHERE account_id='{$user_id}' and cart_status='1' ";
                            $result1=mysqli_query($dbc,$query1);
                            while($row1=mysqli_fetch_array($result1,MYSQLI_ASSOC)){   
                            ?>
                            <p class="text-muted">You currently have <?php echo "{$row1['cartCount']}";?> item(s) in your cart.</p> 
                            
                                <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                         
                                            <th colspan="2">PRODUCT</th>
                                            <th>QUANTITY</th>
                                            <th>UNIT PRICE</th>
                                            <th colspan="2">SUBTOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $total=0;
                                      $query="SELECT p.image, p.prod_name,sum(I.quantity),SUM(P.prod_price) FROM inventory I JOIN products P on I.prod_id=P.prod_id WHERE I.event_id in (select event_id from cart where account_id ='{$user_id}' AND cart_status=1)  group by I.prod_id,I.quantity";
                                      $result=mysqli_query($dbc,$query);
                                      while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                                      ?>

                                        <tr>
                                            <td>
                                                <a href="#">
                                                   <img src="<?php echo"{$row['image']}";?>"  alt="White Blouse Armani">
                                                </a>
                                            </td>
                                            <td><a href="#"><?php echo"{$row['prod_name']}";?></a>
                                            </td>
                                            <td>
                                                <?php echo"{$row['sum(I.quantity)']}";?>
                                            </td>
                                            <td>*unitprice*</td>
                                            
                                            <td><?php echo"{$row['SUM(P.prod_price)']}";?></td>
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
                                        <tr>
                                           <th colspan="6"></th>
                                         </tr>
                                          <th colspan="4">Total</th>
                                            
                                            <th>₱ <?php echo"{$total}";?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <?php } ?>

                            </div>
                            <!-- /.table-responsive -->

                            <div class="box-footer">
                                <div class="pull-left">
                                    <a href="category.html" class="btn btn-default"><i class="fa fa-chevron-left"></i> Continue shopping</a>
                                </div>
                                <div class="pull-right">
                                  <form action='checkout.php' method='POST'>
                                  <button type='submit' class="btn btn-primary "name='checkout' value='Checkout' align='right'class='btn btn-primary'>Proceed to Checkout<i class="fa fa-chevron-right"></i></button>
                                  </form>
                                   
                                    
                                </div>
                            </div>
                          </div>
                        </div>

                     


                     <div class="col-md-3">

                     <div class="box">
                        <div class="box-header">
                            <h4>Coupon code</h4>
                        </div>
                        <p class="text-muted">If you have a coupon code, please enter it in the box below.</p>
                        <form>
                            <div class="input-group">

                                <input type="text" class="form-control">

                                <span class="input-group-btn">

          <button class="btn btn-primary" type="button"><i class="fa fa-gift"></i></button>

            </span>
                            </div>
                            <!-- /input-group -->
                        </form>
                    </div>
                  </div>

                  </div>
                </div>
                    <!-- /.box -->

                    


<?php
require_once('footer.php');
?>
</body>
</div>

</html>
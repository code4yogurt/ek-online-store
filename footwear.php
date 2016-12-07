
<?php

session_start();
require_once('../db_connect.php');
require_once('navbar.php');
?>
 <div id="all">

        <div id="content">
            <div class="container">


<?php
require_once('/filter.php')
?>
<div class="col-md-9">
                    <div class="box">
                        <h1>Footwear</h1>
                        <p>All the slippers, shoes, and sandals from Enchanted Kingdom!</p>
                    </div>

                    <div class="box info-bar">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 products-showing">
                               
                            </div>

                            
                            </div>
                        </div>
                    </div>

                    <div class="row products">
<?php

$query="select count(prod_id) as count from products where status=1 AND subcategory='footwear'";
                                                    $result=mysqli_query($dbc,$query);
                                                    $row=mysqli_fetch_array($result, MYSQLI_ASSOC);
                                                    $pages=$row['count'] / 10;
                                                    $page_no=ceil($pages);
                                                    $start=0;
                                                    if(isset($_GET['go'])){
                                                      $pn=$_GET['dropdown'];
                                                    $start=($_GET['dropdown']-1)*10;
                                                    }
                                                    else{
                                                    $pn=1;
                                                    }

                                                                          echo "<h4 align='right'>Page: {$pn}  </h4>";

$_SESSION['checkout']=0;




$query="select * from products where status=1 AND subcategory='footwear' LIMIT $start,10";
$result=mysqli_query($dbc,$query);



while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
?>

 <div class="col-md-4 col-sm-6">
                            <div class="product">
                                
                                
                                    <img src="<?php echo"{$row['image']}";?>" alt="" class="img-responsive">
                                </a>
                                <div class="text">
                                    
                                   
                
                                    <form action="specificItem.php" method="GET">
                                        <p class="buttons">
                                        <input type='submit'  class="btn btn-primary" name="submit"value="<?php echo"{$row['prod_name']}";?>">
                                    </form>
                                    </p>
                                     <p class="price">₱<?php echo "{$row['prod_price']}";?></p>
                                </div>
                                <!-- /.text -->
                            </div>
                            <!-- /.product -->

                        </div>
                        <?php } ?>
                        </div>
                        <!-- /.col-md-4 -->
                    </div>

<?php




?>
<?php
if(isset($_GET['submit'])){
 header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/specificitem.php");

}

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




                </div>
                <!-- /.col-md-9 -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->


<?php
require_once('footer.php');
?>
</body>

</html>


<!DOCTYPE html>
<html lang="en">


<?php
require_once("navbar.php");
?>




    <div id="all">

        <div id="content">
            <div class="container">
                        <?php
                        require_once("filter.php");
                        ?>

                        <?php
                        $item=$_GET['submit'];
                        $ip= $_SERVER['REMOTE_ADDR'];
                        $query="select status from products where prod_name='$item'";
                        $result=mysqli_query($dbc,$query);
                        while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                        $status= $row['status'];
                        }

                        if($status!=1){
                        header("Location: http://".$_SERVER['HTTP_HOST']. dirname($_SERVER['PHP_SELF'])."/index.php");
                        }
                        else
                        
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
                                
                                <p class="price"><?php echo "{$row['prod_price']}";?></p>

                                <p class="text-center buttons">
                                    <a href="basket.html" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Add to cart</a> 
                                    <a href="basket.html" class="btn btn-default"><i class="fa fa-heart"></i> Add to wishlist</a>
                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="box" id="details">
                        <p>
                            <h4>Product details</h4>
                            <p><?php echo "{$row['prod_desc']}";?>
                        </p>
                            
                    </div>

                

                </div>

                <!-- /.col-md-9 -->
            </div>
            <?php } ?>
            <!-- /.container -->
            
        </div>

            
        <!-- /#content -->
<?php
require_once("footer.php");
?>





</body>

</html>
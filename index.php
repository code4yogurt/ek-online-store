<!DOCTYPE html>
<html lang="en">

<?php

require_once('navbar.php');
?>




    <div id="all">

        <div id="content">

            <div class="container">
                
            </div>

            

            <!-- *** HOT PRODUCT SLIDESHOW ***
 _________________________________________________________ -->
            <div id="hot">

                <div class="box">
                    <div class="container">
                        <div class="col-md-12">
                            <h2>Featured Products</h2>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="product-slider">
                        <?php
                        $query='select * from products';
                        $result=mysqli_query($dbc,$query);
                        while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                        ?>

                        <div class="item">
                            <div class="product">
                                <a href="detail.html">
                                    <img src="<?php echo"{$row['image']}";?>" alt="" class="img-responsive">
                                </a>
                                <div class="text">
                                    <h3><a href="detail.html"><?php echo "{$row['prod_name']}";?></a></h3>
                                    <p class="price"><?php echo "{$row['prod_price']}";?></p>
                                </div>
                                <!-- /.text -->
                            </div>
                            <!-- /.product -->
                        </div>
                        <?php } ?>

                    </div>
                    <!-- /.product-slider -->
                </div>
                <!-- /.container -->

                

                

            </div>
            <!-- /#hot -->

            <!-- *** HOT END *** -->

           


        </div>
        <!-- /#content -->
<?php
require_once('footer.php');
?>

</body>

</html>
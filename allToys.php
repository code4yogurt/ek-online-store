<!DOCTYPE html>
<html lang="en">

<?php
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
                        <h1>Toys</h1>
                        <p>...</p>
                    </div>

                    <div class="box info-bar">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 products-showing">
                                Showing <strong>12</strong> of <strong>25</strong> products
                            </div>

                            <div class="col-sm-12 col-md-8  products-number-sort">
                                <div class="row">
                                    <form class="form-inline">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="products-number">
                                                <strong>Show</strong>  <a href="#" class="btn btn-default btn-sm btn-primary">12</a>  <a href="#" class="btn btn-default btn-sm">24</a>  <a href="#" class="btn btn-default btn-sm">All</a> products
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="products-sort-by">
                                                <strong>Sort by</strong>
                                                <select name="sort-by" class="form-control">
                                                    <option>Price</option>
                                                    <option>Name</option>
                                                    <option>Sales first</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row products">
                        <?php
                        $query='select * from products where status=1 and category="toys"';
                        $result=mysqli_query($dbc,$query);
                        while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                        ?>

                        <div class="col-md-4 col-sm-6">
                            <div class="product">
                                
                                
                                    <img src="<?php echo"{$row['image']}";?>" alt="" class="img-responsive">
                                
                                <div class="text">
                                    
                                    
                
                                    <form action="specificItem.php" method="GET">
                                        <p class="buttons">
                                        <input type='submit'  class="btn btn-primary" name="submit"value="<?php echo"{$row['prod_name']}";?>">
                                    </form>
                                    </p>

                                    <p class="price"><?php echo "{$row['prod_price']}";?></p>
                                </div>
                                <!-- /.text -->
                            </div>
                            <!-- /.product -->

                        </div>
                        <?php } ?>
                        </div>
                        <!-- /.col-md-4 -->
                    </div>
                    <!-- /.products -->

                    <?php
                    if(isset($_GET['submit'])){
                    header("Location: http://".$_SERVER['HTTP_HOST']. dirname($_SERVER['PHP_SELF'])."/specificitem.php");
                    }
                    ?>
                    <div class="pages">

                        <p class="loadMore">
                            <a href="#" class="btn btn-primary btn-lg"><i class="fa fa-chevron-down"></i> Load more</a>
                        </p>

                        <ul class="pagination">
                            <li><a href="#">&laquo;</a>
                            </li>
                            <li class="active"><a href="#">1</a>
                            </li>
                            <li><a href="#">2</a>
                            </li>
                            <li><a href="#">3</a>
                            </li>
                            <li><a href="#">4</a>
                            </li>
                            <li><a href="#">5</a>
                            </li>
                            <li><a href="#">&raquo;</a>
                            </li>
                        </ul>
                    </div>


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
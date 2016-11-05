<!DOCTYPE html>
<html lang="en">

<body>

              <div class="col-lg-3">

                    <?php
                    
                    $query='select count(category) as apparelCount from products where category="apparel"';
                    $result=mysqli_query($dbc,$query);
                    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

                    $query1='select count(category) as drinkwareCount from products where category="drinkware"';
                    $result1=mysqli_query($dbc,$query1);
                    while($row1=mysqli_fetch_array($result1,MYSQLI_ASSOC)){

                    $query2='select count(category) as toysCount from products where category="toys"';
                    $result2=mysqli_query($dbc,$query2);
                    while($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){

                    $query3='select count(category) as accessoriesCount from products where category="accessories"';
                    $result3=mysqli_query($dbc,$query3);
                    while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC)){

                    ?>



                    <!-- *** MENUS AND FILTERS ***
 _________________________________________________________ -->
                    <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <h3 class="panel-title">Categories</h3>
                        </div>

                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked category-menu">
                                    <li class=''>
                                    <a href="apparel.php">Apparel <span class="badge pull-right"><?php echo "{$row['apparelCount']}";?></span></a>
                                    <ul>
                                        <li><a href="shirts.php">Shirts</a>
                                        </li>
                                        <li><a href="shorts.php">Shorts</a>
                                        </li>
                                        <li><a href="hoodies.php">Hoodies</a>
                                        </li>
                                        <li><a href="footwear.php">Footwear</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                   
                                    <a href="drinkware.php">DrinkWare  <span class="badge pull-right"><?php echo "{$row1['drinkwareCount']}";?></span></a>
                                    <ul>
                                        <li><a href="mugs.php">Mugs</a>
                                        </li>
                                        <li><a href="tumblers.php">Tumblers</a>
                                        </li>
                                        <li><a href="shotglasses.php">Shotglasses</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="toys.php">Toys <span class="badge pull-right"><?php echo "{$row2['toysCount']}";?></span></a>
                                    <ul>
                                        <li><a href="plushies.php">Plushies</a>
                                        </li>
                                        <li><a href="pillows.php">Pillows</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="accessories.php">Accessories <span class="badge pull-right"><?php echo "{$row3['accessoriesCount']}";?></span></a>
                                    <ul>
                                        <li><a href="bracelets.php">Bracelets</a>
                                        </li>
                                        <li><a href="pendants.php">Pendants</a>
                                        </li>
                                        <li><a href="magnets.php">Magnets</a>
                                        </li>
                                        <li><a href="keychains.php">Keychains</a>
                                        </li>
                                    </ul>
                                </li>

                            </ul>

                        </div>
                    </div>
                    <?php 
                                }
                           }
                        }
                    }
                        

                     ?>

                    <!-- *** MENUS AND FILTERS END *** -->

                    
                </div>

  </body>
  </html>
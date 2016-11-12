<?php
session_start();

require_once('/connect.php');
require_once('/navbar.php');

?>

    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">

                    <ul class="breadcrumb">
                        <li><a href="/index.php">Home</a>
                        </li>
                        <li>Order Status</li>
                    </ul>

                </div>

                <div class="col-md-12" id="customer-orders">
                    <div class="box">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Item #</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php

                                        $specific_order = $_GET['specific-order'];

                                        $specorderdetails_query="select C.event_id, C.date, P.prod_name, P.prod_price
                                                                 from inventory I join products P
                                                                                  on I.prod_id = P.prod_id
                                                                                  join cart c
                                                                                  on I.event_id = C.event_id
                                                                 where C.cart_id = {$specific_order}";

                                        $specorderdetails_result=mysqli_query($dbc, $specorderdetails_query);
                                        $specorderdetails_row=mysqli_fetch_array($specorderdetails_result, MYSQLI_ASSOC);

                                        while($specorderdetails_row){
                                            echo "<tr>";
                                            echo "<td>".$specorderdetails_row['event_id']."</td>";
                                            echo "<td>".$specorderdetails_row['date']."</td>";
                                            echo "<td>".$specorderdetails_row['prod_name']."</td>";
                                            echo "<td>".$specorderdetails_row['prod_price']."</td>";
                                            echo "</tr>";

                                            $specorderdetails_row=mysqli_fetch_array($specorderdetails_result, MYSQLI_ASSOC);
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->

<?php

require_once('/footer.php');

?>

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
                        <h1>My orders</h1>

                        <p class="lead">Your orders on one place.</p>
                        <p class="text-muted">If you have any questions, please feel free to <a href="contact.html">contact us</a>, our customer service center is working for you 24/7.</p>

                        <hr>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                        $orderstats_query="select receipt_id, transaction_date 
                                                           from official_receipt
                                                           order by receipt_id";
                                        $or_result=@mysqli_query($dbc, $orderstats_query);
                                        $or_row =mysqli_fetch_array($or_result, MYSQLI_ASSOC);

                                        $price_query="select sum(P.prod_price) pricesum
                                                      from inventory I join products P
                                                      on I.prod_code = P.prod_code
                                                      where I.event_id in (select C.event_id
                                                                           from cart C
                                                                           where C.receipt_id in (select receipt_id
                                                                                                  from official_receipt
                                                                                                  where account_id=".$_SESSION['acc_id']."))";
                                        $price_result=mysqli_query($dbc, $price_query);
                                        $price_row=mysqli_fetch_array($price_result, MYSQLI_ASSOC);

                                        while($or_row && $price_row){

                                            echo "<th>".$or_row['receipt_id']."</th>";
                                            echo "<td>".$or_row['transaction_date']."</td>";
                                            echo "<td>".$price_row['pricesum']."</td>";
                                            echo "<td> To be continued </td>";

                                            $or_row =mysqli_fetch_array($or_result, MYSQLI_ASSOC);
                                            $price_row=mysqli_fetch_array($price_result, MYSQLI_ASSOC);
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

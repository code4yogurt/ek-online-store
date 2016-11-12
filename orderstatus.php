<?php
session_start();

require_once('/connect.php');
require_once('/navbar.php');

?>

<div id="all">
    <div id="content">
        <div class="container">

            <?php 

                if(isset($_POST['rcvorder'])){

                    echo "{$_POST['rcvorder']}";

                    $userrcv_query = "update cart
                                      set cart_activity = 4
                                      where cart_id = {$_POST['rcvorder']}";
                    $userrcv_report = mysqli_query($dbc, $userrcv_query);
                }
            ?>

            <div class="col-md-12">

                <ul class="breadcrumb">
                    <li><a href="/index.php">Home</a></li>
                    <li>Order Status</li>
                </ul>

            </div>

            <div class="col-md-12" id="customer-orders">
                <div class="box">
                    <h1>Order List</h1>

                    <p class="lead">Your orders on one place.</p>
                    <p class="text-muted">If you have any questions, please feel free to <a href="contact.html">contact us</a>, our customer service center is working for you 24/7.</p>

                    <hr>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order Number</th>
                                    <th>Date</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                    $orderstatus_query="select C.cart_id, C.date, C.cart_activity, SUM(P.prod_price) as total_price
                                                        from inventory I join products P
                                                                         on I.prod_id = P.prod_id
                                                                         join cart C
                                                                         on I.event_id = C.event_id
                                                                         where I.account_id = {$_SESSION['acc_id']}
                                                                         group by C.cart_id";

                                    $orderstatus_result=mysqli_query($dbc, $orderstatus_query);
                                    $orderstatus_row=mysqli_fetch_array($orderstatus_result, MYSQLI_ASSOC);

                                    while($orderstatus_row){
                                        echo "<tr>";
                                        echo "<td>".$orderstatus_row['cart_id']."</td>";
                                        echo "<td>".$orderstatus_row['date']."</td>";
                                        echo "<td>".$orderstatus_row['total_price']."</td>";

                                        if($orderstatus_row['cart_activity'] == 0){
                                            echo "<td><span class='label label-default'>Unpaid</label></td>";
                                        }
                                        else if($orderstatus_row['cart_activity'] == 1){
                                            echo "<td><span class='label label-danger'>Pending</label></td>";
                                        }
                                        else if($orderstatus_row['cart_activity'] == 2){
                                            echo "<td><span class='label label-warning'>Not Delivered</label></td>";
                                        }
                                        else if($orderstatus_row['cart_activity'] == 3){
                                            echo "<td><span class='label label-info'>Delivered</label></td>";
                                        }
                                        else if($orderstatus_row['cart_activity'] == 4){
                                            echo "<td><span class='label label-success'>Received</label></td>";
                                        }
                                        echo "<td> 
                                                <form action='specificorderdetails.php' method='get'>
                                                    <button class='btn btn-default btn-xs' name='specific-order' value='".$orderstatus_row['cart_id']."'>View</button>
                                                </form>
                                              </td>";

                                              //copy for modal conversion data-toggle='modal' data-value='".$orderstatus_row['cart_id']."' id='receiptNum' data-target='#confirmModal'
                                        if($orderstatus_row['cart_activity'] == 3){
                                            echo "<td>
                                                    <form action='orderstatus.php' method='post'>
                                                        <button class='btn btn-default btn-xs' name='rcvorder' value='".$orderstatus_row['cart_id']."'>Receive Order</button>
                                                    </form>
                                                  </td>";    
                                        }
                                        else if($orderstatus_row['cart_activity'] == 4){
                                            echo "<td><button type='button' class='btn btn-default btn-xs' data-toggle='modal' data-value='".$orderstatus_row['cart_id']."' id='receiptNum' data-target='#confirmModal' disabled>Received!</button></td>";
                                        }
                                        else{
                                            echo "<td><button type='button' class='btn btn-default btn-xs' data-toggle='modal' data-value='".$orderstatus_row['cart_id']."' id='receiptNum' data-target='#confirmModal' disabled>Recieve Order</button></td>";
                                        }
                                        echo "</tr>";

                                        $orderstatus_row=mysqli_fetch_array($orderstatus_result, MYSQLI_ASSOC);
                                    }
                                ?>
                            </tbody>
                        </table>
                        <!-- modal for confirmation when order is received -->
                        <div id="confirmModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h3 class="modal-title">Thank you!</h3>
                                    </div>
                                    <div class="modal-body">
                                        <p> INSERT COMMENT HERE THEN SUBMIT OR RATING</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="receiveorder.php" method="post">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </form>
                                        </div>
                                </div>
                            </div>
                        </div>


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

<script>

    $(document).ready(function() {
        $("#receiptNum").on("click", function() {
            console.log($(this).data("value"));
            $("#orderNum").attr("value", $(this).data("value"));
        });
    });

</script>

<?php
session_start();

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
                                        <th>Order Number</th>
                                        <th>Date</th>
                                        <th>Total Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                        $orderstatus_query="select O.receipt_id, O.transaction_date, SUM(P.prod_price) as total_price 
                                                            from inventory I join products P
                                                                             on I.prod_code = P.prod_code
                                                                             join official_receipt O
                                                                             on I.account_id = O.account_id
                                                                             where I.event_id in (select event_id
                                                                                                  from cart 
                                                                                                  where account_id={$_SESSION['acc_id']})";

                                        $orderstatus_result=mysqli_query($dbc, $orderstatus_query);
                                        $orderstatus_row=mysqli_fetch_array($orderstatus_result, MYSQLI_ASSOC);

                                        while($orderstatus_row){
                                            echo "<tr>";
                                            echo "<td>".$orderstatus_row['receipt_id']."</td>";
                                            echo "<td>".$orderstatus_row['transaction_date']."</td>";
                                            echo "<td>".$orderstatus_row['total_price']."</td>";
                                            echo "<td>
                                                    <form action='specificorderdetails.php' method='get'>
                                                        <button class='btn btn-default btn-xs' name='specific-order' value='".$orderstatus_row['receipt_id']."'>View</button>
                                                    </form>
                                                  </td>";
                                            echo "<td>  
                                                    <button type='button' class='btn btn-default btn-xs' data-toggle='modal' data-value='".$orderstatus_row['receipt_id']."' id='receiptNum' data-target='#confirmModal'>Received orders </button>
                                                  </td>";
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
                                            <h3 class="modal-title">Thank you for buying from Enchanted Kingdom!</h3>
                                        </div>
                                        <div class="modal-body">
                                            <form action="comment.php" method="post">
                                                <div class="form-group">
                                                    <label for="comment">Comment:</label>
                                                    <textarea class="form-control" rows="4" name="content" id="comment"></textarea>
                                                </div>
                                            </form
                                        </div>
                                        <div class="modal-footer">
                                            <form action="receiveorder.php" method="post">
                                                <input type="hidden" id="orderNum" name="receiptnumber"/>
                                                <button type="submit" class="btn btn-default" name="sumbit">Submit</button>
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

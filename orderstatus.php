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
                    $userrcv_query = "update cart
                                      set cart_activity = 4
                                      where cart_id = {$_POST['rcvorder']}";
                    $userrcv_report = mysqli_query($dbc, $userrcv_query); 
                }

                if(isset($_POST['finishsurvey'])){
                    $getqans_query = "select Q.question_id
                                      from questionnaire QN join question Q
                                                            on QN.questionnaire_id = Q.questionnaire_id
                                      where QN.question_name='onRcv'";
                    $getqans_result = mysqli_query($dbc, $getqans_query);

                    while($getqans_row=mysqli_fetch_array($getqans_result, MYSQLI_ASSOC)){

                        $questionans = $_POST["q{$getqans_row['question_id']}ans"];

                        $recordans_query = "insert into questionnaire_ans (answer_id, question_id, account_id)
                                            values ('{$questionans}', '{$getqans_row['question_id']}', '{$_SESSION['acc_id']}')";
                        $recordans_result = mysqli_query($dbc, $recordans_query);
                    }
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

                    <h3>See the status of your orders here, and be able to receive when your orders have been delivered!</h3>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <?php

                                $orderstatus_query="select C.cart_id, C.date, C.cart_activity, SUM(P.prod_price) as total_price
                                                    from inventory I join products P
                                                                     on I.prod_id = P.prod_id
                                                                     join cart C
                                                                     on I.event_id = C.event_id
                                                    where I.account_id = {$_SESSION['acc_id']}
                                                    group by C.cart_id";
                                $orderstatus_result=mysqli_query($dbc, $orderstatus_query);

                                if(!mysqli_num_rows($orderstatus_result)==0){

                                    echo "<thead>
                                            <tr>
                                                <th>Order Number</th>
                                                <th>Date</th>
                                                <th>Total Price</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>";
                            
                                    $orderstatus_row=mysqli_fetch_array($orderstatus_result, MYSQLI_ASSOC);

                                    while($orderstatus_row){

                                        echo "<tr>";
                                        echo "<td><strong>#".$orderstatus_row['cart_id']."</strong> </td>";
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
                                            echo "<td><button type='button' class='btn btn-default btn-xs' disabled>Received!</button></td>";
                                        }
                                        else{
                                            echo "<td><button type='button' class='btn btn-default btn-xs' disabled>Recieve Order</button></td>";
                                        }
                                        echo "</tr>";

                                        $orderstatus_row=mysqli_fetch_array($orderstatus_result, MYSQLI_ASSOC);
                                    }

                                    echo "</tbody>";
                                }
                                else{
                                    echo "<p class='lead'> It seems you have no orders yet. Look through our items and order now! </p>";
                                } 
                            ?>
                             
                        </table>

                        <!-- modal asking whether the user wants to answer a survey -->
                        <div class="modal fade" id="surveyOrNah" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3>Thank you for purchasing our product(s)!</h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>Would you kindly answer one of our surveys? This would help us improve our online store!</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <form action="orderstatus.php" method="post">
                                                <div class="col-md-2 col-md-offset-4">
                                                    <button class="btn btn-default" name="survey-yas" id="survey-yas">YAS</button>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">NAH</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /modal asking whether the user wants to answer a survey -->

                        <!-- modal for survey when order is received -->
                        <form action="orderstatus.php" method="post">
                            <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h3 class="modal-title">Thank you!</h3>
                                        </div>
                                        <div class="modal-body">

                                        <?php

                                            $questionnaire_query="select Q.question_id, Q.question_name as question
                                                                  from questionnaire QN join question Q
                                                                                        on QN.questionnaire_id = Q.questionnaire_id
                                                                  where QN.question_name='onRcv'
                                                                  group by Q.question_id";
                                            $questionnaire_result=mysqli_query($dbc, $questionnaire_query);

                                            while($questionnaire_row=mysqli_fetch_array($questionnaire_result, MYSQLI_ASSOC)){
                                        ?>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="question"><strong><?php echo $questionnaire_row['question_id'] ?>. <?php echo $questionnaire_row['question'] ?> </strong></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                            <?php

                                                $answerlist_query="select A.answer_id, A.answer_name as answer
                                                                   from answers A join question Q
                                                                                  on A.question_id = Q.question_id
                                                                   where Q.question_id = {$questionnaire_row['question_id']}";
                                                $answerlist_result=mysqli_query($dbc, $answerlist_query);

                                                while($answerlist_row=mysqli_fetch_array($answerlist_result, MYSQLI_ASSOC)){
                                            ?>
                                                        <div class="radio">
                                                            <label><input type="radio" <?php echo "name='q{$questionnaire_row['question_id']}ans'"; echo "value=".$answerlist_row['answer_id']; ?> ><?php echo $answerlist_row['answer'] ?></label>
                                                        </div>
                                            <?php
                                                }
                                            ?>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php
                                            }
                                        ?> 
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-default" name="finishsurvey" id="finishsurvey">Done</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /answersurvey -->
                        </form>
                        <div class="modal fade" id="surveyremarks" tabindex="-1" role="dialog" aria-labelledby="Issue Response" aria-hidden="true">
                            <div class="modal-dialog mod-xs">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="lead">Thanks for answering!</p>
                                        <p>In return, we sent a coupon through your e-mail.</p>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /Send Confirmation Modal -->
                    </div>
                </div>
            </div>
        </div><!-- /.container -->
    </div><!-- /#content -->
</div>
    

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

<?php
    
    if(isset($_POST['rcvorder'])){
?>

    <script>$('#surveyOrNah').modal('show');</script>

<?php
    }
    
    if(isset($_POST['survey-yas'])){
?>

    <script>$('#confirmModal').modal('show');</script>

<?php
    }

    if(isset($_POST['finishsurvey'])){
?>

    <script>$('#surveyremarks').modal('show');</script>

<?php
    }
?>

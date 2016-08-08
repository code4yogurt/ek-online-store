<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Enchanted Kingdom</title>

  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  <!-- Datatables -->
  <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="../build/css/custom.css" rel="stylesheet">
</head>

<?php
require_once('/header.php');

$tobedelivered = array();
$orderfilter_receipt_query="select * from official_receipt";
$orderfilter_receipt_result=mysqli_query($dbc, $orderfilter_receipt_query);
$orderfilter_receipt_row=mysqli_fetch_array($orderfilter_receipt_result, MYSQLI_ASSOC);

while($orderfilter_receipt_row){

  $orderfilter_order_query="select I.event_id, I.event_status
                            from inventory I join official_receipt O
                                             on I.account_id = O.account_id
                            where I.event_id in (select event_id
                                                 from cart)
                            and O.receipt_id = {$orderfilter_receipt_row['receipt_id']}";
  $orderfilter_order_result=mysqli_query($dbc, $orderfilter_order_query);
  $orderfilter_order_row=mysqli_fetch_array($orderfilter_order_result, MYSQLI_ASSOC);

  while($orderfilter_order_row){

    if($orderfilter_order_row['event_status']==0){

      $unfinishedreceipt=$orderfilter_receipt_row['receipt_id'];
    }

    $orderfilter_order_row=mysqli_fetch_array($orderfilter_order_result, MYSQLI_ASSOC);
  }

  if(isset($unfinishedreceipt)){
    $tobedelivered[] = $unfinishedreceipt;
  }
  
  $orderfilter_receipt_row=mysqli_fetch_array($orderfilter_receipt_result, MYSQLI_ASSOC);
}
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="page-title">
      <div class="title_left">
        <h3>Undelivered Orders List</h3>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">

      <div class="col-md-12 col-sm-12 col-xs-12">


        <div class="x_panel">
          <div class="x_title">
            <h2>Default Example <small>Users</small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Settings 1</a>
                  </li>
                  <li><a href="#">Settings 2</a>
                  </li>
                </ul>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
                    <!-- <p class="text-muted font-13 m-b-30">
                      DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction function: <code>$().DataTable();</code>
                    </p> -->
                    <table id="datatable" class="table table-striped table-bordered">
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
                        require_once('/connect.php');

                        for($i=0; $i<count($tobedelivered); $i++){

                        $shippinglist_query="select O.receipt_id, O.transaction_date, SUM(P.prod_price) as total_price 
                                             from inventory I join products P
                                                              on I.prod_code = P.prod_code
                                                              join official_receipt O
                                                              on I.account_id = O.account_id
                                                              where I.event_id in (select event_id
                                                                                   from cart)
                                                              and O.receipt_id={$tobedelivered[$i]}
                                             group by O.receipt_id
                                             order by O.receipt_id desc";
                        $shippinglist_result=mysqli_query($dbc,$shippinglist_query);

                        while($shippinglist_row=mysqli_fetch_array($shippinglist_result,MYSQLI_ASSOC)){
                         ?>
                         <tr>
                          <td><?php echo "{$shippinglist_row['receipt_id']}";?></td>
                          <td><?php echo "{$shippinglist_row['transaction_date']}";?></td>
                          <td><?php echo "{$shippinglist_row['total_price']}";?></td>
                          <td>
                            <form action="specificorderdetails.php" method="get">
                              <button class="btn btn-default btn-sm" name='specificorder' value="<?php echo "{$shippinglist_row['receipt_id']}";?>">View Order</button>
                            </form>
                          </td>
                          <td>
                            <form action="delivery.php" method="post">
                              <button class="btn btn-default btn-sm" name="deliverorder" value="<?php echo "{$shippinglist_row['receipt_id']}";?>">Deliver Order</button>
                            </form>
                          </td>
                        </tr>
                        <?php } }?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
           Enchanted Kingdom - Bootstrap Admin 
         </div>
         <div class="clearfix"></div>
       </footer>
       <!-- /footer content -->



     </div>



     <!-- jQuery -->
     <script src="../vendors/jquery/dist/jquery.min.js"></script>
     <!-- Bootstrap -->
     <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
     <!-- FastClick -->
     <script src="../vendors/fastclick/lib/fastclick.js"></script>
     <!-- NProgress -->
     <script src="../vendors/nprogress/nprogress.js"></script>
     <!-- Datatables -->
     <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
     <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
     <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
     <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
     <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
     <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
     <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
     <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
     <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
     <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
     <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
     <script src="../vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
     <script src="../vendors/jszip/dist/jszip.min.js"></script>
     <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
     <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>


     <!-- Custom Theme Scripts -->
     <script src="../build/js/custom.min.js"></script>

     <!-- Datatables -->
     <script>
     $(document).ready(function() {
      var handleDataTableButtons = function() {
        if ($("#datatable-buttons").length) {
          $("#datatable-buttons").DataTable({
            dom: "Bfrtip",
            buttons: [
            {
              extend: "copy",
              className: "btn-sm"
            },
            {
              extend: "csv",
              className: "btn-sm"
            },
            {
              extend: "excel",
              className: "btn-sm"
            },
            {
              extend: "pdfHtml5",
              className: "btn-sm"
            },
            {
              extend: "print",
              className: "btn-sm"
            },
            ],
            responsive: true
          });
        }
      };

      TableManageButtons = function() {
        "use strict";
        return {
          init: function() {
            handleDataTableButtons();
          }
        };
      }();

      $('#datatable-keytable').DataTable({
        keys: true
      });

      $('#datatable-responsive').DataTable();

      $('#datatable-scroller').DataTable({
        ajax: "js/datatables/json/scroller-demo.json",
        deferRender: true,
        scrollY: 380,
        scrollCollapse: true,
        scroller: true
      });

      var table = $('#datatable-fixed-header').DataTable({
        fixedHeader: true
      });

      TableManageButtons.init();
    });
</script>
</body>
</html>
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
require_once('/connect.php');
require_once('/header.php');
?>

<!-- page content -->
<div class="right_col" role="main">

	<?php

		$specificuser = $_GET['specific-user'];
		$user_query="select * from accounts where account_id='$specificuser'";
		$user_result=mysqli_query($dbc, $user_query);
		$user_row=mysqli_fetch_array($user_result, MYSQLI_ASSOC);

		while($user_row){
	?>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="col-md-4">
				<h3> <small>Account Number: </small> <?php echo $user_row['account_id']; ?></h3><br>
				<p> Username: <?php echo $user_row['username']; ?> </p><br>
				<p> E-mail Address: <?php echo $user_row['email']; ?></p><br>
				<p> Contact Number: <?php echo $user_row['contact_number']; ?></p>
			</div>
			<div class="col-md-4">
				<br>
				<p> First Name: <?php if($user_row['first_name']){ echo $user_row['first_name']; }
									  else{ echo "-"; } ?> 
				</p>
				<p> Last Name: <?php if($user_row['last_name']){ echo $user_row['last_name']; }
									  else{ echo "-"; } ?>
				</p>
				<p> Birthdate: <?php if($user_row['birthdate']){ echo $user_row['birthdate']; }
									  else{ echo "- / - / -"; } ?>
				</p>
				<p> Address: <?php if($user_row['address']){ echo $user_row['address']; }
									  else{ echo "-"; } ?>
				</p>
			</div>
		</div>
	</div>

	<?php $user_row=mysqli_fetch_array($user_result, MYSQLI_ASSOC); } ?>

	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Purchase History</h2>
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
                  			<th>Product</th>
                  			<th>Price</th>
                  			<th>Status</th>
                  		</tr>
                  	</thead>
                  	
                  	<tbody>
                  		<?php
                  			$userhistory_query="select I. event_id, I.event_date, I.event_status, P.prod_name, P.prod_price
												from inventory I join products P 
												on I.prod_code = P.prod_code 
												where I.event_id in (select C.event_id 
					 												 from cart C
					 												 where C.receipt_id in (select receipt_id
																							from official_receipt
                                            												where account_id='$specificuser'))
																							order by event_id desc";
                  			$userhistory_result=mysqli_query($dbc,$userhistory_query);
                  			$userhistory_row=mysqli_fetch_array($userhistory_result,MYSQLI_ASSOC);

                  			while($userhistory_row){
                  				
                  				echo "<tr>";
                  				echo "<th>".$userhistory_row['event_id']."</th>";
                  				echo "<th>".$userhistory_row['event_date']."</th>";
                  				echo "<th>".$userhistory_row['prod_name']."</th>";
                  				echo "<th>".$userhistory_row['prod_price']."</th>";
                  				echo "<th>";
                                if($userhistory_row['event_status'] == 0){
                                  echo "<span class='label label-warning'>Paid";
                                }
                                else if($userhistory_row['event_status'] == 1){
                                  echo "<span class='label label-info'>Delivered";
                                }
                                else if($userhistory_row['event_status'] == 2){
                                  echo "<span class='label label-success'>Recieved";
                                }
                                echo "</th>";
                  				echo "</tr>";

                  				$userhistory_row=mysqli_fetch_array($userhistory_result,MYSQLI_ASSOC);

                  			}
                  		?>
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
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
	<div class="page-title">
		<div class="title_left">
			<h3>Order List</h3>
		</div>
	</div>

	<div class="clearfix"></div>

	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_title">
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
								<th>Ticket No.</th>
								<th>Date Issued</th>
								<th>Subject</th>
								<th>Name</th>
								<th>E-mail</th>
								<th>Actions</th>
							</tr>
						</thead>

						<tbody>

							<?php

								$complaints_query="select * from complaint";
								$complaints_result=mysqli_query($dbc, $complaints_query);

								while($complaints_row=mysqli_fetch_array($complaints_result, MYSQLI_ASSOC)){

									$name=$complaints_row['complaint_fname']." ".$complaints_row['complaint_lname'];
							?>

							<tr>
								<td><?php echo "{$complaints_row['complaint_id']}" ?></td>
								<td><?php echo "{$complaints_row['complaint_date']}" ?></td>
								<td><?php echo "{$complaints_row['complaint_subject']}" ?></td>
								<td><?php echo "{$name}" ?></td>
								<td><?php echo "{$complaints_row['complaint_email']}" ?></td>
								<td>
									<form action='usercomplaints.php' method='post'>
                            			<button class='btn btn-default btn-xs' data-toggle='modal' name='modalcontent' value='<?php echo $complaints_row['complaint_id']; ?>'>View Issue</button>
                        			</form>
                    			</td>
					  		</tr>

					  		<?php } ?>
						</tbody>
					</table>

					<!-- View Issue Modal -->
					<div class="modal fade" id="viewissue-modal" tabindex="-1" role="dialog" aria-labelledby="View Issue" aria-hidden="true">
						<div class="modal-dialog mod-sm">
							<div class="modal-content">

								<!-- This block is query for modal content -->
								<?php

									$modaldata_query="select * from complaint where complaint_id='{$_POST['modalcontent']}'";
									$modaldata_result=mysqli_query($dbc, $modaldata_query);
									$modaldata_row=mysqli_fetch_array($modaldata_result, MYSQLI_ASSOC);

								?>

								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            						<h4 class="modal-title" id="myModalLabel">Ticket #<?php echo $modaldata_row['complaint_id']; ?></h4>
								</div>

								<div class="modal-body">
									<div class="row">
										<div class="col-md-12">
											<p><strong>Name: </strong><?php echo $modaldata_row['complaint_fname']." ".$modaldata_row['complaint_lname']; ?></p>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<p><strong>E-mail: </strong><?php echo $modaldata_row['complaint_email']; ?></p>
										</div>
									</div>

									<hr>

									<div class="row">
										<div class="col-md-12">
											<p><strong>Subject: </strong><?php echo $modaldata_row['complaint_subject']; ?></p>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<p><strong>Message: </strong><?php echo $modaldata_row['complaint_content']; ?></p>
										</div>
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-dismiss="modal" data-target="#responsemodal">Respond</button>	
									<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div> <!-- /View Issue Modal -->

					<!-- Response Modal-->
					<div class="modal fade" id="responsemodal" tabindex="-1" role="dialog" aria-labelledby="Issue Response" aria-hidden="true">
						<div class="modal-dialog mod-sm">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title" id="myModalLabel">Response</h4>
								</div>

								<form action="#" method="post">
									<div class="modal-body">
										<div class="row">
											<div class="col-md-12">
												<p><strong>Re:<?php echo $modaldata_row['complaint_subject']; ?></strong></p>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<p><strong>Message:</strong></p>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<textarea class="form-control" rows="3" name="response-cont" id="response-cont"></textarea>
												</div>
											</div>
										</div>
									</div>
								

								<div class="modal-footer">
									<button class="btn btn-primary btn-sm" name="sendresponse" id="sendresponse">Send</button>
									<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-dismiss="modal" data-target="#viewissue-modal">Cancel</button>
								</div>

								</form>
							</div>
						</div>
					</div> <!-- /Response Modal -->

					<!-- Send Confirmation Modal -->
					<div>
						<div class="modal fade" id="sendconfirmation" tabindex="-1" role="dialog" aria-labelledby="Issue Response" aria-hidden="true">
							<div class="modal-dialog mod-sm">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									</div>
									<div class="modal-body">
										<p class="lead">E-mail has been sent!</p>
									</div>
								</div>
							</div>
						</div>
					</div> <!-- /Send Confirmation Modal -->
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

<?php
	if(isset($_POST['modalcontent'])){
?>

	<script>$('#viewissue-modal').modal('show');</script>

<?php
	}

	if(isset($_POST['sendresponse'])){

?>

	<script>$('#sendconfirmation').modal('show');</script>

<?php
	}
?>


</body>
</html>

<!-- show modal $('#viewissue-modal').modal('show'); -->
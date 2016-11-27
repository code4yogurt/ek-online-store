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

<div class="right_col" role="main">
	<div class="page-title">
		<div class="title_left">
			<h3>Manage Questionnaires</h3>
		</div>
	</div>

	<div class="clearfix"></div>

	<?php

		$questionnaire_query="select * from questionnaire"
	?>
	<div class="row">
		<!-- NUMERO UNO QUESTIONNAIRE start -->
		<div class="col-md-6">
			<div class="x_panel">
				<div class="x_title">
					<h2><i class="fa fa-align-left"></i> Questionnaire NUMERO UNO Bitch </h2>

					<!-- Toolbar (e.g. settings, close panel, etc.) -->
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#">Settings 1</a></li>
								<li><a href="#">Settings 2</a></li>
							</ul>
						</li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>

					<div class="clearfix"></div>
				</div>

				<div class="content">
					<div class="accordion" id="questionnaire1" role="tablist" aria-multiselectable="true">
						<!-- Start of questions -->
						<div class="panel"> 
							<!-- Panel heading -->
							<!-- TAKE NOTE: data-parents are the questionnaires; href is what panel it collapses; be sure that the ids match -->
							<a class="panel-heading" role="tab" id="q1-1" data-toggle="collapse" data-parent="#questionnaire1" href="#collapseq1-1" aria-expanded="true" aria-controls="collapseq1-1">
								<h4 class="panel-title">Are u cool?</h4>
								
							</a>
							<div class="panel-collapse collapse" id="collapseq1-1" role="tabpanel" aria-laballedby="q1-1">
								<div class="panel-body">
									<table class="table">
										<thead>
											<tr>
												<th>Answers</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Nah</td>	
											</tr>
											<tr>
												<td>Yas</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div><!-- /question -->
						<!-- Start of questions -->
						<div class="panel"> 
							<!-- Panel heading -->
							<!-- TAKE NOTE: data-parents are the questionnaires; href is what panel it collapses; be sure that the ids match -->
							<a class="panel-heading" role="tab" id="q2-1" data-toggle="collapse" data-parent="#questionnaire1" href="#collapseq2-1" aria-expanded="false" aria-controls="collapseq2-1">
								<h4 class="panel-title">Have u gone to EK befo</h4>
							</a>
							<div class="panel-collapse collapse" id="collapseq2-1" role="tabpanel" aria-laballedby="q2-1">
								<div class="panel-body">
									<table class="table">
										<thead>
											<tr>
												<th>Answers</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Nah</td>
											</tr>
											<tr>
												<td>Yas</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div><!-- /question -->
						<!-- Start of questions -->
						<div class="panel"> 
							<!-- Panel heading -->
							<!-- TAKE NOTE: data-parents are the questionnaires; href is what panel it collapses; be sure that the ids match --> 
							<a class="panel-heading" role="tab" id="q3-1" data-toggle="collapse" data-parent="#questionnaire1" href="#collapseq3-1" aria-expanded="false" aria-controls="collapseq3-1">
								<h4 class="panel-title">Are u a moody teen</h4>
							</a>
							<div class="panel-collapse collapse" id="collapseq3-1" role="tabpanel" aria-laballedby="q3-1">
								<div class="panel-body">
									<table class="table">
										<thead>
											<tr>
												<th>Answers</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Nah</td>
											</tr>
											<tr>
												<td>Yas</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div><!-- /question -->
					</div> <!-- /accordion -->
				</div>
			</div>
		</div> <!-- NUMERO UNO QUESTIONNAIRE end -->
		<!-- NUMERO DOS QUESTIONNAIRE -->
		<div class="col-md-6">
			<div class="x_panel">
				<div class="x_title">
					<h2><i class="fa fa-align-left"></i> Questionnaire NUMERO DOS Bitch </h2>

					<!-- Toolbar (e.g. settings, close panel, etc.) -->
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#">Settings 1</a></li>
								<li><a href="#">Settings 2</a></li>
							</ul>
						</li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="content">
					<div class="accordion" id="questionnaire2" role="tablist" aria-multiselectable="true">

						<!-- Start of questions -->
						<div class="panel">
							<a class="panel-heading" role="tab" id="q1-2" data-toggle="collapse" data-parent="#questionnaire2" href="#collapseq1-2" aria-expanded="true" aria-controls="collapseq1-2">
								<h4 class="panel-title">How are u m8?</h4>
							</a>

							<div class="panel-collapse collapse" id="collapseq1-2" role="tabpanel" aria-laballedby="q1-2">
								<div class="panel-body">
									<table class="table">
										<thead>
											<tr>
												<th>Answers</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Real Gud</td>
											</tr>
											<tr>
												<td>Gud</td>
											</tr>
											<tr>
												<td>Not so gud</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div><!-- end of a question -->
					</div> <!-- /accordion -->
				</div> 
			</div>
		</div> <!-- NUMERO DOS QUESTIONNAIRE end -->
	</div>
</div> <!-- /page content -->

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



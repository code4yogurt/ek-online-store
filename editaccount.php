<?php

session_start();
require_once('/connect.php');
require_once('/navbar.php');


if(isset($_SESSION['to-edit'])){
	if(isset($_POST['editacc'])){
		$_SESSION['to-edit'] = 1;
	}
	else if(isset($_POST['canceledit'])){
		$_SESSION['to-edit'] = 0;
	}
}
else{
	$_SESSION['to-edit'] = 0;
}

if(isset($_POST['confirmedit'])){

	if(!empty($_POST['new-un'])){
		$editquery="update accounts
					set username='{$_POST['new-un']}'
					where account_id={$_SESSION['acc_id']}";
		$editresult=mysqli_query($dbc, $editquery);
	}
	if(!empty($_POST['new-cn'])){
		$editquery="update accounts
					set contact_number='{$_POST['new-cn']}'
					where account_id={$_SESSION['acc_id']}";
		$editresult=mysqli_query($dbc, $editquery);
	}
	if(!empty($_POST['new-em'])){
		$editquery="update accounts
					set email='{$_POST['new-em']}'
					where account_id={$_SESSION['acc_id']}";
		$editresult=mysqli_query($dbc, $editquery);
	}
	if(!empty($_POST['new-un'])){
		$editquery="update accounts
					set username='{$_POST['new-un']}'
					where account_id={$_SESSION['acc_id']}";
		$editresult=mysqli_query($dbc, $editquery);
	}
	if(!empty($_POST['new-pw']) && !empty($_POST['checknewpw'])){
		if($_POST['new-pw'] == $_POST['checknewpw']){

			$salt = sha1(md5($_POST['new-pw']));
			$newencpw = md5($_POST['new-pw']).$salt;

			$editquery="update accounts
						set password='{$newencpw}'
						where account_id={$_SESSION['acc_id']}";
			$editresult=mysqli_query($dbc, $editquery);
		}
	}
	if(!empty($_POST['new-fname'])){
		$editquery="update accounts
					set first_name='{$_POST['new-fname']}'
					where account_id={$_SESSION['acc_id']}";
		$editresult=mysqli_query($dbc, $editquery);
	}
	if(!empty($_POST['new-lname'])){
		$editquery="update accounts
					set last_name='{$_POST['new-lname']}'
					where account_id={$_SESSION['acc_id']}";
		$editresult=mysqli_query($dbc, $editquery);
	}
	if(!empty($_POST['new-bday'])){
		$editquery="update accounts
					set birthdate='{$_POST['new-bday']}'
					where account_id={$_SESSION['acc_id']}";
		$editresult=mysqli_query($dbc, $editquery);
	}
	if(!empty($_POST['new-unitno']) && !empty($_POST['new-street']) && !empty($_POST['new-subdi']) && !empty($_POST['new-city'])){

		$address = $_POST['new-unitno']." ".$_POST['new-street'].", ".$_POST['new-subdi'].", ".$_POST['new-city'];

		$editquery="update accounts
					set address='{$address}'
					where account_id={$_SESSION['acc_id']}";
		$editresult=mysqli_query($dbc, $editquery);
	}

	$_SESSION['to-edit'] = 0;
}
?>

<div id="all">
	<div id="content">
		<div class="container">
			<div class="col-md-12" id="customer-details">
				<div class="box">
					<div class="row">
						<div class="col-md-10">
							<h1>Account</h1>
						</div>
						
					<?php
						$user_query="select * from accounts where account_id={$_SESSION['acc_id']}";
						$user_result=mysqli_query($dbc, $user_query);
						$user_row=mysqli_fetch_array($user_result, MYSQLI_ASSOC);

						if($_SESSION['to-edit']==0){
					?>

						<div class="col-md-2">
							<form action="editaccount.php" method="post">
								<button style="width:100% !important;" class="btn btn-primary btn-md" name="editacc" id="editacc"><i class="fa fa-edit"></i>Edit</button>
							</form>
						</div>
					</div>
					
					<p class="lead">You can view, and edit your personal details and account information here.</p>

					<hr>
					<!-- main content -->
					<div class="row">
						<!-- left half of main content -->
						<div class="col-md-6">
							<h3>Account Details</h3>
							<div class="row">
								<div class="col-md-3">
									<p class="info"><strong>Account ID:</strong> #<?php echo $user_row['account_id'] ?></p>
								</div>
								<div class="col-md-9">
									<p class="info"><strong>Username:</strong> <?php echo $user_row['username'] ?></p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<p class="info"><strong>E-mail:</strong> <?php echo $user_row['email'] ?></p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<p class="info"><strong>Contact No.:</strong> <?php echo $user_row['contact_number'] ?></p>
								</div>
							</div>
						</div>
						<!-- right half of main content -->
						<div class="col-md-6">
							<h3>Personal Details</h3>
							<div class="row">
								<div class="col-md-5">
									<p class="info"><strong>First Name:</strong> <?php if($user_row['first_name']){ echo $user_row['first_name']; }
							 														   else{ echo "--"; }?>
									</p>
								</div>
								<div class="col-md-5">
									<p class="info"><strong>Last Name:</strong> <?php if($user_row['last_name']){ echo $user_row['last_name']; }
				 														   			  else{ echo "--"; }?>
							 		</p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<p class="info"><strong>Birthday:</strong> <?php if($user_row['birthdate']){ echo $user_row['birthdate']; }
					 														  		 else{ echo "--"; }?>
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<p class="info"><strong>Address:</strong> #<?php if($user_row['address']){ echo $user_row['address']; }
					 														  		 else{ echo "--"; }?>
									</p>
								</div>
							</div>
						</div>
					</div>

					<?php
						}
						else{
					?>

					<div class="col-md-2">
							<form action="editaccount.php" method="post">
								<button style="width:100% !important;" class="btn btn-primary btn-md" name="canceledit" id="canceledit"><i class="fa fa-times"></i>Cancel</button>
							</form>
						</div>
					</div>
					
					<p class="lead">Edit your information here. You can press the "Cancel" button to cancel editting.</p>

					<hr>
					<!-- main content -->
					<form class="form-inline" action="editaccount.php" method="post">
						<!-- left half of main content -->
						<div class="row">
							<div class="col-md-6">
								<h3>Account Details</h3>
								<div class="row">
									<div class="col-md-5">
										<label for="username"><strong>Username:</strong></label>
									</div>
									<div class="col-md-6">
										<label for="contactno"><strong>Contact #:</strong></label>
									</div>
								</div>
								<div class="row">
									<div class="col-md-5">
										<div class="form-group">
											<input type="text" class="form-control" name="new-un" placeholder="Username">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" class="form-control" name="new-cn" placeholder="Contact No.">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<label for="email"><strong>E-mail:</strong></label>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" class="form-control" name="new-em" placeholder="email@example.com">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-5">
										<label for="pw"><strong>Password:</strong></label>
									</div>
									<div class="col-md-6">
										<label for="checkpw"><strong>Re-type Password:</strong></label>
									</div>
								</div>
								<div class="row">
									<div class="col-md-5">
										<div class="form-group">
											<input type="password" class="form-control" name="new-pw" placeholder="New Password">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type="password" class="form-control" name="checknewpw" placeholder="Re-type Password">
										</div>
									</div>
								</div>
							</div>
							<!-- right half of main content -->
							<div class="col-md-6">
								<h3>Personal Details</h3>
								<div class="row">
									<div class="col-md-5">
										<label for="fname"><strong>First Name:</strong></label>
									</div>
									<div class="col-md-6">
										<label for="lname"><strong>Last Name:</strong></label>
									</div>
								</div>
								<div class="row">
									<div class="col-md-5">
										<div class="form-group">
											<input type="text" class="form-control" name="new-fname" placeholder="First Name">
										</div>
									</div>
									<div class="col-md-5">
										<div class="form-group">
											<input type="text" class="form-control" name="new-lname" placeholder="Last Name">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<label for="bday"><strong>Birthdate:</strong></label>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<input type="date" style="width:150px !important;"class="form-control" name="new-bday">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-2">
										<label for="unitnum"><strong>Unit #:</strong></label>
									</div>
									<div class="col-md-10">
										<label for="street"><strong>Street Name:</strong></label>
									</div>
								</div>
								<div class="row">
									<div class="col-md-2">
										<div class="form-group">
											<input type="text" style="width:68px !important;" class="form-control" name="new-unitno" placeholder="Unit #">
										</div>
									</div>
									<div class="col-md-10">
										<div class="form-group">
											<input type="text" class="form-control" name="new-street" placeholder="Street Name">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-5">
										<label for="subdi"><strong>Subdivision:</strong></label>
									</div>
									<div class="col-md-6">
										<label for="cityprov"><strong>City/Province:</strong></label>
									</div>
								</div>
								<div class="row">
									<div class="col-md-5">
										<div class="form-group">
											<input type="text" class="form-control" name="new-subdi" placeholder="Subdivision">
										</div>
									</div>
									<div class="col-md-5">
										<div class="form-group">
											<input type="text" class="form-control" name="new-city" placeholder="City/Province">
										</div>
									</div>
								</div>
							</div>
						</div>

						<hr>

						<div class="row">
							<div class="col-md-1">
								<button class="btn btn-primary btn-md" name="confirmedit" id="confirmedit"><i class="fa fa-save"></i>Save Changes</button>
							</div>
						</div>
					</form>
					
					<?php		
						}
					?>

				</div>
			</div>
		</div>
	</div>
</div>

<!-- custom css -->

<style>
	
	.info{
		font-size: 16px;
	}

	.form-control{
		margin-top: 10px;
		margin-bottom: 10px;
		margin-left: 5px;
		width: 100% !important;
	}

</style>

<?php
	require_once('/footer.php');
?>
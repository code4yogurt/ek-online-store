<?php
	
	session_start();
	require_once('/connect.php');
	require_once('/navbar.php');

	if(isset($_SESSION['is_loggedin'])){
			$user_query="select * from accounts where account_id={$_SESSION['acc_id']}";
			$user_results=mysqli_query($dbc, $user_query);
			$user_row=mysqli_fetch_array($user_results, MYSQLI_ASSOC);
	}

	if(isset($_POST['sendcomplaint'])){

		if(!empty($_POST['complaint-subj'])){
			$subj=$_POST['complaint-subj'];
		}
		if(!empty($_POST['complaint-cont'])){
			$cont=$_POST['complaint-cont'];
		}

		if($_SESSION['is_loggedin']==1){

			//CHECK IF FIRST NAME ALREADY EXISTS IN DB
			if(empty($user_row['first_name'])){
				//CHECK IF AN INPUT FOR FIRST NAME EXISTS
				if(!empty($_POST['complaint-fname'])){
					$fname=$_POST['complaint-fname'];
				}
			}
			else{
				$fname=$user_row['first_name'];
			}

			//CHECKS IF LAST NAME ALREADY EXISTS IN DB
			if(empty($user_row['last_name'])){
				//CHECK IF AN INPUT FOR LAST NAME EXISTS
				if(!empty($_POST['complaint-lname'])){
					$lname=$_POST['complaint-lname'];
				}
			}
			else{
				$lname=$user_row['last_name'];
			}

			$email=$user_row['email'];
		}
		else{

			if(!empty($_POST['complaint-fname'])){
				$fname=$_POST['complaint-fname'];
			}
			
			if(!empty($_POST['complaint-lname'])){
				$lname=$_POST['complaint-lname'];
			}
			
			if(!empty($_POST['complaint-email'])){
				$email=$_POST['complaint-email'];
			}
		}

		$date = date("Y-m-d");

		if($subj && $cont && $fname && $lname && $email){

			$issue_query="insert into complaint (complaint_date, complaint_subject, complaint_content, account_id, complaint_fname, complaint_lname, complaint_email)
						  values ('{$date}', '{$subj}', '{$cont}', '1', '{$fname}', '{$lname}', '{$email}')";
			$issue_result=mysqli_query($dbc, $issue_query);
		}
	}
?>

<div id="all">
	<div id="content">
		<div class="container">
			<div class="col-md-12" id="company-details">
				<div class="box">
					<div class="row">
						<div class="col-md-12">
							<h1>Contact Information</h1>
						</div>
					</div>

					<p class="lead">Do you need to know more about us? Do you have a complaint for us?</p>
					<p>Feel free to contact us or issue a complaint down below!</p>

					<hr>

					<div class="row">
						<div class="col-md-4">
							<h3><i class="fa fa-map-marker"></i> Location</h3>
							<p>San Lorenzo Rd, Santa Rosa, Laguna 4026</p>
						</div>
						<div class="col-md-4">
							<h3><i class="fa fa-phone"></i> Contact Us!</h3>
							<p>If you want to speak to one of our customer service staff, you can call </p>
							<p><strong>666-6666.</strong></p>
						</div>
						<div class="col-md-4">
							<h3><i class="fa fa-envelope-o"></i> Send a Ticket!</h3>
							<p>If you have any concerns or complaint, issue a ticket <strong>down below</strong>! Our customer service staff will recieve this, and will respond to you via e-mail!</p>
						</div>
					</div>

					<hr>

					<form action="issuecomplaint.php" method="post">
						<div class="row">
							<div class="col-md-12">
								<h3>Issue Ticket</h3>
							</div>
						</div>
						<div class="row">
							<!-- issue complaint section -->
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-12">
										<label for="complaint-subj"><strong>Subject:</strong></label>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" class="form-control" name="complaint-subj" id="complaint-subj" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<label for="complaint-cont"><strong>Content:</strong></label>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<textarea class="form-control" rows="3" name="complaint-cont" id="complaint-cont" required></textarea>
										</div>
									</div>
								</div>
							</div>
							<!-- personal details section -->
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<label for="complaint-fname"><strong>First Name:</strong></label>
									</div>
									<div class="col-md-6">
										<label for="complaint-lname"><strong>Last Name:</strong></label>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" class="form-control" name="complaint-fname" id="complaint-fname" <?php 	if(isset($_SESSION['is_loggedin'])){
																																	   		if(!empty($user_row['first_name'])){
																																	   			echo "placeholder='".$user_row['first_name']."'";
																																	   			echo "disabled";
																																	   		}
																																	   		else{
																																	   			echo "placeholder='First Name'";
																																	   			echo "required";
																																	   		}
																																  	  	}
																																  	  	else{
																																  	  		echo "placeholder='First Name'";
																																  	  		echo "required";
																																  	  	}	
																														  	  	?> 	>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" class="form-control" name="complaint-lname" id="complaint-lname" <?php 	if(isset($_SESSION['is_loggedin'])){
																																	   		if(!empty($user_row['last_name'])){
																																	   			echo "placeholder='".$user_row['last_name']."'";
																																	   			echo "disabled";
																																	   		}
																																	   		else{
																																	   			echo "placeholder='Last Name'";
																																	   			echo "required";
																																	   		}
																																  	  	}
																																  	  	else{
																																  	  		echo "placeholder='Last Name'";
																																  	  		echo "required";
																																  	  	}	
																														  	  	?> 	>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<label for="complaint-email"><strong>E-mail:</strong></label>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<input type="email" class="form-control" name="complaint-email" id="complaint-email" 	<?php 	if(isset($_SESSION['is_loggedin'])){
																																		   		if(!empty($user_row['email'])){
																																		   			echo "placeholder='".$user_row['email']."'";
																																		   			echo "disabled";
																																		   		}
																																		   		else{
																																		   			echo "placeholder='eldar@example.com'";
																																		   			echo "required";
																																		   		}
																																  	  		}
																																	  	  	else{
																																	  	  		echo "placeholder='eldar@example.com'";
																																	  	  		echo "required";
																																	  	  	}	
																															  	  	?> 	>
										</div>
									</div>
								</div>
							</div>
						</div>

						<hr>

						<div class="row">
							<div class="col-md-offset-5">
								<button class="btn btn-primary btn-md" name="sendcomplaint" id="sendcomplaint"><i class="fa fa-envelope-o"></i>Send Complaint</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	require_once('/footer.php');
?>


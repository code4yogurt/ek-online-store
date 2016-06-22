<?php
session_start();

if(isset($_POST['submit'])){

	require_once('/connect.php');

	$message=NULL;

	if(empty($_POST['depositcode'])){
		$dc=FALSE;
		$message='Deposit code is required!';
	}
	else{
		$dc=$_POST['depositcode'];
	}

	if(empty($_POST['depositamt'])){
		$da=FALSE;
		$message='Enter the amount deposited!';
	}
	else{
		$da=$_POST['depositamt'];
	}

	if($dc && $da){
	
		$queryid="select account_id from accounts where username='{$_SESSION['username']}'";
		$resultid=mysqli_query($dbc, $queryid);

		while($row=mysqli_fetch_array($resultid,MYSQLI_ASSOC)){
			$actid=$row['account_id'];
		}

		$datetime= date("Y-m-d H:i:s");

		$addor="insert into official_receipt (transaction_date, bank_deposit_code, deposited_money, account_id)
				values ('{$datetime}','{$dc}','{$da}','{$actid}')";
		$orresult=mysqli_query($dbc, $addor);

		$getorid="select receipt_id from official_receipt where bank_deposit_code='$dc'";
		$oridresult=mysqli_query($dbc, $getorid);

		while($oridrow=mysqli_fetch_array($oridresult, MYSQLI_ASSOC)){
			$orid=$oridrow['receipt_id'];
		}

		$cartorid="update cart set cart_status=0, receipt_id={$orid} where account_id = {$actid}";
		$cartresult=mysqli_query($dbc, $cartorid);

	} 
}

if(isset($message)){
	echo "<font color='red'".$message.'</font>';
}

?>

<style>
	.form-group{
		width:20em;
	}
</style>

<link rel="stylesheet" href="css/bootstrap.min.css">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<fieldset><legend>BANK DETAILS</legend>

<div class='container-fluid'>

<div class='form-group'>
	<label for='depositcode'>Bank Deposit Code</label>
	<input type='text' name='depositcode' class='form-control' size='11' maxlength='11' />
</div>
<div class='form-group'>
	<label for='depositamt'>Deposit Amount</label>
	<input type='text' name='depositamt' class='form-control' size='20' maxlength='30' />
</div>

<input type='submit' class='btn btn-default' name='submit' value='Checkout'/><br><br>

</div>
</form>
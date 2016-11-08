<?php
session_start();

require_once('../mysql_connect.php');
require_once('navbar.php');
?>
<div id="all">

        <div id="content">
            <div class="container">

<?php

$queryid="select account_id from accounts where username='{$_SESSION['username']}'";
		$resultid=mysqli_query($dbc, $queryid);

		while($row=mysqli_fetch_array($resultid,MYSQLI_ASSOC)){
			$account_id=$row['account_id'];

		}


$count=0;
$query="select cart_id from cart where account_id =$account_id and cart_status =1";
		$result=mysqli_query($dbc, $query);
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
		$cart_id=$row['cart_id'];
		
		$count=$count+1;	


		}
		if($count==0){
			header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
		}



if(isset($_POST['submit'])){

	

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
	if(empty($_POST['unit'])){
		$unit=FALSE;
		$message='Enter the House/ Unit No.!';
	}
	else{
		$unit=$_POST['unit'];
	}
	if(empty($_POST['street'])){
		$street=FALSE;
		$message='Enter the Street!';
	}
	else{
		$street=$_POST['street'];
	}
	if(empty($_POST['town'])){
		$town=FALSE;
		$message='Enter the Town!';
	}
	else{
		$town=$_POST['town'];
	}
	if(empty($_POST['state'])){
		$state=FALSE;
		$message='Enter the State!';
	}
	else{
		$state=$_POST['state'];
	}
	if(empty($_POST['postcode'])){
		$postcode=FALSE;
		$message='Enter the amount Postcode!';
	}
	else{
		$postcode=$_POST['postcode'];
	}
	
	
	
	

	if($dc && $da){
	
		$queryid="select account_id from accounts where username='{$_SESSION['username']}'";
		$resultid=mysqli_query($dbc, $queryid);

		while($row=mysqli_fetch_array($resultid,MYSQLI_ASSOC)){
			$account_id=$row['account_id'];
		}

		$date= date("Y-m-d");

		$address = $unit.' '.$street.', '.$town.', '.$state.' '.$postcode;
		
	
	//INSERT INTO PENDING PAYMENT LACKS THE ADDRESS------------------------	
		$query2="insert into pending_payment (payment_code,payment_amt,payment_status,payment_date) values ('{$dc}','{$da}','0','{$date}')";
		$result2=mysqli_query($dbc, $query2);
	//--------------------------------------------------------------------

		$query2="select payment_id from pending_payment where payment_code = $dc";
		$result2=mysqli_query($dbc, $query2);
		
		while($row=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
			$payment_id=$row['payment_id'];
		}



		$query="select cart_id from cart where account_id ='{$account_id}' and cart_status =1";
		$result=mysqli_query($dbc, $query);

		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
			$cart_id=$row['cart_id'];

		
			$cartorid="update cart set cart_status=0,payment_id = $payment_id,cart_activity = 1 where cart_id=$cart_id";
		$cartresult=mysqli_query($dbc, $cartorid);
			

		}
//OFFICIAL RECEIPT INSERT NOT COMPLETE
		$query3="insert into official_receipt (transaction_date,account_id,is_discounted) values ('{$date}','{$account_id}','0','{$date}')";
		$result3=mysqli_query($dbc, $query3);
//------------------------------------------
				
			$_SESSION['checkout']=1;
		
			header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/checkout_2.php");

	
			//INSERT EMAIL ON RECEIVED ORDER AND ON PENDING STATUS

	} 




}
//------------------------------------------------------------------------------------------------------------------------------------
if(isset($message)){
	echo "<font color='red'".$message.'</font>';
}



?>

<style>
	.form-group{
		width:20em;
	}
</style>




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


</div>
<fieldset><legend>DELIVERY ADDRESS</legend>
<div class='form-group'>
	<label for='unit'>House/ Unit No.</label>
	<input type='text' name='unit' class='form-control' size='20' maxlength='15' />
</div>
<div class='form-group'>
	<label for='street'>Street/ Building</label>
	<input type='text' name='street' class='form-control' size='20' maxlength='50' />
</div>
<div class='form-group'>
	<label for='town'>Town/ City</label>
	<input type='text' name='town' class='form-control' size='20' maxlength='40' />
</div>
<div class='form-group'>
	<label for='state'>State/ County</label>
	<input type='text' name='state' class='form-control' size='20' maxlength='40' />
</div>
<div class='form-group'>
	<label for='postcode'>Postcode / ZIP</label>
	<input type='text' name='postcode' class='form-control' size='20' maxlength='10' />
</div>
<input type='submit' class='btn btn-primary' name='submit' value='Checkout'/><br><br>




</form>


</div>
<br><br><br><br>

<?php
require_once('footer.php');
?>
</body>

</html>

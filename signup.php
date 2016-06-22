	<?php
session_start();

if(isset($_POST['submit'])){
	require_once('/connect.php');

	$message=NULL;

	//CHECKS IF USER ID WAS INPUTTED
	if(empty($_POST['userid'])){
		$uid=FALSE;
		$message='User ID is required.';
	}
	else{
		$logincheck="select username from accounts where username='{$_POST['userid']}'";
		$checkresult=@mysqli_query($dbc, $logincheck);
		$row=mysqli_fetch_array($checkresult, MYSQLI_ASSOC);

		if(empty($row)){
			$uid=$_POST['userid'];
		}
		else{
			$message='Username already exists!';
			$uid=FALSE;
		}
	}

	//CHECKS IF PASSWORD WAS INPUTTED
	if(empty($_POST['password'])){
		$pw=FALSE;
		$message='Passowrd is required.';
	}
	else{
		$pw=$_POST['password'];
	}

	if(empty($_POST['pwconfirm'])){
		$cpw=FALSE;
		$message='Please confirm password';
	}
	else{
		$cpw=$_POST['pwconfirm'];
	}
	//CHECKS IF E-MAIL WAS INPUTTED
	if(empty($_POST['email'])){
		$em=FALSE;
		$message='Email is required';
	}
	else{
		$em=$_POST['email'];
	}

	//CHECKS IF FIRST NAME WAS INPUTTED
	if(empty($_POST['fname'])){
		$fn=FALSE;
		$message='First name is required.';
	}
	else{
		$fn=$_POST['fname'];
	}

	//CHECKS IF LAST NAME WAS INPUTTED
	if(empty($_POST['lname'])){
		$ln=FALSE;
		$message='Last name is required.';
	}
	else{
		$ln=$_POST['lname'];
	}

	//CHECKS IF BIRTHDAY WAS INPUTTED
	if(empty($_POST['bday'])){
		$bd=FALSE;
		$message='Birthdate is required.';
	}
	else{
		$bd=$_POST['bday'];
	}

	//CHECKS IF CONTACT NUMBER WAS INPUTTED
	if(empty($_POST['cnumber'])){
		$cn=FALSE;
		$message='Contact number is required';
	}
	else{
		$cn=$_POST['cnumber'];
	}

	//CHECKS IF ADDRESS WAS INPUTTED
	if(empty($_POST['address'])){
		$ad=FALSE;
		$message='Address is required';
	}
	else{
		$ad=$_POST['address'];
	}

	//CHECKS IF GENDER WAS INPUTTED
	if(empty($_POST['gender'])){
		$gd=FALSE;
		$message='Gender is required';
	}
	else{
		$gd=$_POST['gender'];
	}

	//VALUES uid:USER_ID ; pw:PASSWORD ; em:EMAIL ; fn:FIRST_NAME ; ln:LAST_NAME ; bd:BIRTHDAY ; cn:CONTACT_NO ; ad:ADDRESS ; gd:GENDER ; ut:USER_TYPE
	if($pw!=$cpw){
		$pwerror='Passwords do not match!';
	}
	else if($uid && $pw && $em && $fn && $ln && $bd && $cn && $ad && $gd){

		$salt = sha1(md5($pw));
		$encpw = md5($pw).$salt;

		$query="insert into accounts (email, username, password, first_name, last_name, birthdate, contact_number, address, gender, type)
				values ('{$em}','{$uid}','{$encpw}','{$fn}','{$ln}','{$bd}','{$cn}','{$ad}','{$gd}','uac')";

		$result=@mysqli_query($dbc,$query); 

		$_SESSION['signupmsg']='New Account has been added!';
		$_SESSION['signupflag']=1;

		header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/loginpage.php");
	}
}

if(isset($message)){
	echo '<font color="red">'.$message.'</font><br>';
	echo '<font color="red">'.$pwerror.'</font>';
}

?>

<style>
	.form-group{
		width:20em;
	}
</style>

<link rel="stylesheet" href="css/bootstrap.min.css">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<fieldset><legend>ACCOUNT CREATION</legend>

<div class="container-fluid">

<div class="form-group">
	<label for="userid">Username</label>
	<input type="text" class="form-control" name="userid" size="20" maxlength="30" value="<?php if(isset($_POST['userid'])) echo $_POST['userid']; ?>"/><br>
</div>
<div class="form-group">
	<label for="password">Password</label>
	<input type="password" class="form-control" name="password" size="20" maxlength="30" /><br>
</div>
<div class="form-group">
	<label for="pwconfirm">Confirm Password</label>
	<input type="password" class="form-control" name="pwconfirm" size="20" maxlength="30"/><br>
</div>
<div class="form-group">
	<label for="emailAddress">E-mail Address</label>
	<input type="text" class="form-control" name="email" size="20" maxlength="30" placeholder="carlos123@yahoo.com" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"/><br>
</div>
<div class="form-group">
	<label for="firstname">First Name</label>
	<input type="text" name="fname" class="form-control" size="20" maxlength="30" value="<?php if(isset($_POST['fname'])) echo $_POST['fname']; ?>"/><br>
</div>
<div class="form-group">
	<label for="lastname">Last Name</label>
	<input type="text" name="lname" class="form-control" size="20" maxlength="30" value="<?php if(isset($_POST['lname'])) echo $_POST['lname']; ?>"/><br>
</div>
<div class="form-group">
	<label for="birthdate">Birthdate</label>
	<input type="date" class="form-control" name="bday" value="<?php if(isset($_POST['bday'])) echo $_POST['bday']; ?>"/><br>
</div>
<div class="form-group">
	<label for="contactnumber">Contact Number</label>
	<input type="text" class="form-control" name="cnumber" size="20" maxlength="30" value="<?php if(isset($_POST['cnumber'])) echo $_POST['cnumber']; ?>"/><br>
</div>
<div class="form-group">
	<label for="address">Address</label>
	<br><textarea rows="4" class="form-control" cols="50" name="address" value="<?php if(isset($_POST['address'])) echo $_POST['address']; ?>"> </textarea><br>
</div>
<div class="form-group">
	<label for="Gender">Gender</label>
	<label class="radio-inline">
 	<input type="radio" name="gender" id="inlineRadio1" value="M"> M
	</label>
	<label class="radio-inline">
  	<input type="radio" name="gender" id="inlineRadio2" value="F"> F
	</label>
</div> <br>
<input type="submit" class="btn btn-default" name="submit" value="Sign-Up"/>
</div>
</form>
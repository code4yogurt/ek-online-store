<a href='index.php'>Home</a><br>
<?php 
session_start();

if(isset($_SESSION['badlogin'])){
	if($_SESSION['badlogin']>=999){
		header("Location: http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/blocked.php");
	}
}

if(isset($_POST['submit'])){
	require_once('../mysql_connect.php');

	$message=NULL;

	//checks if user id was inputted
	if(empty($_POST['userid'])){
		$un=FALSE;
		$message='You forgot to enter your username!';
	}
	else{
		$un=$_POST['userid'];
	}

	//checks if password was inputted
	if(empty($_POST['password'])){
		$pw=FALSE;
		$message='You forgot to enter password!';
	}
	else{
		$pw=$_POST['password'];
	}

	//makes sure user id and password has values before error checking
	if($un && $pw){

		$salt = sha1(md5($pw));
		$pwchk = md5($pw).$salt;

		$query="select username, type from accounts where username='$un' and password='$pwchk'";
		$result=@mysqli_query($dbc, $query);
		$row=mysqli_fetch_array($result, MYSQLI_ASSOC);

		if($row){

			$_SESSION['username']=$row['username'];
			$_SESSION['type']=$row['type'];

			if($row['type']=='uac'){
				header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
			}
			else if($row['type']=='aac'){
				header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/admin.php");
			}
			else if($row['type']=='sac'){
				header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/shipper.php");
			}

			exit();
		}
		else{
			$message='Username and passwords do not match.';
		}
	}
	else{
		$message='Please try again.';
	}

	if(isset($_SESSION['badlogin'])){
		$_SESSION['badlogin']++;
	}
	else{
		$_SESSION['badlogin']=1;
	}
}

if(isset($message)){
	echo '<font color="red">'.$message.'</font>';
}

?>

<style>
	.form-group{
		width:20em;
	}
</style>

<link rel="stylesheet" href="css/bootstrap.min.css">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<fieldset><legend>LOG-IN</legend>

<div class='container-fluid'>

<font color="green"> <?php if(isset($_SESSION['signupmsg']) && $_SESSION['signupflag']==1) echo $_SESSION['signupmsg']; $_SESSION['signupflag']=0; ?> </font>

<div class='form-group'>
	<label for='userid'>Username:</label>
	<input type='text' class='form-control' name='userid' size='20' maxlength='30' placeholder='Username' value='<?php if(isset($_POST['userid'])) echo $_POST['userid']; ?>'/>
</div>
<div class='form-group'>
	<label for='password'>Password:</label>
	<input type='password' class='form-control' name='password' size='20' maxlength='30' placeholder='Password' />
</div>

<input type='submit' class='btn btn-default' name='submit' value='Log-in'/><br><br>

Don't have an account yet? Sign up <a href="/dev-web/projthings/signup.php">here</a>.
</div>
</form>



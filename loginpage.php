<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentellela Alela! | </title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="https://colorlib.com/polygon/gentelella/css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
              <h1>Login</h1>
               <?php 
                session_start();
                if(isset($_SESSION['badlogin'])){
                  if($_SESSION['badlogin']>=999){
                    header("Location: http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/blocked.php");
                  }
                }
                if(isset($_POST['submit'])){
                  require_once('../db_connect.php');
                  $message=NULL;
                  //checks if user id was inputted
                  if(empty($_POST['username'])){
                    $un=FALSE;
                    $message='You forgot to enter your username!';
                  }
                  else{
                    $un=$_POST['username'];
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
                        header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
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

              <div>
                <input type="text" class="form-control" name='username' maxlength='30' placeholder="Username"  value='<?php if(isset($_POST['username'])) echo $_POST['username']; ?>' required="" />
              </div>
              <div>
                <input type="password" class="form-control" name='password' placeholder="Password" required="" />
              </div>
              <div>
                <input type='submit' class="btn btn-default submit" name='submit' value='Log-in'>
                <a class="reset_pass" href="#">Lost your password?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> Enchanted Kingdom!</h1>
                  <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>

      </div>
    </div>
  </body>
</html>
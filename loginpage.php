<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="robots" content="all,follow">
    <meta name="googlebot" content="index,follow,snippet,archive">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Obaju e-commerce template">
    <meta name="author" content="Ondrej Svestka | ondrejsvestka.cz">
    <meta name="keywords" content="">

    <title>
        Obaju : e-commerce template
    </title>

    <meta name="keywords" content="">

    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100' rel='stylesheet' type='text/css'>

    <!-- styles -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.theme.css" rel="stylesheet">

    <!-- theme stylesheet -->
    <link href="css/style.default.css" rel="stylesheet" id="theme-stylesheet">

    <!-- your stylesheet with modifications -->
    <link href="css/custom.css" rel="stylesheet">

    <script src="js/respond.min.js"></script>

    <link rel="shortcut icon" href="favicon.png">



</head>

<body>
    

    <div id="all">

        <div id="content">
            <div class="container">
                

                <div class="col-lg-6">
                    <p>
                    <div class="box">
                       <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <h1>Login</h1>


                        <p class="lead">Already our customer?</p>
                        <p class="text-muted">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies
                            mi vitae est. Mauris placerat eleifend leo.</p>

                        <hr>
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
                            <p></p>
                        
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" maxlength="30" value='<?php if(isset($_POST['username'])) echo $_POST['username']; ?>' required=""/>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" required=""/>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" name="submit"><i class="fa fa-sign-in"></i> Log in</button>
                            </div>
                        </form>
                    </div>
                </p>
                </div>


            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->

<?php
require_once('footer.php');
?>


</body>

</html>

<?php

session_start();
require_once('/connect.php');

if(isset($_SESSION['badlogin'])){
    if($_SESSION['badlogin']>=999){
        header("Location: http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/blocked.php");
    }
}

    //PHP FORM FOR LOGIN FORM

if(isset($_POST['login'])){ 

        //checks if username field is empty
    if(empty($_POST['login-username'])){
        $un=FALSE;
        $un_msg="You forgot to enter your username!";
    }
    else{
        $un=$_POST['login-username'];
    }
        //checks if password field is empty
    if(empty($_POST['login-password'])){
        $pw=FALSE;
        $pw_msg="You forgot to enter your password!";
    }
    else{
        $pw=$_POST['login-password'];
    }

        //makes sure username and password have values before error check
    if($un && $pw){
        $salt=sha1(md5($pw));
        $pwchk=md5($pw).$salt;
        $query="select account_id, username, type from accounts where username='$un' and password='$pwchk'";
        $result=@mysqli_query($dbc, $query);
        $row=mysqli_fetch_array($result, MYSQLI_ASSOC);

        if($row){
            $_SESSION['username']=$row['username'];
            $_SESSION['type']=$row['type'];

            $_SESSION['is_loggedin']=1;
            $_SESSION['acc_id']=$row['account_id'];

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
            echo "<font color='red'> Username & Password do not match! </font>";
        }
    }
    else{
        echo "<font color='red'> Please try again! </font>";
    }
}

    //PHP CODE FOR REGISTRATION FORM

if(isset($_POST['register'])){

        //checks if email field is empty
    if(empty($_POST['reg-email'])){
        $em=FALSE;
        $em_msg="You forgot to enter your e-mail!";
    }
    else{
        $em=$_POST['reg-email'];
    }

        //checks if username field is empty
    if(empty($_POST['reg-username'])){
        $un=FALSE;
        $un_msg="You forgot to enter your username!";
    }
    else{
        $un=$_POST['reg-username'];
    }

        //checks if password field is empty
    if(empty($_POST['reg-password'])){
        $pw=FALSE;
        $pw_msg="You forgot to enter your password!";
    }
    else{
        $pw=$_POST['reg-password'];
    }

        //checks if password verification field is empty
    if(empty($_POST['pwverify'])){
        $pwv=FALSE;
    }
    else{
        $pwv=$_POST['pwverify'];
    }

        //checks if gender field is empty
    if(empty($_POST['reg-contactno'])){
        $cn=FALSE;
        $message='You forgot to select a gender!';
    }
    else{
        $cn=$_POST['reg-contactno'];
    }



        /* VALUES - em:E-MAIL; un:USERNAME; pw:PASSWORD; pwv:PASSWORD VERIFICATION; gd:GENDER;
        Makes sure all the fields have are not empty */
        if($em && $un && $pw && $pwv && $cn){

        //checks if password matches the password verification
            if($pw!=$pwv){
                $pwerror_msg="Passwords do not match!";
            }
            else{

                $salt = sha1(md5($pw));
                $encpw = md5($pw).$salt;

                $query = "insert into accounts (email, username, password, contact_number, type)
                values ('{$em}', '{$un}', '{$encpw}', '{$cn}', 'uac')";

                $result=@mysqli_query($dbc,$query);

                $_SESSION['signup-msg']="New account has been added!";
                $_SESSION['signup-flag']=1;
                $_SESSION['is_loggedin']=1;

                header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/index.php");
            }
        }
        else{
            echo "<font color=r'red'> Please try again! </font>";
        }
    }

    ?>

    <?php
    require_once('/navbar.php');
    ?>

   <!-- *** NAVBAR END *** -->

   <div id="all">

    <div id="content">
        <div class="container">

            <div class="col-md-12">

                <ul class="breadcrumb">
                    <li><a href="#">Home</a>
                    </li>
                    <li>New account / Sign in</li>
                </ul>

            </div>

            <div class="col-md-6">
                <div class="box">
                    <h1>New account</h1>

                    <p class="lead">Not our registered customer yet?</p>

                    <hr>

                    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="reg-email">
                        </div>
                        <div class="form-group">
                            <label for="name">Username</label>
                            <input type="text" class="form-control" name="reg-username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="reg-password">
                        </div>
                        <div class="form-group">
                            <label for="pwverify">Confirm Password</label>
                            <input type="password" class="form-control" name="pwverify">
                        </div>
                        <div class="form-group">
                            <label for="contactno">Contact Number</label><br>
                            <input type="text" class="form-control" name="reg-contactno">
                        </div> 
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" name="register"><i class="fa fa-user-md"></i> Register</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box">
                    <h1>Login</h1>

                    <p class="lead">Already our customer?</p>

                    <hr>

                    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="login-username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="login-password">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" name="login"><i class="fa fa-sign-in"></i> Log in</button>
                        </div>
                    </form>
                </div>
            </div>


        </div>
        <!-- /.container -->
    </div>
    <!-- /#content -->

<?php

require_once('/footer.php');

?>
</body>

</html>

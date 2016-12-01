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
        Enchanted Kingdom
    </title>

    <!-- styles -->

    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100' rel='stylesheet' type='text/css'>
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.theme.css" rel="stylesheet">

    <!-- theme stylesheet -->

    <link href="css/style.green.css" rel="stylesheet" id="theme-stylesheet">

    <!-- your stylesheet with modifications -->

    <link href="css/custom.css" rel="stylesheet">
    <script src="js/respond.min.js"></script>   
    <link rel="shortcut icon" href="favicon.png">
</head>

<body>
    <!-- *** TOPBAR *** -->
    <div id="top">
        <div class="container">
            <div class="col-md-12" data-animate="fadeInDown">
                <ul class="menu">
                    <?php
                    if(isset($_SESSION['is_loggedin'])){
                        if($_SESSION['is_loggedin'] == 0){
                            echo "<li><a href='#' data-toggle='modal' data-target='#login-modal'>Login</a></li>";
                            echo "<li><a href='signup.php'>Register</a></li>";
                        }
                        else{
                            echo "<li><p style='color:#ffffff !important;'>Welcome, <a href='editaccount.php'>{$_SESSION['username']}</a></p></li>";
                            echo "<li><a href='logout.php'>Logout</a></li>";
                            echo "<li><a href='orderstatus.php'>Check Order</a></li>";
                        }
                    }
                    else{
                        echo "<li><a href='#' data-toggle='modal' data-target='#login-modal'>Login</a></li>";
                        echo "<li><a href='signup.php'>Register</a></li>";
                    }
                    ?>

                    <li><a href="issuecomplaint.php">Contact</a></li>
                    <li><a href="#">Recently viewed</a></li>
                </ul>
            </div>
        </div>

        <!-- MODAL -->

        <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="Login">Customer Login</h4>
                    </div>

                    <?php
                    if(isset($_POST['modal-login'])){ 

                            //checks if username field is empty

                        if(empty($_POST['un-modal'])){
                            $un=FALSE;
                            $un_msg="You forgot to enter your username!";
                        }
                        else{
                            $un=$_POST['un-modal'];
                        }

                            //checks if password field is empty
                        if(empty($_POST['pw-modal'])){
                            $pw=FALSE;
                            $pw_msg="You forgot to enter your password!";
                        }

                        else{
                            $pw=$_POST['pw-modal'];
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
                    ?>

                    <div class="modal-body">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                            <div class="form-group">
                                <input type="text" class="form-control" name="un-modal" maxlength='30' placeholder="Username" value='<?php if(isset($_POST['username'])) echo $_POST['username'] ?>' required/>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="pw-modal" maxlength='30' placeholder="Password" required />
                            </div>
                            <p class="text-center">
                                <button class="btn btn-primary" name='modal-login'><i class="fa fa-sign-in"></i> Log in</button>
                            </p>
                        </form>

                        <p class="text-center text-muted">Not registered yet?</p>
                        <p class="text-center text-muted"><a href="signup.php"><strong>Register now</strong></a>!

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        if(isset($_POST['search'])){

            //makes sure search has value
            if(isset($_POST['search-input'])){
                $_SESSION['searchstring']=$_POST['search-input'];
            }
            //double checks search has value
            if($_SESSION['searchstring']){
                header("Location: searchresults.php");
            }
        }
    ?>

    <!-- *** TOP BAR END *** -->

    <!--NAVBAR-->

    <div class="navbar navbar-default yamm" role="navigation" id="navbar">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand home" href="index.php" data-animate-hover="bounce">
                    <img src="img/ek2.png" alt="Obaju logo" class="hidden-xs">
                    <img src="img/ek2.png" alt="Obaju logo" class="visible-xs"><span class="sr-only">Enchanted Kingdom Home</span>
                </a>
                <div class="navbar-buttons">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-align-justify"></i>
                    </button>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#search">
                        <span class="sr-only">Toggle search</span>
                        <i class="fa fa-search"></i>
                    </button>
                    <a class="btn btn-default navbar-toggle" href="basket.html">
                        <i class="fa fa-shopping-cart"></i>  <span class="hidden-xs">3 items in cart</span>
                    </a>
                </div>
            </div>
            <!--/.navbar-header -->

            <div class="navbar-collapse collapse" id="navigation">
                <ul class="nav navbar-nav navbar-left">
                    <li class="active"><a href="index.php">Home</a></li>
                    <li class="dropdown yamm-fw">
                        <a href="allApparel.php" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="200">Apparel <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="yamm-content">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <h5><a href="allApparel.php">All</a></h5>
                                        </div>
                                        <div class="col-lg-2">
                                            <h5><a href="shirts.php">Shirts</a></h5>
                                        </div>
                                        <div class="col-lg-2">
                                            <h5><a href="shorts.php">Shorts</a></h5>
                                        </div>
                                        <div class="col-lg-2">
                                            <h5><a href="hoodies.php">Hoodies</a></h5>
                                        </div>
                                        <div class="col-lg-2">
                                            <h5><a href="footwear.php">Footwear</a></h5>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.yamm-content -->
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown yamm-fw">
                        <a href="alDrinkware.php" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="200">DrinkWare <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="yamm-content">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <h5><a href="allDrinkware.php">All</a></h5>
                                        </div>
                                        <div class="col-lg-3">
                                            <h5><a href="mugs.php">Mugs</a></h5>
                                        </div>
                                        <div class="col-lg-3">
                                            <h5><a href="tumblers.php">Tumblers</a></h5>
                                        </div>
                                        <div class="col-lg-3">
                                            <h5><a href="shotglasses.php">Shotglasses</a></h5>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.yamm-content -->
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown yamm-fw">
                        <a href="allToys.php" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="200">Toys <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="yamm-content">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <h5><a href="allToys.php">All</a></h5>
                                        </div>
                                        <div class="col-lg-3">
                                            <h5><a href="plushies.php">Plushies</a></h5>
                                        </div>
                                        <div class="col-lg-3">
                                            <h5><a href="pillows.php">Pillows</a></h5>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.yamm-content -->
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown yamm-fw">
                        <a href="allAccessories.php" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="200">Accessories <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="yamm-content">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <h5><a href="allAccessories.php">All</a></h5>
                                        </div>
                                        <div class="col-lg-2">
                                            <h5><a href="braceletes.php">Braceletes</a></h5>
                                        </div>
                                        <div class="col-lg-2">
                                            <h5><a href="pendants.php">Pendants</a></h5>
                                        </div>
                                        <div class="col-lg-2">
                                            <h5><a href=s"magnets.php">Magnets</a></h5>
                                        </div>
                                        <div class="col-lg-2">
                                            <h5><a href="keychains.php">Keychains</a></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--/.nav-collapse -->

                            <!--SEARCH & CART START-->

                            <div class="navbar-buttons">

                                <!--CART-->

                                <div class="navbar-collapse collapse right" id="basket-overview">
                                    <a href="cart.php" class="btn btn-primary navbar-btn">

                                        <?php
                                        if(isset($_SESSION['is_loggedin'])){
                                            if($_SESSION['is_loggedin']==1){
                                                $query1="SELECT count(event_id) AS cartCount FROM cart WHERE account_id='{$_SESSION['acc_id']}' and cart_status=1 ";
                                                $result1=mysqli_query($dbc,$query1);
                                                while($row1=mysqli_fetch_array($result1,MYSQLI_ASSOC)){   
                                                    echo "{$row1['cartCount']}";
                                                    }
                                                }else{
                                                echo " ";
                                            }
                                        }
                                        ?>
                                        <i class="fa fa-shopping-cart"></i></a>
                                </div>

                                <!--/CART COLLAPSE -->

                                <!--SEARCH-->
                                <div class="navbar-collapse collapse right" id="search-not-mobile">
                                    <button type="button" class="btn navbar-btn btn-primary" data-toggle="collapse" data-target="#search">
                                        <span class="sr-only">Toggle search</span>
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="collapse clearfix" id="search">
                                <form class="navbar-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search-input" placeholder="Search">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary" name="search"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <!--/SEARCH COLLAPSE -->
                        </div>
                        <!-- /.yamm-content -->
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- /.container -->
</div>

<!-- /#navbar -->

<!-- *** NAVBAR END *** -->

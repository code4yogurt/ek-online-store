<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require_once('../db_connect.php');

if ($_SESSION['type']!='aac') 
       header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/loginpage.php");
?>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed ">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
               <img scr="images/ek_icon.png"><a href="index.php" class="site_title"> <span>Enchanted Kingdom<span></a>

            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="images/IMG_3042.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $_SESSION['username']?></h2>
                
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-dashboard"></i> DashBoard <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="index.html">OverView</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-users"></i> Users <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="userList.php">List</a></li>
                      <li><a href="form.html">Orders</a></li>
                      <li><a href="deactivateUser.php">Deactivate</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-shopping-cart"></i> Orders <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="userList.php">...</a></li>
                      <li><a href="form.html">....</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-tags"></i> Products <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="products.php">View All</a></li>
                      <li><a href="media_gallery.html">Edit</a></li>
                      <li><a href="media_gallery.html">Coupons</a></li>
                      <li><a href="media_gallery.html">Add New</a></li>
                      <li><a href="media_gallery.html">Activate</a></li>
                      <li><a href="deactivateProduct.php">Deactivate</a></li>
                      <li><a href="media_gallery.html">Featured</a></li>
                      <li><a href="media_gallery.html">Coupons</a></li>
                      <li><a href="media_gallery.html">Reviews/Comments</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-bar-chart"></i> Reports <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="tables.html">General</a></li>
                      <li><a href="tables_dynamic.html">Date Range</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-truck"></i>Inventory<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="chartjs.html">Inbound</a></li>
                      <li><a href="chartjs2.html">Outbound</a></li>
                      <li><a href="chartjs2.html">Add/Deduct Stock</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-bullhorn"></i> Announcements <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="email.php">Email Blast</a></li>
                      <li><a href="fixed_footer.html">NewsLetters</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
              

            </div>
           

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
            
          </div>
        </div>



      
      </div>
      <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
               
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="images/IMG_3042.jpg" alt=""> <?php echo $_SESSION['username']?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"> Profile</a></li>
                    <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                    </li>
                    <li><a href="javascript:;">Help</a></li>
                    <li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">6</span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span class="image"><img src="images/IMG_3042.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>Joshua Macuja</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/IMG_3042.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>Joshua Macuja</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/IMG_3042.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>Joshua Macuja</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/IMG_3042.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>Joshua Macuja</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>


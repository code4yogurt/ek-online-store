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
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

      <?php
      require_once('header.php');
      ?>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              

            </div>
                 <div class="clearfix"></div>

            <div class="row">
             
                    <?php
                     $datetime= date("Y-m-d H:i:s");
$query="SELECT count(comment_id) as comment_count FROM comments";
$result=mysqli_query($dbc,$query);
$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
$pages=$row['comment_count'] / 10;
$page_no=ceil($pages);

$start=0;
if(isset($_GET['go'])){
  $pn=$_GET['dropdown'];

$start=($_GET['dropdown']-1)*10;
}
else{
$pn=1;
}
                      ?>

              <div class=" col-lg-12">
                <div class="x_panel">
                  <div class="x_title">
                    <p align='center'><b>List of Pending Comments</p></b>

<a href='manage_comments_final.php'>Pending Comments</a> | 
<a href='manage_approved_comments_final.php'>Approved Comments</a> | 
<a href='manage_disapproved_comments_final.php'>Disapproved Comments</a>
<br><br>
                    <p align='left'><?php echo "{$datetime}";?></p>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                    <table class="table table-bordered">
                      
                        <tr>
                          <td>Date</td>
                          <td>User</td>
                          <td>Product</td>
                          <td>Comment</td>
                          <td></td>
                        </tr>
                        <?php
                          
$query="select C.date, P.prod_name, C.username, C.comment, C.comment_id from products P JOIN comments C ON p.prod_id=c.prod_id where c.status = 1 LIMIT $start,10 ";
$result=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                         ?>
                        <tr>
                          <td><?php echo"{$row['date']}"?></td>
                          <td><?php echo"{$row['prod_name']}";?></td>
                          <td><?php echo"{$row['username']}";?></td>
                          <td><?php echo"{$row['comment']}";?></td>
                   
                          <td>
                           <form action='approve_comment.php' method='POST'>
      <button type='submit' name='approve' value='<?php echo "{$row['comment_id']}";?>'>Approve</button>
      </form>


      <form action='disapprove_comment.php' method='POST'>
      <button type='submit' name='disapprove' value='<?php echo "{$row['comment_id']}";?>'>Disapprove</button>
      </form>
                       <?php }?>
                      

                    </table>
                      
                    </div>
                    

           
<?php
echo"
</table>
<form action='{$_SERVER['PHP_SELF']}' method='GET'>
Page: <select name='dropdown'>
";
for($i=$page_no;$i>0;$i--){
  echo"
    <option value='{$i}' selected>{$i} </option>
  ";
}
echo"
</select>
<input type='submit' name='go' value='Go' />
</form>
";
?>




                  </div>
                </div>
              </div>

              
              </div>
            </div>
          </div>
        
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
  </body>
</html>
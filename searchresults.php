<!DOCTYPE html>
<html lang="en">

<?php
session_start();
require_once('connect.php');
require_once('navbar.php');

if(empty($_SESSION['searchstring'])){
	header("Location: index.php");
}
?>

<div id="all">
	<div id="content">
		<div class="container">                
		</div>
		<!-- *** HOT PRODUCT SLIDESHOW ***-->
		<div id="hot">

			<div class="box">
				<div class="container">
					<div class="col-md-12">
						<h2>Search Results</h2>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="product-slider">
					<?php

					$search_query="select prod_name, prod_desc, prod_price, image from products 
					where prod_name like '%{$_SESSION['searchstring']}%' 
					order by 'category' AND 'prod_name'"; 
					$result=@mysqli_query($dbc, $search_query); 
					$row=mysqli_fetch_array($result, MYSQLI_ASSOC); 

					if($row){
						while($row){
							
							echo "<div class='item'>
									<div class='product'>
										<a href='detail.html'>
											<img src='".$row['image']."' alt='' class='img-responsive'>
										</a>
										<div class='text'>
											<h3><a href='detail.html'>".$row['prod_name']."</a></h3>
											<p class='price'>".$row['prod_price']."</p>
										</div>
										<!-- /.text -->
									</div>
								<!-- /.product -->
								</div>";

							$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
						}
					}

					?>

				</div>
				<!-- /.product-slider -->
			</div>
			<!-- /.container -->
		</div>
		<!-- /#hot -->
		<!-- *** HOT END *** -->
	</div>
	<!-- /#content -->

	<?php
	require_once('footer.php');
	?>

</body>
</html>
<?php require_once('header.php');
?>

<section class="content-header">
	<h1>Dashboard</h1>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_numerology");
$statement->execute();
$total_numerology = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_vaastu");
$statement->execute();
$total_vaastu = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_services");
$statement->execute();
$total_services = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_banner");
$statement->execute();
$total_banner = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM  tbl_blog_category");
$statement->execute();
$total_blog_cat = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM  tbl_blog");
$statement->execute();
$total_blog = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM  tbl_testimonial");
$statement->execute();
$total_testimonial = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_product_category");
$statement->execute();
$total_cat_accessroies = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_product");
$statement->execute();
$total_accessories = $statement->rowCount();


$statement = $pdo->prepare("SELECT * FROM tbl_order WHERE order_status=?");
$statement->execute(array('Pending'));
$total_order_pending = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_order WHERE order_status=?");
$statement->execute(array('Shipped'));
$total_order_Shipped = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_order WHERE order_status=?");
$statement->execute(array('Delivered'));
$total_order_Complete = $statement->rowCount();
?>

<section class="content">

	<div class="row">
		<div class="col-lg-12 col-xs-6">
			<h3>Manage Total</h3>
		</div>

		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3><?php echo $total_numerology; ?></h3>

					<p>Numerology</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-checkmark-circled"></i>
				</div>

			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-green">
				<div class="inner">
					<h3><?php echo $total_vaastu; ?></h3>

					<p>Vaastu</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-android-checkbox-outline"></i>
				</div>

			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-orange">
				<div class="inner">
					<h3><?php echo $total_services; ?></h3>

					<p>Services</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-load-a"></i>
				</div>

			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-maroon">
				<div class="inner">
					<h3><?php echo $total_banner; ?></h3>

					<p>Banner</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-clipboard"></i>
				</div>

			</div>
		</div>

		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-red">
				<div class="inner">
					<h3><?php echo $total_blog_cat; ?></h3>

					<p>Blogs Category</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-person-stalker"></i>
				</div>

			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-orange">
				<div class="inner">
					<h3><?php echo $total_blog; ?></h3>

					<p>Blogs</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-load-a"></i>
				</div>

			</div>
		</div>
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3><?php echo $total_testimonial; ?></h3>

					<p>Testimonial</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-checkmark-circled"></i>
				</div>

			</div>
		</div>
	</div>

	<div class="row">
		<!-- To Products -->
		<div class="col-lg-12 col-xs-6">
			<h3>To Products Deatils</h3>
		</div>
		<a href="accessories.php">
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-maroon">
					<div class="inner">
						<h3><?php echo $total_cat_accessroies;  ?></h3>
						<p> Product Categories </p>
					</div>
					<div class="icon">
						<i class="ionicons ion-android-cart"></i>
					</div>

				</div>
			</div>
		</a>
		<a href="accessroies-cat.php">
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-maroon">
					<div class="inner">
						<h3><?php echo $total_accessories; ?></h3>
						<p>To Products</p>
					</div>
					<div class="icon">
						<i class="ionicons ion-android-cart"></i>
					</div>

				</div>
			</div>
		</a>
	</div>

	<br>
	<br>

	<div class="row">
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-maroon">
				<div class="inner">
					<h3><?php echo $total_order_pending; ?></h3>

					<p>Pending Orders</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-clipboard"></i>
				</div>

			</div>
		</div>
	
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3><?php echo $total_order_Complete; ?></h3>

					<p>Completed Shipping</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-checkmark-circled"></i>
				</div>

			</div>
		</div>
		<!-- ./col -->

		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-orange">
				<div class="inner">
					<h3><?php echo $total_order_pending; ?></h3>

					<p>Pending Shippings</p>
				</div>
				<div class="icon">
					<i class="ionicons ion-load-a"></i>
				</div>

			</div>
		</div>




	</div>

</section>

<?php require_once('footer.php'); ?>
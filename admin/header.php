<?php
ob_start();
session_start();
include("inc/config.php");
include("inc/functions.php");
include("inc/CSRF_Protect.php");
$csrf = new CSRF_Protect();
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';

// Check if the user is logged in or not
if (!isset($_SESSION['user'])) {
	header('location: login.php');
	exit;
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Admin Panel</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/ionicons.min.css">
	<link rel="stylesheet" href="css/datepicker3.css">
	<link rel="stylesheet" href="css/all.css">
	<link rel="stylesheet" href="css/select2.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="css/jquery.fancybox.css">
	<link rel="stylesheet" href="css/AdminLTE.min.css">
	<link rel="stylesheet" href="css/_all-skins.min.css">
	<link rel="stylesheet" href="css/on-off-switch.css" />
	<link rel="stylesheet" href="css/summernote.css">
	<link rel="stylesheet" href="style.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="hold-transition fixed skin-blue sidebar-mini">

	<div class="wrapper">

		<header class="main-header">

			<a href="index.php" class="logo">
				<span class="logo-lg">Cosmic</span>
			</a>

			<nav class="navbar navbar-static-top">

				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>

				<span style="float:left;line-height:50px;color:#fff;padding-left:15px;font-size:18px;">Admin Panel</span>
				<!-- Top Bar ... User Inforamtion .. Login/Log out Area -->
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="./uploads/<?php echo $_SESSION['user']['photo']; ?>" class="user-image" alt="User Image">
								<span class="hidden-xs"><?php echo $_SESSION['user']['full_name']; ?></span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-footer">
									<div>
										<a href="profile-edit.php" class="btn btn-default btn-flat">Edit Profile</a>
									</div>
									<div>
										<a href="logout.php" class="btn btn-default btn-flat">Log out</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>

			</nav>
		</header>

		<?php $cur_page = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1); ?>
		<!-- Side Bar to Manage Shop Activities -->
		<aside class="main-sidebar">
			<section class="sidebar">
				<ul class="sidebar-menu">
					<li class="treeview <?php if ($cur_page == 'index.php') {
											echo 'active';
										} ?>">
						<a href="index.php">
							<i class="fa fa-dashboard"></i> <span>Dashboard</span>
						</a>
					</li>
					<li class="treeview <?php if (($cur_page == 'page.php')) {
											echo 'active';
										} ?>">
						<a href="page.php">
							<i class="fa fa-tasks"></i> <span>Manage CMS </span>
						</a>
					</li>

					<li class="treeview <?php if (($cur_page == 'banner.php') || ($cur_page == 'banner-add.php') || ($cur_page == 'banner-edit.php')) {
											echo 'active';
										} ?>">
						<a href="banner.php">
							<i class="fa fa-cogs"></i>
							<span>Manage banner</span>
						</a>
					</li>
					<li class="treeview <?php if (($cur_page == 'numerology.php') || ($cur_page == 'numerology.php') || ($cur_page == 'numerology.php') || ($cur_page == 'numerology.php') || ($cur_page == 'numerology.php') || ($cur_page == 'numerology.php')) {
											echo 'active';
										} ?>">
						<a href="numerology.php">
							<i class="fa fa-cogs"></i>
							<span>Manage Numerology</span>
						</a>

					</li>
					<li class="treeview <?php if (($cur_page == 'Vaastu.php') || ($cur_page == 'Vaastu-add.php') || ($cur_page == 'Vaastu-edit.php')) {
											echo 'active';
										} ?>">
						<a href="Vaastu.php">
							<i class="fa fa-cogs"></i>
							<span>Manage Vaastu</span>
						</a>
					</li>
					<li class="treeview <?php if (($cur_page == 'services.php') || ($cur_page == 'services-add.php') || ($cur_page == 'services-edit.php')) {
											echo 'active';
										} ?>">
						<a href="services.php">
							<i class="fa fa-cogs"></i>
							<span>Manage Services</span>
						</a>
					</li>

					<li class="treeview <?php if (($cur_page == 'product-cat.php') || ($cur_page == 'product-cat-add.php') || ($cur_page == 'product-cat-edit.php') || ($cur_page == 'accessories.php') || ($cur_page == 'accessories-add.php') || ($cur_page == 'accessories-edit.php')) {
											echo 'active';
										} ?>">
						<a href="#">
							<i class="fa fa-cogs"></i>
							<span>Manage Products</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="product-cat.php"><i class="fa fa-circle-o"></i>Add Shop Category</a></li>
							<li><a href="product.php"><i class="fa fa-circle-o"></i>Add Products</a></li>
						</ul>
					</li>



					<li class="treeview <?php if (($cur_page == 'blog-category.php') || ($cur_page == 'blog-category-add.php') || ($cur_page == 'blog-category-edit.php') || ($cur_page == 'blog.php') || ($cur_page == 'blog-add.php') || ($cur_page == 'blog-edit.php')) {
											echo 'active';
										} ?>">
						<a href="#">
							<i class="fa fa-cogs"></i>
							<span>Manage Blogs</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="blog-category.php"><i class="fa fa-circle-o"></i>Add Category</a></li>
							<li><a href="blog.php"><i class="fa fa-circle-o"></i>Add Blogs</a></li>
						</ul>
					</li>
					<li class="treeview <?php if (($cur_page == 'news-events.php')) {
											echo 'active';
										} ?>">
						<a href="news-events.php">
							<i class="fa fa-globe"></i> <span>Manage News & Events</span>
						</a>
					</li>
					<li class="treeview <?php if (($cur_page == 'testimonial.php')) {
											echo 'active';
										} ?>">
						<a href="testimonial.php">
							<i class="fa fa-globe"></i> <span>Manage Testimonial</span>
						</a>
					</li>



					<li class="treeview <?php if (($cur_page == 'order.php')) {
											echo 'active';
										} ?>">
						<a href="order.php">
							<i class="fa fa-sticky-note"></i> <span>Order Management</span>
						</a>
					</li>


					<li class="treeview <?php if (($cur_page == 'social-media.php')) {
											echo 'active';
										} ?>">
						<a href="social-media.php">
							<i class="fa fa-globe"></i> <span>Social Media</span>
						</a>
					</li>

				</ul>
			</section>
		</aside>

		<div class="content-wrapper">
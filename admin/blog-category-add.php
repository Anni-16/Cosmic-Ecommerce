<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['blo_name'])) {
        $valid = 0;
        $error_message .= "Category Name can not be empty<br>";
    } else {
    	// Duplicate Category checking
    	$statement = $pdo->prepare("SELECT * FROM tbl_blog_category WHERE blo_name=?");
    	$statement->execute(array($_POST['blo_name']));
    	$total = $statement->rowCount();
    	if($total)
    	{
    		$valid = 0;
        	$error_message .= "Category Name already exists<br>";
    	}
    }

	if ($valid == 1) {

		// Insert blog category into the table
		$statement = $pdo->prepare("INSERT INTO tbl_blog_category (blo_name, status) VALUES (?, ?)");
		$statement->execute([$_POST['blo_name'], $_POST['status']]);
	
		$blog_id = $pdo->lastInsertId(); // Get the inserted ID
	
		// Create a URL-friendly slug from the blog name
		$slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['blo_name'])));
		$slug_url = rtrim($slug_url, '-');
	
		// Update the inserted blog category with the slug
		$statement = $pdo->prepare("UPDATE tbl_blog_category SET url = ? WHERE blo_id = ?");
		$statement->execute([$slug_url, $blog_id]);
	
		$success_message = 'Blog category added successfully.';
	}
	
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Blog Category</h1>
	</div>
	<div class="content-header-right">
		<a href="blog-category.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<section class="content">

	<div class="row">
		<div class="col-md-12">

			<?php if($error_message): ?>
			<div class="callout callout-danger">
			
			<p>
			<?php echo $error_message; ?>
			</p>
			</div>
			<?php endif; ?>

			<?php if($success_message): ?>
			<div class="callout callout-success">
			
			<p><?php echo $success_message; ?></p>
			</div>
			<?php endif; ?>

			<form class="form-horizontal" action="" method="post">

				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Category Name <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="blo_name">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Show on Menu? <span>*</span></label>
							<div class="col-sm-4">
								<select name="status" class="form-control" style="width:auto;" required>
									<option value="0">No</option>
									<option value="1">Yes</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
							</div>
						</div>
					</div>
				</div>

			</form>


		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>
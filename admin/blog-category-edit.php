<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['blo_name'])) {
        $valid = 0;
        $error_message .= "Category Name can not be empty<br>";
    } else {
		// Duplicate Top Category checking
    	// current Top Category name that is in the database
    	$statement = $pdo->prepare("SELECT * FROM tbl_blog_category WHERE blo_id=?");
		$statement->execute(array($_REQUEST['id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row) {
			$current_blo_name = $row['blo_name'];
		}

		$statement = $pdo->prepare("SELECT * FROM tbl_blog_category WHERE blo_name=? and blo_name!=?");
    	$statement->execute(array($_POST['blo_name'],$current_blo_name));
    	$total = $statement->rowCount();							
    	if($total) {
    		$valid = 0;
        	$error_message .= 'Category name already exists<br>';
    	}
    }

    if ($valid == 1) {
        // Update blog category name and status
        $statement = $pdo->prepare("UPDATE tbl_blog_category SET blo_name = ?, status = ? WHERE blo_id = ?");
        $statement->execute([$_POST['blo_name'], $_POST['status'], $_REQUEST['id']]);
    
        // Generate a URL-friendly slug from the blog name
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['blo_name'])));
        $slug_url = rtrim($slug_url, '-');
    
        // Update the slug in the same row
        $stmt2 = $pdo->prepare("UPDATE tbl_blog_category SET url = ? WHERE blo_id = ?");
        $stmt2->execute([$slug_url, $_REQUEST['id']]);
    
        $success_message = 'Blog category updated successfully.';
    }
    
}
?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_blog_category WHERE blo_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Edit Category</h1>
	</div>
	<div class="content-header-right">
		<a href="blog-category.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<?php							
foreach ($result as $row) {
	$blo_name = $row['blo_name'];
    $status = $row['status'];
}
?>

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
                        <input type="text" class="form-control" name="blo_name" value="<?php echo $blo_name; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Show on Menu? <span>*</span></label>
                    <div class="col-sm-4">
                        <select name="status" class="form-control" style="width:auto;" required>
                            <option value="0" <?php if($status == 0) {echo 'selected';} ?>>No</option>
                            <option value="1" <?php if($status == 1) {echo 'selected';} ?>>Yes</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                	<label for="" class="col-sm-2 control-label"></label>
                    <div class="col-sm-6">
                      <button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
                    </div>
                </div>

            </div>

        </div>

        </form>



    </div>
  </div>

</section>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
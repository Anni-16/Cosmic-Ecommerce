<?php require_once('header.php'); ?>

<?php
if (!isset($_REQUEST['id'])) {
    header('location: product-cat.php');
    exit;
} else {
    // Check if ID exists
    $statement = $pdo->prepare("SELECT * FROM tbl_product_category WHERE cat_id=?");
    $statement->execute([$_REQUEST['id']]);
    if ($statement->rowCount() == 0) {
        header('location: product-cat.php');
        exit;
    } else {
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $current_name  = $result['cat_name'];
        $current_status = $result['status'];
    }
}

if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';
    $success_message = '';

    // Validate Category Name
    if (empty($_POST['cat_name'])) {
        $valid = 0;
        $error_message .= "Category Name cannot be empty<br>";
    } else {
        $statement = $pdo->prepare("SELECT * FROM tbl_product_category WHERE cat_name=? AND cat_id!=?");
        $statement->execute([$_POST['cat_name'], $_REQUEST['id']]);
        if ($statement->rowCount() > 0) {
            $valid = 0;
            $error_message .= "Category Name already exists<br>";
        }
    }

    if ($valid == 1) {
        // Update database (no image column)
        $statement = $pdo->prepare("UPDATE tbl_product_category SET cat_name=?, status=? WHERE cat_id=?");
        $statement->execute([$_POST['cat_name'], $_POST['status'], $_REQUEST['id']]);

         // Generate a URL-friendly slug from the blog name
         $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['cat_name'])));
         $slug_url = rtrim($slug_url, '-');
     
         // Update the slug in the same row
         $stmt2 = $pdo->prepare("UPDATE tbl_product_category SET cat_url = ? WHERE cat_id = ?");
         $stmt2->execute([$slug_url, $_REQUEST['id']]);
     
        $success_message = 'Category updated successfully.';
        $current_name = $_POST['cat_name'];
        $current_status = $_POST['status'];
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Categories</h1>
    </div>
    <div class="content-header-right">
        <a href="product-cat.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($error_message)) : ?>
                <div class="callout callout-danger">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>

            <?php if (!empty($success_message)) : ?>
                <div class="callout callout-success">
                    <p><?php echo $success_message; ?></p>
                </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="cat_name" value="<?php echo htmlspecialchars($current_name); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Show on Menu? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="status" class="form-control" style="width:auto;" required>
                                    <option value="0" <?php echo ($current_status == 0) ? 'selected' : ''; ?>>No</option>
                                    <option value="1" <?php echo ($current_status == 1) ? 'selected' : ''; ?>>Yes</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success" name="form1">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>

<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    if (empty($_POST['cat_name'])) {
        $valid = 0;
        $error_message .= "Category Name cannot be empty<br>";
    } else {
        // Duplicate Category checking
        $statement = $pdo->prepare("SELECT * FROM tbl_product_category WHERE cat_name=?");
        $statement->execute(array($_POST['cat_name']));
        $total = $statement->rowCount();
        if ($total) {
            $valid = 0;
            $error_message .= "Category Name already exists<br>";
        }
    }

    if ($valid == 1) {
        // Example slug creation (you can customize as per your requirement)
        $slug_cat_url = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $_POST['cat_name'])));
        
        // Insert into DB
        $statement = $pdo->prepare("INSERT INTO tbl_product_category (cat_name, cat_url, status) VALUES (?, ?, ?)");
        $statement->execute(array($_POST['cat_name'], $slug_cat_url, $_POST['status']));

        $success_message = 'Category added successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Categories</h1>
    </div>
    <div class="content-header-right">
        <a href="product-cat.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($error_message)): ?>
                <div class="callout callout-danger">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>

            <?php if (!empty($success_message)): ?>
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
                                <input type="text" class="form-control" name="cat_name">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Show on Menu? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="status" class="form-control" style="width:auto;" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-6 col-sm-offset-2">
                                <button type="submit" class="btn btn-success" name="form1">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>

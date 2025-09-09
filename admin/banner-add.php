<?php require_once('header.php'); ?>

<?php
$success_message = '';
$error_message = '';

if (isset($_POST['form1'])) {
    // File upload handling
    $final_name1 = '';
    $final_name2 = '';

    // ======================
    // First Image Upload
    // ======================
    if (!empty($_FILES['ser_image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['ser_image']['name'], PATHINFO_EXTENSION));
        $final_name1 = 'banner1-' . time() . '.' . $ext;
        move_uploaded_file($_FILES['ser_image']['tmp_name'], './uploads/banner/' . $final_name1);
    }

    // ======================
    // Second Image Upload
    // ======================
    if (!empty($_FILES['ser_image_2']['name'])) {
        $ext2 = strtolower(pathinfo($_FILES['ser_image_2']['name'], PATHINFO_EXTENSION));
        $final_name2 = 'banner2-' . time() . '.' . $ext2;
        move_uploaded_file($_FILES['ser_image_2']['tmp_name'], './uploads/banner/' . $final_name2);
    }

    // Insert data into database
    $statement = $pdo->prepare("
        INSERT INTO tbl_banner (
            ser_name,
            ser_heading,
            ser_image,
            ser_image_2,
            ser_description,
            status
        ) VALUES (?, ?, ?, ?, ?, ?)
    ");

    $statement->execute([
        $_POST['ser_name'],
        $_POST['ser_heading'],
        $final_name1,
        $final_name2,
        $_POST['ser_description'],
        $_POST['status']
    ]);

    $success_message = "Banner added successfully.";
}
?>


<section class="content-header">
    <div class="content-header-left">
        <h1>Add banner</h1>
    </div>
    <div class="content-header-right">
        <a href="banner.php" class="btn btn-primary btn-sm">View All</a>
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
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="box box-info">
                    <div class="box-body">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">First Line Text <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="ser_name" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Second Line Text <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="ser_heading" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">banner Image  For Desktop<span>*</span></label>
                            <div class="col-sm-4">
                                <input type="file" name="ser_image" required>
                                <small class="text-muted">Image Size :- 1900px Width And 850px Height</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">banner Image For Mobile <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="file" name="ser_image_2" required>
                                <small class="text-muted">Image Size :- 600px Width And 1200px Height</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Third Line Text</label>
                            <div class="col-sm-8">
                                <textarea name="ser_description" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Show In Menu?</label>
                            <div class="col-sm-8">
                                <select name="status" class="form-control" style="width:auto;" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success" name="form1">Add banner</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
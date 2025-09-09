<?php require_once('header.php'); ?>

<?php
if (!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
}

// Fetch existing data
$statement = $pdo->prepare("SELECT * FROM tbl_services WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    header('location: logout.php');
    exit;
}

// Store existing values
$ser_name = $result['ser_name'];
$ser_heading = $result['ser_heading'];
$ser_image = $result['ser_image'];
$ser_description = $result['ser_description'];
$ser_heading_2 = $result['ser_heading_2'];
$ser_image_2 = $result['ser_image_2'];
$ser_description_2 = $result['ser_description_2'];
$ser_meta_title = $result['ser_meta_title'];
$ser_meta_keyword = $result['ser_meta_keyword'];
$ser_meta_descr = $result['ser_meta_descr'];
$status = $result['status'];
$content_2_status = $result['content_2_status'];

$error_message = '';
$success_message = '';

if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['ser_name'])) {
        $valid = 0;
        $error_message .= "Services name cannot be empty<br>";
    }

    // Image uploads
    $path1 = $_FILES['ser_image']['name'];
    $path_tmp1 = $_FILES['ser_image']['tmp_name'];
    $path2 = $_FILES['ser_image_2']['name'];
    $path_tmp2 = $_FILES['ser_image_2']['tmp_name'];

    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if ($path1 != '') {
        $ext1 = pathinfo($path1, PATHINFO_EXTENSION);
        if (!in_array(strtolower($ext1), $allowed_ext)) {
            $valid = 0;
            $error_message .= "Featured Image must be JPG, JPEG, PNG, GIF, or WEBP<br>";
        }
    }

    if ($path2 != '') {
        $ext2 = pathinfo($path2, PATHINFO_EXTENSION);
        if (!in_array(strtolower($ext2), $allowed_ext)) {
            $valid = 0;
            $error_message .= "Second Image must be JPG, JPEG, PNG, GIF, or WEBP<br>";
        }
    }

    if ($valid == 1) {
        $final_name1 = $ser_image;
        $final_name2 = $ser_image_2;

        // Replace image 1
        if ($path1 != '') {
            // delete old image if exists
            if ($ser_image != '' && file_exists('./uploads/services/' . $ser_image)) {
                unlink('./uploads/services/' . $ser_image);
            }
            $final_name1 = 'services-1-' . time() . '.' . $ext1;
            move_uploaded_file($path_tmp1, './uploads/services/' . $final_name1);
        }

        // Replace image 2
        if ($path2 != '') {
            if ($ser_image_2 != '' && file_exists('./uploads/services/' . $ser_image_2)) {
                unlink('./uploads/services/' . $ser_image_2);
            }
            $final_name2 = 'services-2-' . time() . '.' . $ext2;
            move_uploaded_file($path_tmp2, './uploads/services/' . $final_name2);
        }

        // Update database
        $statement = $pdo->prepare("UPDATE tbl_services SET 
            ser_name = ?, 
            ser_heading = ?, 
            ser_image = ?, 
            ser_description = ?, 
            ser_heading_2 = ?, 
            ser_image_2 = ?, 
            ser_description_2 = ?, 
            ser_meta_title = ?, 
            ser_meta_keyword = ?, 
            ser_meta_descr = ?, 
            status = ?,
            content_2_status =?
            WHERE id = ?");

        $statement->execute([
            $_POST['ser_name'],
            $_POST['ser_heading'],
            $final_name1,
            $_POST['ser_description'],
            $_POST['ser_heading_2'],
            $final_name2,
            $_POST['ser_description_2'],
            $_POST['ser_meta_title'],
            $_POST['ser_meta_keyword'],
            $_POST['ser_meta_descr'],
            $_POST['status'],
            $_POST['content_2_status'],
            $_REQUEST['id']
        ]);


        // Generate slug from blog title
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['ser_name'])));
        $slug_url = rtrim($slug_url, '-');

        // Update blog URL slug
        $stmt2 = $pdo->prepare("UPDATE tbl_services SET url = ? WHERE id = ?");
        $stmt2->execute([$slug_url, $_REQUEST['id']]);

        $success_message = 'services updated successfully.';
    }
}
?>


<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Services</h1>
    </div>
    <div class="content-header-right">
        <a href="services.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if ($error_message) : ?>
                <div class="callout callout-danger">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>

            <?php if ($success_message) : ?>
                <div class="callout callout-success">
                    <p><?php echo $success_message; ?></p>
                </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="box box-info">
                    <div class="box-body">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Services Name <span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="ser_name" class="form-control" value="<?php echo ($ser_name); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Services Heading Name <span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="ser_heading" class="form-control" value="<?php echo ($ser_heading); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Current Featured Image</label>
                            <div class="col-sm-4">
                                <img src="./uploads/services/<?php echo $ser_image; ?>" width="150">
                                <input type="hidden" name="current_photo1" value="<?php echo $ser_image; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Change Featured Image</label>
                            <div class="col-sm-4">
                                <input type="file" name="ser_image">
                                <small class="text-muted">Image Size :- 700px Width And 600px Height</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="ser_description" class="form-control" id="editor1"><?php echo ($ser_description); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Second Content Display</label>
                            <div class="col-sm-4">
                                <select name="content_2_status" class="form-control" style="width:auto;" require>
                                    <option value="block" <?php if ($content_2_status == 'block') echo 'selected'; ?>>Yes</option>
                                    <option value="none" <?php if ($content_2_status == 'none') echo 'selected'; ?>>No</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sub Heading</label>
                            <div class="col-sm-8">
                                <input type="text" name="ser_heading_2" class="form-control" value="<?php echo ($ser_heading_2); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Current Second Image</label>
                            <div class="col-sm-4">
                                <img src="./uploads/services/<?php echo $ser_image_2; ?>" width="150">
                                <input type="hidden" name="current_photo2" value="<?php echo $ser_image_2; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Change Second Image</label>
                            <div class="col-sm-4">
                                <input type="file" name="ser_image_2">
                                <small class="text-muted">Image Size :- 700px Width And 600px Height</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Second Description</label>
                            <div class="col-sm-8">
                                <textarea name="ser_description_2" class="form-control" id="editor2"><?php echo ($ser_description_2); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Title</label>
                            <div class="col-sm-8">
                                <input type="text" name="ser_meta_title" class="form-control" value="<?php echo ($ser_meta_title); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Keyword</label>
                            <div class="col-sm-8">
                                <input type="text" name="ser_meta_keyword" class="form-control" value="<?php echo ($ser_meta_keyword); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Description</label>
                            <div class="col-sm-8">
                                <textarea name="ser_meta_descr" class="form-control" rows="4"><?php echo ($ser_meta_descr); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Show In Menu?</label>
                            <div class="col-sm-4">
                                <select name="status" class="form-control" style="width:auto;">
                                    <option value="1" <?php if ($status == 1) echo 'selected'; ?>>Yes</option>
                                    <option value="0" <?php if ($status == 0) echo 'selected'; ?>>No</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
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
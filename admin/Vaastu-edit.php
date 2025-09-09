<?php require_once('header.php');

$id = $_REQUEST['id'];

// Fetch existing data
$statement = $pdo->prepare("SELECT * FROM tbl_vaastu WHERE id = ?");
$statement->execute([$id]);
$result = $statement->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    header("Location: logout.php");
    exit;
}

// Assign values for form fields
$ser_name        = $result['ser_name'];
$sub_heading_2   = $result['sub_heading_2'];
$ser_image       = $result['ser_image'];
$ser_image_2     = $result['ser_image_2'];
$ser_description = $result['ser_description'];
$description_2   = $result['description_2'];
$ser_meta_title  = $result['ser_meta_title'];
$ser_meta_keyword = $result['ser_meta_keyword'];
$ser_meta_descr  = $result['ser_meta_descr'];
$ser_icon        = $result['ser_icon'];
$status          = $result['status'];
$map_status      = $result['map_status'];
$page_order      = $result['page_order'];

$error_message = '';
$success_message = '';

if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['ser_name'])) {
        $valid = 0;
        $error_message .= "Heading cannot be empty.<br>";
    }

    $final_name1 = $ser_image;
    $final_name2 = $ser_image_2;
    $final_icon  = $ser_icon;

    $upload_dir  = './uploads/vaastu/';
    $upload_dir2 = './uploads/vaastu/icon/';

    // Upload Image 1
    if (!empty($_FILES['ser_image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['ser_image']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            $valid = 0;
            $error_message .= "Invalid format for Image 1. Allowed: jpg, jpeg, png, gif<br>";
        } else {
            // delete old file if exists
            if ($ser_image != '' && file_exists($upload_dir . $ser_image)) {
                unlink($upload_dir . $ser_image);
            }
            $final_name1 = 'Vaastu-1-' . $id . '.' . $ext;
            move_uploaded_file($_FILES['ser_image']['tmp_name'], $upload_dir . $final_name1);
        }
    }

    // Upload Image 2
    if (!empty($_FILES['ser_image_2']['name'])) {
        $ext2 = strtolower(pathinfo($_FILES['ser_image_2']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext2, ['jpg', 'jpeg', 'png', 'gif'])) {
            $valid = 0;
            $error_message .= "Invalid format for Image 2. Allowed: jpg, jpeg, png, gif<br>";
        } else {
            if ($ser_image_2 != '' && file_exists($upload_dir . $ser_image_2)) {
                unlink($upload_dir . $ser_image_2);
            }
            $final_name2 = 'Vaastu-2-' . $id . '.' . $ext2;
            move_uploaded_file($_FILES['ser_image_2']['tmp_name'], $upload_dir . $final_name2);
        }
    }

    // Upload Icon
    if (!empty($_FILES['ser_icon']['name'])) {
        $ext3 = strtolower(pathinfo($_FILES['ser_icon']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext3, ['jpg', 'jpeg', 'png', 'gif'])) {
            $valid = 0;
            $error_message .= "Invalid format for Icon. Allowed: jpg, jpeg, png, gif<br>";
        } else {
            if ($ser_icon != '' && file_exists($upload_dir2 . $ser_icon)) {
                unlink($upload_dir2 . $ser_icon);
            }
            $final_icon = 'Vaastu-icon-' . $id . '.' . $ext3;
            move_uploaded_file($_FILES['ser_icon']['tmp_name'], $upload_dir2 . $final_icon);
        }
    }

    // Update DB
    if ($valid) {
        $statement = $pdo->prepare("UPDATE tbl_vaastu SET 
            ser_name = ?, 
            sub_heading_2 = ?, 
            ser_image = ?, 
            ser_image_2 = ?, 
            ser_description = ?, 
            description_2 = ?, 
            ser_meta_title = ?, 
            ser_meta_keyword = ?, 
            ser_meta_descr = ?, 
            ser_icon = ?, 
            status = ?,
            map_status = ?,
            page_order = ?
            WHERE id = ?");

        $statement->execute([
            $_POST['ser_name'],
            $_POST['sub_heading_2'],
            $final_name1,
            $final_name2,
            $_POST['ser_description'],
            $_POST['description_2'],
            $_POST['ser_meta_title'],
            $_POST['ser_meta_keyword'],
            $_POST['ser_meta_descr'],
            $final_icon,
            $_POST['status'],
            $_POST['map_status'],
            $_POST['page_order'],
            $id
        ]);

        // Generate slug from blog title
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['ser_name'])));
        $slug_url = rtrim($slug_url, '-');

        // Update blog URL slug
        $stmt2 = $pdo->prepare("UPDATE tbl_vaastu SET url = ? WHERE id = ?");
        $stmt2->execute([$slug_url, $id]);

        $success_message = 'Vaastu entry updated successfully.';
    }
}
?>


<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Numerology</h1>
    </div>
    <div class="content-header-right">
        <a href="Vaastu.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($error_message)) : ?>
                <div class="callout callout-danger">
                    <p><?= $error_message; ?></p>
                </div>
            <?php endif; ?>

            <?php if (!empty($success_message)) : ?>
                <div class="callout callout-success">
                    <p><?= $success_message; ?></p>
                </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="box box-info">
                    <div class="box-body">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Name *</label>
                            <div class="col-sm-4">
                                <input type="text" name="ser_name" class="form-control" value="<?= ($ser_name); ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Current Icon</label>
                            <div class="col-sm-4">
                                <?php if (!empty($ser_icon)) : ?>
                                    <img src="./uploads/vaastu/icon/<?= $ser_icon; ?>" style="width:150px;">
                                <?php endif; ?>
                                <input type="hidden" name="current_icon" value="<?= $ser_icon; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Icon Image</label>
                            <div class="col-sm-4">
                                <input type="file" name="ser_icon" class="form-control">
                                <small class="text-muted">Image Size :- 500px Width And 500px Height</small>
                            </div>
                        </div>

                        <!-- Image 1 -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Existing Image 1</label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <?php if (!empty($ser_image)) : ?>
                                    <img src="./uploads/vaastu/<?= $ser_image; ?>" style="width:150px;">
                                <?php endif; ?>
                                <input type="hidden" name="current_photo1" value="<?= $ser_image; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Change Image 1</label>
                            <div class="col-sm-4">
                                <input type="file" name="ser_image">
                                <small class="text-muted">Image Size :- 700px Width And 600px Height</small>
                            </div>
                        </div>


                        <!-- Descriptions -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description 1</label>
                            <div class="col-sm-8">
                                <textarea name="ser_description" class="form-control" id="editor2"><?= ($ser_description); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sub Heading</label>
                            <div class="col-sm-4">
                                <input type="text" name="sub_heading_2" class="form-control" value="<?= ($sub_heading_2); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Existing Image 2</label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <?php if (!empty($ser_image_2)) : ?>
                                    <img src="./uploads/vaastu/<?= $ser_image_2; ?>" style="width:150px;">
                                <?php endif; ?>
                                <input type="hidden" name="current_photo2" value="<?= $ser_image_2; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Change Image 2</label>
                            <div class="col-sm-4">
                                <input type="file" name="ser_image_2">
                                <small class="text-muted">Image Size :- 700px Width And 600px Height</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description 2</label>
                            <div class="col-sm-8">
                                <textarea name="description_2" class="form-control" id="editor1"><?= ($description_2); ?></textarea>
                            </div>
                        </div>

                        <!-- Meta -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Title *</label>
                            <div class="col-sm-8">
                                <input type="text" name="ser_meta_title" class="form-control" value="<?= ($ser_meta_title); ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Keyword *</label>
                            <div class="col-sm-8">
                                <input type="text" name="ser_meta_keyword" class="form-control" value="<?= ($ser_meta_keyword); ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Description</label>
                            <div class="col-sm-8">
                                <textarea name="ser_meta_descr" class="form-control" rows="3"><?= ($ser_meta_descr); ?></textarea>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Show in Menu?</label>
                            <div class="col-sm-4">
                                <select name="status" class="form-control" style="width:auto;" required>
                                    <option value="1" <?= $status == 1 ? 'selected' : ''; ?>>Yes</option>
                                    <option value="0" <?= $status == 0 ? 'selected' : ''; ?>>No</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Map-Only Consultation </label>
                            <div class="col-sm-4">
                                <select name="map_status" class="form-control" style="width:auto;" required>
                                    <option value="block" <?php if ($map_status == 'block') echo 'selected'; ?>>Yes</option>
                                    <option value="none" <?php if ($map_status == 'none') echo 'selected'; ?>>No</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Page Order *</label>
                            <div class="col-sm-2">
                                <input type="number" name="page_order" class="form-control" value="<?= ($page_order); ?>" required>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
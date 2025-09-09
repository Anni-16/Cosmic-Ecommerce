<?php
require_once('header.php');

// Database connection already included from header.php
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

// Redirect if id is invalid
if ($id <= 0) {
    header('Location: banner.php');
    exit;
}

// Fetch existing data
$statement = $pdo->prepare("SELECT * FROM tbl_banner WHERE id = ?");
$statement->execute([$id]);
$result = $statement->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    echo "<div class='callout callout-danger'>Invalid record ID.</div>";
    require_once('footer.php');
    exit;
}

// Assign values for form fields
$ser_name         = $result['ser_name'];
$ser_heading      = $result['ser_heading'];
$ser_image        = $result['ser_image'];
$ser_image_2       = $result['ser_image_2'] ?? ''; // New image2
$ser_description  = $result['ser_description'];
$status           = $result['status'];

$error_message = '';
$success_message = '';

if (isset($_POST['form1'])) {
    $valid = 1;

    // Validation
    if (empty($_POST['ser_heading'])) {
        $valid = 0;
        $error_message .= "Heading cannot be empty.<br>";
    }

    $upload_dir = './uploads/banner/';

    // =====================
    // Image 1 Upload
    // =====================
    $final_name1 = $_POST['current_photo1'] ?? $ser_image;

    if (!empty($_FILES['ser_image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['ser_image']['name'], PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($ext, $allowed_ext)) {
            $valid = 0;
            $error_message .= "Invalid format for Image 1. Allowed: jpg, jpeg, png, gif<br>";
        } else {
            $final_name1 = 'banner1-' . time() . '.' . $ext;
            move_uploaded_file($_FILES['ser_image']['tmp_name'], $upload_dir . $final_name1);

            // Remove old image 1
            if (!empty($_POST['current_photo1']) && file_exists($upload_dir . $_POST['current_photo1'])) {
                unlink($upload_dir . $_POST['current_photo1']);
            }
        }
    }

    // =====================
    // Image 2 Upload
    // =====================
    $final_name2 = $_POST['current_photo2'] ?? $ser_image_2;

    if (!empty($_FILES['ser_image_2']['name'])) {
        $ext2 = strtolower(pathinfo($_FILES['ser_image_2']['name'], PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($ext2, $allowed_ext)) {
            $valid = 0;
            $error_message .= "Invalid format for Image 2. Allowed: jpg, jpeg, png, gif<br>";
        } else {
            $final_name2 = 'banner2-' . time() . '.' . $ext2;
            move_uploaded_file($_FILES['ser_image_2']['tmp_name'], $upload_dir . $final_name2);

            // Remove old image 2
            if (!empty($_POST['current_photo2']) && file_exists($upload_dir . $_POST['current_photo2'])) {
                unlink($upload_dir . $_POST['current_photo2']);
            }
        }
    }

    // =====================
    // Update Database
    // =====================
    if ($valid) {
        $statement = $pdo->prepare("UPDATE tbl_banner SET 
            ser_name = ?, 
            ser_heading = ?, 
            ser_image = ?, 
            ser_image_2 = ?, 
            ser_description = ?, 
            status = ?
            WHERE id = ?");

        $statement->execute([
            $_POST['ser_name'],
            $_POST['ser_heading'],
            $final_name1,
            $final_name2,
            $_POST['ser_description'],
            $_POST['status'],
            $id
        ]);

        $success_message = 'Banner updated successfully.';
    }
}
?>


<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Numerology</h1>
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
                            <label class="col-sm-3 control-label">First Line Text *</label>
                            <div class="col-sm-4">
                                <input type="text" name="ser_name" class="form-control" value="<?= $ser_name; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Second Line Text *</label>
                            <div class="col-sm-4">
                                <input type="text" name="ser_heading" class="form-control" value="<?= $ser_heading; ?>" required>
                            </div>
                        </div>

                        <!-- Existing Image -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Existing Image For Desktop</label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <?php if (!empty($ser_image)) : ?>
                                    <img src="./uploads/banner/<?= $ser_image; ?>" style="width:150px;">
                                <?php endif; ?>
                                <input type="hidden" name="current_photo1" value="<?= $ser_image; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Change Image For Desktop </label>
                            <div class="col-sm-4">
                                <input type="file" name="ser_image">
                                <small class="text-muted">Image Size :- 1900px Width And 850px Height</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Existing Image For Mobile </label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <?php if (!empty($ser_image_2)) : ?>
                                    <img src="./uploads/banner/<?= $ser_image_2; ?>" style="width:150px;">
                                <?php endif; ?>
                                <input type="hidden" name="current_photo2" value="<?= $ser_image_2; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Change Image Forf Mobile </label>
                            <div class="col-sm-4">
                                <input type="file" name="ser_image_2">
                                <small class="text-muted">Image Size :- 600px Width And 1200px Height</small>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Third Line Text * </label>
                            <div class="col-sm-8">
                                <textarea name="ser_description" class="form-control"><?= $ser_description; ?></textarea>
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
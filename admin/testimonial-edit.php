<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    if (empty($_POST['testimonial_name'])) {
        $valid = 0;
        $error_message .= "Name cannot be empty<br>";
    }

    if ($valid == 1) {
        $statement = $pdo->prepare("UPDATE tbl_testimonial SET 
            testimonial_name=?, 
            testimonial_content=?, 
            status=? 
            WHERE id=?");
        $statement->execute([
            ($_POST['testimonial_name']),
            ($_POST['testimonial_content']),
            ($_POST['status']),
            $_REQUEST['id']
        ]);

        $success_message = 'Testimonial information updated successfully.';
    }
}

// Fetch the current testimonial details
if (!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    $statement = $pdo->prepare("SELECT * FROM tbl_testimonial WHERE id=?");
    $statement->execute([$_REQUEST['id']]);
    $total = $statement->rowCount();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    if ($total == 0) {
        header('location: logout.php');
        exit;
    }
}

foreach ($result as $row) {
    $testimonial_name = ($row['testimonial_name']);
    $testimonial_content = ($row['testimonial_content']);
    $status = ($row['status']);
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Testimonial</h1>
    </div>
    <div class="content-header-right">
        <a href="testimonial.php" class="btn btn-primary btn-sm">View All</a>
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
                            <label class="col-sm-3 control-label">Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="testimonial_name" class="form-control" value="<?php echo $testimonial_name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="testimonial_content" class="form-control" cols="30" rows="10"><?php echo $testimonial_content; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Show on Menu? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="status" class="form-control" style="width:auto;">
                                    <option value="0" <?php echo ($status == 0) ? 'selected' : ''; ?>>No</option>
                                    <option value="1" <?php echo ($status == 1) ? 'selected' : ''; ?>>Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
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

<?php require_once('footer.php'); ?>

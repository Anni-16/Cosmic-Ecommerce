<?php require_once('header.php'); ?>

<?php

if (!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    // Check the id is valid or not
    $statement = $pdo->prepare("SELECT * FROM tbl_social WHERE social_id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    if ($total == 0) {
        header('location: logout.php');
        exit;
    }
}

if (isset($_POST['form1'])) {

    $statement = $pdo->prepare("UPDATE tbl_social SET social_name=?, social_url=? ,social_icon=?, status=?, footer=? WHERE social_id=?");
    $statement->execute(array($_POST['social_name'],$_POST['social_url'],$_POST['social_icon'],$_POST['status'],$_POST['footer'],$_REQUEST['id']));

    $success_message = 'Social Media are updated successfully.';
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Social Media</h1>
    </div>
    <div class="content-header-right">
        <a href="social-media.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<?php
foreach ($result as $row) {
	$social_name = $row['social_name'];
    $social_url = $row['social_url'];
    $social_icon = $row['social_icon'];
    $status = $row['status'];
    $footer = $row['footer'];
}
?>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <?php if ($error_message): ?>
                <div class="callout callout-danger">
                    <p>
                        <?php echo $error_message; ?>
                    </p>
                </div>
            <?php endif; ?>

            <?php if ($success_message): ?>
                <div class="callout callout-success">
                    <p><?php echo $success_message; ?></p>
                </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Social Media Name </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="social_name" value="<?php echo $social_name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Social Media URL </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="social_url" value="<?php echo $social_url; ?>">
                                <small class="text-muted">Enter Your social Media Url</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Social Media Icon </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="social_icon" value="<?php echo $social_icon; ?>" placeholder="e.g. fa-brands fa-google">
                                <br>
                                <i style="font-size:40px;" class="<?php echo $row['social_icon']; ?>"></i>
                                <br>
                                <small class="text-muted">Only enter the class name, e.g., <code>fa-brands fa-google</code></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Show In Header? </label>
                            <div class="col-sm-4">
                            <select name="status" class="form-control" style="width:auto;" required>
                                    <option value="0" <?php echo ($status == 0) ? 'selected' : ''; ?>>No</option>
                                    <option value="1" <?php echo ($status == 1) ? 'selected' : ''; ?>>Yes</option>
                                </select>                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Show In Footer? </label>
                            <div class="col-sm-4">
                            <select name="footer" class="form-control" style="width:auto;" required>
                                    <option value="0" <?php echo ($footer == 0) ? 'selected' : ''; ?>>No</option>
                                    <option value="1" <?php echo ($footer == 1) ? 'selected' : ''; ?>>Yes</option>
                                </select>                            </div>
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
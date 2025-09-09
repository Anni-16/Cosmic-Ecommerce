<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {

    $statement = $pdo->prepare("INSERT INTO tbl_social (social_name,social_url,social_icon, status,footer) VALUES (?,?,?,?,?)");
    $statement->execute(array($_POST['social_name'], $_POST['social_url'], $_POST['social_icon'], $_POST['status'], $_POST['footer']));

    $success_message = 'Social Media is added successfully.';
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Socail Media</h1>
    </div>
    <div class="content-header-right">
        <a href="social-media.php" class="btn btn-primary btn-sm">View All</a>
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
                            <label for="" class="col-sm-2 control-label">Social Media Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="social_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Social Media URL</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="social_url">
                                <small class="text-muted">Enter Your social Media Url</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Social Media Icon <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="social_icon" placeholder="e.g. fa-brands fa-google">
                                <small class="text-muted">Only enter the class name, e.g., <code>fa-brands fa-google</code></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Show on Header? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="status" class="form-control" style="width:auto;" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Show on Footer? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="footer" class="form-control" style="width:auto;" required>
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
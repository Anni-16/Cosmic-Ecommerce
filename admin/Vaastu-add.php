<?php require_once('header.php'); ?>

<?php
$success_message = '';
$error_message = '';

// Only run when the form is submitted
if (isset($_POST['form1'])) {
    // File upload handling
    $final_name1 = '';
    $final_name2 = '';
    $final_icon = '';

    if (!empty($_FILES['ser_image']['name'])) {
        $ext = pathinfo($_FILES['ser_image']['name'], PATHINFO_EXTENSION);
        $final_name1 = 'vaastu-1-' . time() . '.' . $ext;
        move_uploaded_file($_FILES['ser_image']['tmp_name'], './uploads/vaastu/' . $final_name1);
    }

    if (!empty($_FILES['ser_image_2']['name'])) {
        $ext2 = pathinfo($_FILES['ser_image_2']['name'], PATHINFO_EXTENSION);
        $final_name2 =  'vaastu-2-' . time() . '.' . $ext2;
        move_uploaded_file($_FILES['ser_image_2']['tmp_name'], './uploads/vaastu/' . $final_name2);
    }

    if (!empty($_FILES['ser_icon']['name'])) {
        $ext3 = pathinfo($_FILES['ser_icon']['name'], PATHINFO_EXTENSION);
        $final_icon =  'icon-' . time() . '.' . $ext3;
        move_uploaded_file($_FILES['ser_icon']['tmp_name'], './uploads/vaastu/icon/' . $final_icon);
    }

    // Insert data into database
    $statement = $pdo->prepare("INSERT INTO tbl_vaastu (
        ser_name,
        ser_image,
        ser_image_2,
        ser_description,
        sub_heading_2,
        description_2,
        ser_meta_title,
        ser_meta_keyword,
        ser_meta_descr,
        ser_icon,
        status,
        map_status,
        page_order
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)");

    $statement->execute([
        $_POST['ser_name'],
        $final_name1,
        $final_name2,
        $_POST['ser_description'],
        $_POST['sub_heading_2'],
        $_POST['description_2'],
        $_POST['ser_meta_title'],
        $_POST['ser_meta_keyword'],
        $_POST['ser_meta_descr'],
        $final_icon,
        $_POST['status'],
        $_POST['map_status'],
        $_POST['page_order']
    ]);

    $ai_id = $pdo->lastInsertId();

    // Create slug
    $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['ser_name'])));
    $slug_url = rtrim($slug_url, '-');

    // Update product with code & slug
    $statement = $pdo->prepare("UPDATE tbl_vaastu SET  url = ? WHERE id = ?");
    $statement->execute([ $slug_url, $ai_id]);

    $success_message = "Vaastu added successfully.";
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Vaastus</h1>
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
                            <label class="col-sm-3 control-label">Vaastu Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="ser_name" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Icon Image</label>
                            <div class="col-sm-4">
                                <input type="file" name="ser_icon">
                                <small class="text-muted">Image Size :- 500px Width And 500px Height</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Vaastu Image <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="file" name="ser_image" required>
                                <small class="text-muted">Image Size :- 700px Width And 600px Height</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="ser_description" class="form-control" cols="30" rows="5" id="editor1"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sub Heading 2</label>
                            <div class="col-sm-4">
                                <input type="text" name="sub_heading_2" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Vaastu Image 2</label>
                            <div class="col-sm-4">
                                <input type="file" name="ser_image_2">
                                <small class="text-muted">Image Size :- 700px Width And 600px Height</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description 2</label>
                            <div class="col-sm-8">
                                <textarea name="description_2" class="form-control" cols="30" rows="5" id="editor2"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Title <span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="ser_meta_title" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Keyword <span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="ser_meta_keyword" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Description</label>
                            <div class="col-sm-8">
                                <textarea name="ser_meta_descr" class="form-control" cols="30" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Show In Menu?</label>
                            <div class="col-sm-8">
                                <select name="status" class="form-control" style="width:auto;" required>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Map-Only Consultation </label>
                            <div class="col-sm-8">
                                <select name="map_status" class="form-control" style="width:auto;" required>
                                    <option value="block">Yes</option>
                                    <option value="none">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Page Order</label>
                            <div class="col-sm-2">
                                <input type="number" name="page_order" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success" name="form1">Add Vaastus</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
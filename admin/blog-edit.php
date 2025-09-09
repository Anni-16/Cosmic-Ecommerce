<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;

    if (empty($_POST['blo_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a category<br>";
    }

    if (empty($_POST['b_name'])) {
        $valid = 0;
        $error_message .= "Blog name can not be empty<br>";
    }

    $path = $_FILES['b_image']['name'];
    $path_tmp = $_FILES['b_image']['tmp_name'];

    if ($path != '') {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $file_name = basename($path, '.' . $ext);
        if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }


    if ($valid == 1) {

        $blog_id = $_REQUEST['id'];

        if ($path == '') {
            // Update blog without changing the image
            $statement = $pdo->prepare("UPDATE tbl_blog SET 
                b_name = ?, 
                b_description = ?,
                b_meta_title = ?,
                b_meta_keyword = ?,
                b_meta_desc = ?,
                status = ?,
                blo_id = ?
                WHERE b_id = ?");
            $statement->execute([
                $_POST['b_name'],
                $_POST['b_description'],
                $_POST['b_meta_title'],
                $_POST['b_meta_keyword'],
                $_POST['b_meta_desc'],
                $_POST['status'],
                $_POST['blo_id'],
                $blog_id
            ]);
        } else {
            // Delete old image if exists
            if (!empty($_POST['current_photo']) && file_exists('' . $_POST['current_photo'])) {
                unlink('./uploads/blog/' . $_POST['current_photo']);
            }

            $final_name = 'blog-' . $blog_id . '.' . $ext;
            $target_dir = './uploads/blog/';

            // Create the folder if it doesn't exist
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            move_uploaded_file($path_tmp, $target_dir . $final_name);

            // Update blog including new image
            $statement = $pdo->prepare("UPDATE tbl_blog SET 
                b_name = ?, 
                b_image = ?, 
                b_description = ?,
                b_meta_title = ?,
                b_meta_keyword = ?,
                b_meta_desc = ?,
                status = ?,
                blo_id = ?
                WHERE b_id = ?");
            $statement->execute([
                $_POST['b_name'],
                $final_name,
                $_POST['b_description'],
                $_POST['b_meta_title'],
                $_POST['b_meta_keyword'],
                $_POST['b_meta_desc'],
                $_POST['status'],
                $_POST['blo_id'],
                $blog_id
            ]);
        }

        // Generate slug from blog title
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['b_name'])));
        $slug_url = rtrim($slug_url, '-');

        // Update blog URL slug
        $stmt2 = $pdo->prepare("UPDATE tbl_blog SET url = ? WHERE b_id = ?");
        $stmt2->execute([$slug_url, $blog_id]);

        $success_message = 'Blog post updated successfully.';
    }
}
?>

<?php
if (!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    // Check the id is valid or not
    $statement = $pdo->prepare("SELECT * FROM tbl_blog WHERE b_id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    if ($total == 0) {
        header('location: logout.php');
        exit;
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Blogs</h1>
    </div>
    <div class="content-header-right">
        <a href="blog.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_blog WHERE b_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $b_name = $row['b_name'];
    $b_image = $row['b_image'];
    $b_description = $row['b_description'];
    $b_meta_title = $row['b_meta_title'];
    $b_meta_keyword = $row['b_meta_keyword'];
    $b_meta_desc = $row['b_meta_desc'];
    $status = $row['status'];
    $blo_id = $row['blo_id'];
}

$statement = $pdo->prepare("SELECT * 
                        FROM tbl_blog_category 
                        WHERE blo_id=?");
$statement->execute(array($blo_id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $blo_name = $row['blo_name'];
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

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="blo_id" class="form-control select2 top-cat">
                                    <option value="">Select Category</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_blog_category ORDER BY blo_name ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                    ?>
                                        <option value="<?php echo $row['blo_id']; ?>" <?php if ($row['blo_id'] == $blo_id) {
                                                                                            echo 'selected';
                                                                                        } ?>><?php echo $row['blo_name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Blog Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="b_name" class="form-control" value="<?php echo $b_name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Existing Featured Photo</label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <img src="./uploads/blog/<?php echo $b_image; ?>" alt="" style="width:150px;">
                                <input type="hidden" name="current_photo" value="<?php echo $b_image; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Change Featured Photo </label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <input type="file" name="b_image">
                                <small class="text-muted">Image Size :- 1920px Width And 700px Height</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="b_description" class="form-control" cols="30" rows="10" id="editor2"><?php echo $b_description; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Meta Title <span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="b_meta_title" class="form-control" value="<?php echo $b_meta_title; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Meta Keyword <span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="b_meta_keyword" class="form-control" value="<?php echo $b_meta_keyword; ?>rd">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Meta Description *</label>
                            <div class="col-sm-8">
                                <textarea name="b_meta_desc" class="form-control" cols="30" rows="10" id="editor2"><?php echo $b_meta_desc; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Show In Menu?</label>
                            <div class="col-sm-8">
                                <select name="status" class="form-control" style="width:auto;" required>
                                    <option value="0" <?php if ($status == '0') {
                                                            echo 'selected';
                                                        } ?>>No</option>
                                    <option value="1" <?php if ($status == '1') {
                                                            echo 'selected';
                                                        } ?>>Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
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
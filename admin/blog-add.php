<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';
    $success_message = '';

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
        if (!in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif'])) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    } else {
        $valid = 0;
        $error_message .= 'You must have to select a featured photo<br>';
    }

    if ($valid == 1) {
        $upload_path ='./uploads/blog/';
        
        if (is_dir($upload_path)) {
            $final_name = 'blog-' . time() . '.' . $ext;

            if (move_uploaded_file($path_tmp, $upload_path . $final_name)) {
                $statement = $pdo->prepare("INSERT INTO tbl_blog (
                    b_name,
                    b_image,
                    b_description,
                    b_meta_title,
                    b_meta_keyword,
                    b_meta_desc,
                    status,
                    blo_id
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $statement->execute([
                    $_POST['b_name'],
                    $final_name,
                    $_POST['b_description'],
                    $_POST['b_meta_title'],
                    $_POST['b_meta_keyword'],
                    $_POST['b_meta_desc'],
                    $_POST['status'],
                    $_POST['blo_id']
                ]);

                $blog_id = $pdo->lastInsertId();

                // Create SEO-friendly slug
                $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['b_name'])));
                $slug_url = rtrim($slug_url, '-');

                // Update slug in DB
                $statement = $pdo->prepare("UPDATE tbl_blog SET url = ? WHERE b_id = ?");
                $statement->execute([$slug_url, $blog_id]);

                // Success – redirect to blog.php
                header("Location: blog.php");
                exit;

            } else {
                $error_message .= "File upload failed. Check folder permissions.<br>";
            }
        } else {
            $error_message .= "Upload folder does not exist. Please create it manually.<br>";
        }
    }
}
?>



<section class="content-header">
    <div class="content-header-left">
        <h1>Add Blogs</h1>
    </div>
    <div class="content-header-right">
        <a href="blog.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>


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
                                        <option value="<?php echo $row['blo_id']; ?>"><?php echo $row['blo_name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Blog Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="b_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Image <span>*</span></label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <input type="file" name="b_image">
                                <small class="text-muted">Image Size :- 1920px Width And 700px Height</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="b_description" class="form-control" cols="30" rows="10" id="editor2"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Meta Title <span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="b_meta_title" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Meta Keyword <span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="b_meta_keyword" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Meta Description</label>
                            <div class="col-sm-8">
                                <textarea name="b_meta_desc" class="form-control" cols="30" rows="10" id="editor2"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Show In Menu?</label>
                            <div class="col-sm-8">
                                <select name="status" class="form-control" style="width:auto;" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form1">Add Blog</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>


        </div>
    </div>

</section>

<?php require_once('footer.php'); ?>
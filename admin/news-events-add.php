<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';
    $success_message = '';

    // Required field: News Name
    if (empty($_POST['b_name'])) {
        $valid = 0;
        $error_message .= "News name cannot be empty<br>";
    }
    if (empty($_POST['status'])) {
        $valid = 0;
        $error_message .= "Status cannot be empty<br>";
    }

    // Required field: Featured Image
    $path = $_FILES['b_image']['name'];
    $path_tmp = $_FILES['b_image']['tmp_name'];

    if ($path != '') {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $file_name = basename($path, '.' . $ext);
        if (!in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif'])) {
            $valid = 0;
            $error_message .= 'You must upload jpg, jpeg, gif or png file for featured image<br>';
        }
    } else {
        $valid = 0;
        $error_message .= 'You must select a featured image<br>';
    }

    if ($valid == 1) {
        $upload_path = './uploads/news/';
        $gallery_upload_path = './uploads/news/gallery/';


        $final_name = 'news-' . time() . '.' . $ext;

        if (move_uploaded_file($path_tmp, $upload_path . $final_name)) {
            // Insert into tbl_news
            $statement = $pdo->prepare("INSERT INTO tbl_news (
                b_name,
                b_image,
                b_description,
                b_meta_title,
                b_meta_keyword,
                b_meta_desc,
                status,
                page_order
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $statement->execute([
                $_POST['b_name'],
                $final_name,
                $_POST['b_description'],
                $_POST['b_meta_title'],
                $_POST['b_meta_keyword'],
                $_POST['b_meta_desc'],
                $_POST['status'],
                $_POST['page_order']
            ]);

            $blog_id = $pdo->lastInsertId();

            // Create slug
            $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['b_name'])));
            $slug_url = rtrim($slug_url, '-');

            // Ensure uniqueness (basic)
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM tbl_news WHERE url = ?");
            $stmt->execute([$slug_url]);
            $slug_count = $stmt->fetchColumn();
            if ($slug_count > 0) {
                $slug_url .= '-' . $blog_id;
            }

            // Update slug in DB
            $statement = $pdo->prepare("UPDATE tbl_news SET url = ? WHERE news_id = ?");
            $statement->execute([$slug_url, $blog_id]);

            // Handle multiple gallery images
            if (!empty($_FILES['gallery_images']['name'][0])) {
                $gallery_files = $_FILES['gallery_images'];
                $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];

                for ($i = 0; $i < count($gallery_files['name']); $i++) {
                    $gallery_name = $gallery_files['name'][$i];
                    $gallery_tmp = $gallery_files['tmp_name'][$i];
                    $gallery_ext = strtolower(pathinfo($gallery_name, PATHINFO_EXTENSION));

                    if (in_array($gallery_ext, $allowed_exts)) {
                        $new_gallery_name = 'news-gallery-' . time() . '-' . $i . '.' . $gallery_ext;
                        if (move_uploaded_file($gallery_tmp, $gallery_upload_path . $new_gallery_name)) {
                            $stmt = $pdo->prepare("INSERT INTO tbl_news_photo (news_id, photo) VALUES (?, ?)");
                            $stmt->execute([$blog_id, $new_gallery_name]);
                        }
                    }
                }
            }

            // Redirect on success
            header("Location: news-events.php");
            exit;
        } else {
            $error_message .= "File upload failed. Check folder permissions.<br>";
        }
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add News & Events</h1>
    </div>
    <div class="content-header-right">
        <a href="news-events.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <?php if (!empty($error_message)) : ?>
                <div class="callout callout-danger"><p><?php echo $error_message; ?></p></div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="box box-info">
                    <div class="box-body">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">News & Events Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="b_name" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Featured Image <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="file" name="b_image" required>
                                <small class="text-muted">Image Size :- 1250px Width And 850px Height</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Gallery Images</label>
                            <div class="col-sm-4">
                                <input type="file" name="gallery_images[]" multiple>
                                <small class="text-muted">Upload multiple images (JPG, JPEG, PNG, GIF) by using Ctrl + Click (or Command + Click on Mac) to select multiple Images at once</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="b_description" class="form-control" rows="10" id="editor1"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Title <span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="b_meta_title" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Keyword <span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="b_meta_keyword" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Description</label>
                            <div class="col-sm-8">
                                <textarea name="b_meta_desc" class="form-control" rows="5" ></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Show In Menu?</label>
                            <div class="col-sm-3">
                                <select name="status" class="form-control" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Page Order</label>
                            <div class="col-sm-2">
                                <input type="number" name="page_order" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-success" name="form1">Add News & Events</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>

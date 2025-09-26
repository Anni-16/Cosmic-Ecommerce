<?php require_once('header.php'); ?>

<?php
// Get the news id
if (!isset($_REQUEST['id'])) {
    // Redirect or show error
    header("Location: news-events.php");
    exit;
}
$news_id = $_REQUEST['id'];

// Fetch existing news record
$stmt = $pdo->prepare("SELECT * FROM tbl_news WHERE news_id = ?");
$stmt->execute([$news_id]);
$news = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$news) {
    // No such news
    header("Location: news-events.php");
    exit;
}

// Fetch existing gallery images
$stmt2 = $pdo->prepare("SELECT * FROM tbl_news_photo WHERE news_id = ?");
$stmt2->execute([$news_id]);
$gallery_images = $stmt2->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';
    $success_message = '';

    // Validate required fields
    if (empty($_POST['b_name'])) {
        $valid = 0;
        $error_message .= "News name cannot be empty<br>";
    }
    if (empty($_POST['status'])) {
        $valid = 0;
        $error_message .= "status cannot be empty<br>";
    }
  

    // Handle main image (optional)
    $path = $_FILES['b_image']['name'];
    $path_tmp = $_FILES['b_image']['tmp_name'];
    $ext = '';
    if ($path != '') {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if (!in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif'])) {
            $valid = 0;
            $error_message .= "You must upload jpg, jpeg, png, or gif for the main image<br>";
        }
    }

    if ($valid == 1) {
        $upload_path = './uploads/news/';
        $gallery_upload_path = './uploads/news/gallery/';

        $final_main_image = $news['b_image']; // default to existing

        // If new main image uploaded, replace
        if ($path != '') {
            $final_main_image = 'news-' . time() . '.' . $ext;
            if (!move_uploaded_file($path_tmp, $upload_path . $final_main_image)) {
                $error_message .= "Main image upload failed. Check folder permissions.<br>";
                $valid = 0;
            } else {
                // Optionally: delete old main image file
                $old = $upload_path . $news['b_image'];
                if (is_file($old)) {
                    @unlink($old);
                }
            }
        }

        if ($valid == 1) {
            // Update tbl_news
            $stmt = $pdo->prepare("UPDATE tbl_news SET
                b_name = ?,
                b_image = ?,
                b_description = ?,
                b_meta_title = ?,
                b_meta_keyword = ?,
                b_meta_desc = ?,
                status = ?,
                page_order = ?
                WHERE news_id = ?");
            $stmt->execute([
                $_POST['b_name'],
                $final_main_image,
                $_POST['b_description'],
                $_POST['b_meta_title'],
                $_POST['b_meta_keyword'],
                $_POST['b_meta_desc'],
                $_POST['status'],
                $_POST['page_order'],
                $news_id
            ]);

            // Update slug (you might want to keep old slug if exists)
            $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['b_name'])));
            $slug_url = rtrim($slug_url, '-');

            // Check slug uniqueness (excluding this record)
            $stmtSl = $pdo->prepare("SELECT COUNT(*) FROM tbl_news WHERE url = ? AND news_id != ?");
            $stmtSl->execute([$slug_url, $news_id]);
            $countSlug = $stmtSl->fetchColumn();
            if ($countSlug > 0) {
                $slug_url .= '-' . $news_id;
            }
            $stmtUp = $pdo->prepare("UPDATE tbl_news SET url = ? WHERE news_id = ?");
            $stmtUp->execute([$slug_url, $news_id]);

            // Handle new gallery images
            if (!empty($_FILES['gallery_images']['name'][0])) {
                $gallery_files = $_FILES['gallery_images'];
                $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];

                for ($i = 0; $i < count($gallery_files['name']); $i++) {
                    $g_name = $gallery_files['name'][$i];
                    $g_tmp = $gallery_files['tmp_name'][$i];
                    $g_ext = strtolower(pathinfo($g_name, PATHINFO_EXTENSION));

                    if (in_array($g_ext, $allowed_exts)) {
                        $new_g_name = 'news-gallery-' . time() . '-' . $i . '.' . $g_ext;
                        if (move_uploaded_file($g_tmp, $gallery_upload_path . $new_g_name)) {
                            $stmtIns = $pdo->prepare("INSERT INTO tbl_news_photo (news_id, photo) VALUES (?, ?)");
                            $stmtIns->execute([$news_id, $new_g_name]);
                        }
                    }
                }
            }

            $success_message = "News has been updated successfully.";
            // Optionally reload the page to see changes
            header("Location: news-events.php");
        }
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit News & Events</h1>
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
            <?php if (!empty($success_message)) : ?>
                <div class="callout callout-success"><p><?php echo $success_message; ?></p></div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="box box-info">
                    <div class="box-body">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">News & Events Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="b_name" class="form-control"
                                       value="<?php echo ($news['b_name']); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Existing Featured Image</label>
                            <div class="col-sm-4">
                                <?php if ($news['b_image'] != '') : ?>
                                    <img src="./uploads/news/<?php echo $news['b_image']; ?>"
                                         style="max-width:200px;">
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Change Featured Image</label>
                            <div class="col-sm-4">
                                <input type="file" name="b_image">
                                <small class="text-muted">Leave blank to keep existing image & Image Size :- 1250px Width And 850px Height</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Existing Gallery Images</label>
                            <div class="col-sm-8">
                                <?php foreach ($gallery_images as $g) : ?>
                                    <div style="display:inline-block; margin:5px; text-align:center;">
                                        <img src="./uploads/news/gallery/<?php echo $g['photo']; ?>"
                                             style="max-width:150px; display:block;">
                                        <input type="checkbox" name="delete_gallery_ids[]"
                                               value="<?php echo $g['id']; ?>"> Delete
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Add More Gallery Images</label>
                            <div class="col-sm-4">
                                <input type="file" name="gallery_images[]" multiple>
                                <small class="text-muted">You can upload additional images & Upload multiple images (JPG, JPEG, PNG, GIF) by using Ctrl + Click (or Command + Click on Mac) to select multiple Images at once</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="b_description" class="form-control" rows="10"
                                          id="editor1"><?php echo ($news['b_description']); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Title <span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="b_meta_title" class="form-control"
                                       value="<?php echo ($news['b_meta_title']); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Keyword <span>*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="b_meta_keyword" class="form-control"
                                       value="<?php echo ($news['b_meta_keyword']); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Description</label>
                            <div class="col-sm-8">
                                <textarea name="b_meta_desc" class="form-control" rows="5"
                                          id="editor2"><?php echo ($news['b_meta_desc']); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Show In Menu?</label>
                            <div class="col-sm-8">
                                <select name="status" class="form-control" required>
                                    <option value="0" <?php if ($news['status'] == 0) echo 'selected'; ?>>No</option>
                                    <option value="1" <?php if ($news['status'] == 1) echo 'selected'; ?>>Yes</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Page Order</label>
                            <div class="col-sm-2">
                                <input type="number" name="page_order" class="form-control"
                                       value="<?php echo ($news['page_order']); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" name="form1" class="btn btn-success">Update News & Events</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
</section>

<?php
// After form submission: Delete selected gallery images
if (isset($_POST['delete_gallery_ids']) && is_array($_POST['delete_gallery_ids'])) {
    foreach ($_POST['delete_gallery_ids'] as $del_id) {
        // Fetch the record to delete its file
        $stmtDel = $pdo->prepare("SELECT photo FROM tbl_news_photo WHERE id = ? AND news_id = ?");
        $stmtDel->execute([$del_id, $news_id]);
        $rowDel = $stmtDel->fetch(PDO::FETCH_ASSOC);
        if ($rowDel) {
            $filename = './uploads/news/gallery/' . $rowDel['photo'];
            if (is_file($filename)) {
                @unlink($filename);
            }
            // Delete DB record
            $stmtDel2 = $pdo->prepare("DELETE FROM tbl_news_photo WHERE id = ?");
            $stmtDel2->execute([$del_id]);
        }
    }
    // After deletion, redirect back to avoid resubmission
    header("Location: news-events-edit.php?id=" . $news_id);
    exit;
}

require_once('footer.php');
?>

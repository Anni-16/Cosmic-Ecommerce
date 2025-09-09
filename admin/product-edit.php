<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    // Validate required fields
    if (empty($_POST['cat_id'])) {
        $valid = 0;
        $error_message .= "You must select a top-level category<br>";
    }
    if (empty($_POST['a_name'])) {
        $valid = 0;
        $error_message .= "Product name cannot be empty<br>";
    }
    if (empty($_POST['a_current_price'])) {
        $valid = 0;
        $error_message .= "Current Price cannot be empty<br>";
    }
    if (empty($_POST['a_available'])) {
        $valid = 0;
        $error_message .= "Availability cannot be empty<br>";
    }

    // Validate featured photo if uploaded
    $path = $_FILES['a_photo']['name'];
    $path_tmp = $_FILES['a_photo']['tmp_name'];
    if ($path != '' && $_FILES['a_photo']['error'] == UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            $valid = 0;
            $error_message .= 'Featured photo must be a JPG, JPEG, PNG, or GIF file<br>';
        }
    }

    // Validate upload directory
    $upload_dir = './uploads/products/';
    if (!is_dir($upload_dir) || !is_writable($upload_dir)) {
        $valid = 0;
        $error_message .= 'Upload directory does not exist or is not writable<br>';
    }

    if ($valid == 1) {
        try {
            // Handle multiple photos
            $final_name1 = [];
            if (!empty($_FILES['photo']['name'][0]) && $_FILES['photo']['error'][0] == UPLOAD_ERR_OK) {
                $photo_count = count($_FILES['photo']['name']);
                for ($i = 0; $i < $photo_count; $i++) {
                    if ($_FILES['photo']['error'][$i] == UPLOAD_ERR_OK) {
                        $photo_ext = strtolower(pathinfo($_FILES['photo']['name'][$i], PATHINFO_EXTENSION));
                        if (in_array($photo_ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                            $unique_name = uniqid() . '_' . $i . '.' . $photo_ext; // Unique filename
                            $destination = $upload_dir . $unique_name;
                            if (move_uploaded_file($_FILES['photo']['tmp_name'][$i], $destination)) {
                                $final_name1[] = $unique_name;
                            } else {
                                $error_message .= "Failed to upload photo: {$_FILES['photo']['name'][$i]}<br>";
                            }
                        } else {
                            $error_message .= "Invalid file type for photo: {$_FILES['photo']['name'][$i]}<br>";
                        }
                    }
                }
            }

            // Insert multiple photos into tbl_product_photo
            if (!empty($final_name1)) {
                $statement = $pdo->prepare("INSERT INTO tbl_product_photo (photo, a_id) VALUES (?, ?)");
                foreach ($final_name1 as $photo_name) {
                    $statement->execute([$photo_name, $_REQUEST['id']]);
                }
            }

            // Generate URL-friendly slug
            $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['a_name'])));
            $url = rtrim($slug_url, '-');

            // Update tbl_product
            if ($path == '') {
                $statement = $pdo->prepare("UPDATE tbl_product SET 
                    a_name=?, url=?, a_current_price=?, a_available=?,
                    a_stock_qty=?, a_short_desc=?, a_content=?,meta_title=?,meta_keyword=?,meta_descr=?, a_is_featured=?,
                    a_is_active=?, cat_id=? WHERE a_id=?");
                $statement->execute([
                    $_POST['a_name'], $url, $_POST['a_current_price'],
                    $_POST['a_available'], $_POST['a_stock_qty'], $_POST['a_short_desc'],
                    $_POST['a_content'],$_POST['meta_title'], $_POST['meta_keyword'], $_POST['meta_descr'],  $_POST['a_is_featured'], $_POST['a_is_active'],
                    $_POST['cat_id'], $_REQUEST['id']
                ]);
            } else {
                // Delete old photo
                if (file_exists($upload_dir . $_POST['current_photo'])) {
                    unlink($upload_dir . $_POST['current_photo']);
                }

                $file_name = basename($path, '.' . $ext);
                $final_name = $file_name . '.' . $ext;
                move_uploaded_file($path_tmp, $upload_dir . $final_name);

                $statement = $pdo->prepare("UPDATE tbl_product SET 
                    a_name=?, url=?, a_current_price=?, a_available=?,
                    a_stock_qty=?, a_photo=?, a_short_desc=?, a_content=?,meta_title=?,meta_keyword=?,meta_descr=?,
                    a_is_featured=?, a_is_active=?, cat_id=? WHERE a_id=?");
                $statement->execute([
                    $_POST['a_name'], $url, $_POST['a_current_price'],
                    $_POST['a_available'], $_POST['a_stock_qty'], $final_name,
                    $_POST['a_short_desc'], $_POST['a_content'], $_POST['meta_title'], $_POST['meta_keyword'], $_POST['meta_descr'], $_POST['a_is_featured'],
                    $_POST['a_is_active'], $_POST['cat_id'], $_REQUEST['id']
                ]);
            }
 
       
 
            $success_message = 'Product is updated successfully.';
            header('Location: product.php'); // Redirect to list page
        } catch (PDOException $e) {
            $valid = 0;
            $error_message .= "Database error: " . $e->getMessage() . "<br>";
        }
    }
}
?>

<?php
if (!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    // Validate the ID
    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE a_id=?");
    $statement->execute([$_REQUEST['id']]);
    $total = $statement->rowCount();
    if ($total == 0) {
        header('location: logout.php');
        exit;
    }
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    $row = $result[0];
    $a_name = $row['a_name'];
    $a_current_price = $row['a_current_price'];
    $a_available = $row['a_available'];
    $a_stock_qty = $row['a_stock_qty'];
    $a_photo = $row['a_photo'];
    $a_short_desc = $row['a_short_desc'];
    $a_content = $row['a_content'];
    $meta_title = $row['meta_title'];
    $meta_keyword = $row['meta_keyword'];
    $meta_descr = $row['meta_descr'];
    $a_is_featured = $row['a_is_featured'];
    $a_is_active = $row['a_is_active'];
    $cat_id = $row['cat_id'];
}
 

 
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Product</h1>
    </div>
    <div class="content-header-right">
        <a href="product.php" class="btn btn-primary btn-sm">View All</a>
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
                            <label for="" class="col-sm-3 control-label">Category Name <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="cat_id" class="form-control select2 top-cat">
                                    <option value="">Select Category</option>
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_product_category ORDER BY cat_name ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        $selected = $row['cat_id'] == $cat_id ? 'selected' : '';
                                        echo "<option value='{$row['cat_id']}' $selected>{$row['cat_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Product Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="a_name" class="form-control" value="<?php echo ($a_name); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Current Price <span>*</span><br><span style="font-size:10px;font-weight:normal;">(In Rupees)</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="a_current_price" class="form-control" value="<?php echo ($a_current_price); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Product QTY <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="a_stock_qty" class="form-control" value="<?php echo ($a_stock_qty); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Available Stock?</label>
                            <div class="col-sm-8">
                                <select name="a_available" class="form-control" style="width:auto;">
                                    <option value="Out Of Stock" <?php echo $a_available == 'Out Of Stock' ? 'selected' : ''; ?>>Out Of Stock</option>
                                    <option value="In Stock" <?php echo $a_available == 'In Stock' ? 'selected' : ''; ?>>In Stock</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Existing Featured Photo</label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <img src="./uploads/products/<?php echo ($a_photo); ?>" alt="" style="width:150px;">
                                <input type="hidden" name="current_photo" value="<?php echo ($a_photo); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Change Featured Photo</label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <input type="file" name="a_photo" accept="image/jpeg,image/png,image/gif">
                                <small class="text-muted">Image Size :- 270px Width And 320px Height</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Other Photos</label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <table id="ProductTable" style="width:100%;">
                                    <tbody>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE a_id=?");
                                        $statement->execute([$_REQUEST['id']]);
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            echo "
                                                <tr>
                                                    <td>
                                                        <img src='./uploads/products/{$row['photo']}' alt='{$a_name}' style='width:150px;margin-bottom:5px;'>
                                                    </td>
                                                    <td style='width:28px;'>
                                                        <a onclick='return confirmDelete();' href='product-other-photo-delete.php?id={$row['aa_id']}&id1={$_REQUEST['id']}' class='btn btn-danger btn-xs'>X</a>
                                                    </td>
                                                </tr>
                                            ";
                                        }
                                        ?>
                                        <tr class="new-photo-row">
                                            <td>
                                                <div class="upload-btn">
                                                    <input type="file" name="photo[]" accept="image/jpeg,image/png,image/gif" style="margin-bottom:5px;">
                                                    <small class="text-muted">Image Size :- 270px Width And 320px Height</small>
                                                </div>
                                            </td>
                                            <td style="width:28px;">
                                                <a href="javascript:void(0)" class="Delete btn btn-danger btn-xs">X</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-2">
                                <input type="button" id="btnAddNew" value="Add Item" style="margin-top: 5px;margin-bottom:10px;border:0;color: #fff;font-size: 14px;border-radius:3px;" class="btn btn-warning btn-xs">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Short Description</label>
                            <div class="col-sm-8">
                                <textarea name="a_short_desc" class="form-control" cols="30" rows="10" id="editor1"><?php echo ($a_short_desc); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="a_content" class="form-control" cols="30" rows="10" id="editor2"><?php echo ($a_content); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Title</label>
                            <div class="col-sm-8">
                                <input type="text" name="meta_title" class="form-control" value="<?php echo ($meta_title); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Keyword</label>
                            <div class="col-sm-8">
                                <input type="text" name="meta_keyword" class="form-control" value="<?php echo ($meta_keyword); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Description</label>
                            <div class="col-sm-8">
                                <textarea name="meta_descr" class="form-control" rows="4"><?php echo ($meta_descr); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Is Featured?</label>
                            <div class="col-sm-8">
                                <select name="a_is_featured" class="form-control" style="width:auto;" required>
                                    <option value="0" <?php echo $a_is_featured == '0' ? 'selected' : ''; ?>>No</option>
                                    <option value="1" <?php echo $a_is_featured == '1' ? 'selected' : ''; ?>>Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Is Active?</label>
                            <div class="col-sm-8">
                                <select name="a_is_active" class="form-control" style="width:auto;" required>
                                    <option value="0" <?php echo $a_is_active == '0' ? 'selected' : ''; ?>>No</option>
                                    <option value="1" <?php echo $a_is_active == '1' ? 'selected' : ''; ?>>Yes</option>
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

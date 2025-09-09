<?php require_once('header.php');

if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    // Validate category
    if (empty($_POST['cat_id'])) {
        $valid = 0;
        $error_message .= "You must select a category<br>";
    }

    // Validate product name
    if (empty($_POST['a_name'])) {
        $valid = 0;
        $error_message .= "Product name cannot be empty<br>";
    }

    // Validate price
    if (empty($_POST['a_current_price'])) {
        $valid = 0;
        $error_message .= "Current price cannot be empty<br>";
    }

    // Validate availability
    if (empty($_POST['a_available'])) {
        $valid = 0;
        $error_message .= "Availability cannot be empty<br>";
    }

    // Validate featured photo
    $path = $_FILES['a_photo']['name'] ?? '';
    $path_tmp = $_FILES['a_photo']['tmp_name'] ?? '';
    $ext = '';

    if ($path != '') {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            $valid = 0;
            $error_message .= "You must upload a JPG, JPEG, PNG or GIF file<br>";
        }
    } else {
        $valid = 0;
        $error_message .= "You must select a featured photo<br>";
    }

    // Create upload folder if not exists
    $upload_dir = './uploads/products/';

    if ($valid == 1) {
        // Get next product ID
        $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_product'");
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $ai_id = $result['Auto_increment'];

        // Multiple photos upload
        if (!empty($_FILES['photo']["name"][0])) {
            $photo = array_values(array_filter($_FILES['photo']["name"]));
            $photo_temp = array_values(array_filter($_FILES['photo']["tmp_name"]));

            // Get next product photo ID
            $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_product_photo'");
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $next_id1 = $result['Auto_increment'];

            $z = $next_id1;
            $final_name1 = [];

            for ($i = 0; $i < count($photo); $i++) {
                $my_ext1 = strtolower(pathinfo($photo[$i], PATHINFO_EXTENSION));
                if (in_array($my_ext1, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $new_name = $z . '.' . $my_ext1;
                    move_uploaded_file($photo_temp[$i], $upload_dir . $new_name);
                    $final_name1[] = $new_name;
                    $z++;
                }
            }

            if (!empty($final_name1)) {
                foreach ($final_name1 as $p_name) {
                    $statement = $pdo->prepare("INSERT INTO tbl_product_photo (photo,a_id) VALUES (?,?)");
                    $statement->execute([$p_name, $ai_id]);
                }
            }
        }

        // Upload featured photo
        $final_name = 'product-featured-' . $ai_id . '.' . $ext;
        move_uploaded_file($path_tmp, $upload_dir . $final_name);

        // Insert product data
        $statement = $pdo->prepare("INSERT INTO tbl_product(
            a_name, 
            a_current_price,
            a_available,
            a_stock_qty,
            a_photo,
            a_short_desc,
            a_content,
            meta_title,
            meta_keyword,
            meta_descr,
            a_is_featured,
            a_is_active,
            cat_id
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");

        $statement->execute([
            $_POST['a_name'],
            $_POST['a_current_price'],
            $_POST['a_available'],
            $_POST['a_stock_qty'],
            $final_name,
            $_POST['a_short_desc'],
            $_POST['a_content'],
            $_POST['meta_title'],
            $_POST['meta_keyword'],
            $_POST['meta_descr'],
            $_POST['a_is_featured'],
            $_POST['a_is_active'],
            $_POST['cat_id']
        ]);

        $ai_id = $pdo->lastInsertId();
        $a_code = 'Product-00' . $ai_id;

        // Create slug
        $slug_url = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['a_name'])));
        $slug_url = rtrim($slug_url, '-');

        // Update product with code & slug
        $statement = $pdo->prepare("UPDATE tbl_product SET a_code = ?, url = ? WHERE a_id = ?");
        $statement->execute([$a_code, $slug_url, $ai_id]);


        $success_message = 'Product is added successfully.';
    }
}
?>


<section class="content-header">
    <div class="content-header-left">
        <h1>Add Products</h1>
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

                    <p>
                        <?php echo $error_message; ?>
                    </p>
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
                                    ?>
                                        <option value="<?php echo $row['cat_id']; ?>"><?php echo $row['cat_name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Product Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="a_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Current Price <span>*</span><br><span style="font-size:10px;font-weight:normal;">(In Rupees)</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="a_current_price" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Product QTY * </label>
                            <div class="col-sm-4">
                                <input type="text" name="a_stock_qty" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Available </label>
                            <div class="col-sm-8">
                                <select name="a_available" class="form-control" style="width:auto;">
                                    <option value="Out Of Stock">Out Of Stock</option>
                                    <option value="In Stock">In Stock</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Featured Photo <span>*</span></label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <input type="file" name="a_photo">
                                <small class="text-muted">Image Size :- 270px Width And 320px Height</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Other Photos</label>
                            <div class="col-sm-4" style="padding-top:4px;">
                                <table id="ProductTable" style="width:100%;">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="upload-btn">
                                                    <input type="file" name="photo[]" style="margin-bottom:5px;">
                                                    <small class="text-muted">Image Size :- 270px Width And 320px Height</small>
                                                </div>
                                            </td>
                                            <td style="width:28px;"><a href="javascript:void()" class="Delete btn btn-danger btn-xs">X</a></td>
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
                                <textarea name="a_short_desc" class="form-control" cols="30" rows="10" id="editor1"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="a_content" class="form-control" cols="30" rows="10" id="editor2"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Title</label>
                            <div class="col-sm-8">
                                <input type="text" name="meta_title" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Keyword</label>
                            <div class="col-sm-8">
                                <input type="text" name="meta_keyword" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Meta Description</label>
                            <div class="col-sm-8">
                                <textarea name="meta_descr" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Is Featured?</label>
                            <div class="col-sm-8">
                                <select name="a_is_featured" class="form-control" style="width:auto;">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Is Active?</label>
                            <div class="col-sm-8">
                                <select name="a_is_active" class="form-control" style="width:auto;" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form1">Add Product</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>


        </div>
    </div>

</section>

<?php require_once('footer.php'); ?>
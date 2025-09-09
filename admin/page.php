<?php require_once('header.php'); ?>

<?php
// About Page Content Start

if (isset($_POST['form_about'])) {

    $valid = 1;
    $error_message = '';

    if (empty($_POST['short_desc'])) {
        $valid = 0;
        $error_message .= 'Content cannot be empty<br>';
    }

    // Fetch current images from database
    $statement = $pdo->prepare("SELECT * FROM tbl_about WHERE id=1");
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    $current_image  = $row['image']  ?? '';
    $current_image2 = $row['image2'] ?? '';

    /* =========================
       Image 1 Upload Handling
    ========================== */
    $path = $_FILES['image']['name'] ?? '';
    $path_tmp = $_FILES['image']['tmp_name'] ?? '';

    if ($path != '') {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            $valid = 0;
            $error_message .= 'You must upload a JPG, JPEG, PNG, or GIF file for Image 1<br>';
        } else {
            $image = 'about_' . time() . '.' . $ext;
            move_uploaded_file($path_tmp, './uploads/accessroies/about/' . $image);

            // Remove old image
            if (!empty($current_image) && file_exists('./uploads/accessroies/about/' . $current_image)) {
                unlink('./uploads/accessroies/about/' . $current_image);
            }
        }
    } else {
        $image = $current_image; // Keep old image if not uploaded
    }

    /* =========================
       Image 2 Upload Handling
    ========================== */
    $path2 = $_FILES['image2']['name'] ?? '';
    $path_tmp2 = $_FILES['image2']['tmp_name'] ?? '';

    if ($path2 != '') {
        $ext2 = strtolower(pathinfo($path2, PATHINFO_EXTENSION));
        if (!in_array($ext2, ['jpg', 'jpeg', 'png', 'gif'])) {
            $valid = 0;
            $error_message .= 'You must upload a JPG, JPEG, PNG, or GIF file for Image 2<br>';
        } else {
            $image2 = 'about2_' . time() . '.' . $ext2;
            move_uploaded_file($path_tmp2, './uploads/accessroies/about/' . $image2);

            // Remove old image2
            if (!empty($current_image2) && file_exists('./uploads/accessroies/about/' . $current_image2)) {
                unlink('./uploads/accessroies/about/' . $current_image2);
            }
        }
    } else {
        $image2 = $current_image2; // Keep old image2 if not uploaded
    }

    /* =========================
       Update Database
    ========================== */
    if ($valid == 1) {
        $statement = $pdo->prepare("UPDATE tbl_about 
            SET sub_heading=?, short_desc=?, description=?, mission=?, vission=?, 
                meta_title=?, meta_keyword=?, meta_desc=?, image=?, image2=? 
            WHERE id=1");

        $statement->execute([
            $_POST['sub_heading'],
            $_POST['short_desc'],
            $_POST['description'],
            $_POST['mission'],
            $_POST['vission'],
            $_POST['meta_title'],
            $_POST['meta_keyword'],
            $_POST['meta_desc'],
            $image,
            $image2
        ]);

        $success_message = 'About Page Information updated successfully.';
    }
}


// About Page Content End

// Terms & Conditions Page Content Start
if (isset($_POST['form_term_condition'])) {

    $valid = 1;

    if (empty($_POST['heading'])) {
        $valid = 0;
        $error_message .= 'Title can not be empty<br>';
    }

    if ($valid == 1) {
        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_term_conditions SET heading=?,content=? WHERE id=1");
        $statement->execute(array($_POST['heading'], $_POST['content']));
    }

    $success_message = 'Term & Conditions Page Information is updated successfully.';
}
// terms & Conditions Page Content End 


// Privacy Policy Page Content Start
if (isset($_POST['form_privacy_policy'])) {

    $valid = 1;

    if (empty($_POST['heading'])) {
        $valid = 0;
        $error_message .= 'Title can not be empty<br>';
    }

    if ($valid == 1) {
        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_privacy_policy SET heading=?,content=? WHERE id=1");
        $statement->execute(array($_POST['heading'], $_POST['content']));
    }

    $success_message = 'Privacy Policy Page Information is updated successfully.';
}
// Privacy Policy Page Content End

// Return Policy Page Content Start
if (isset($_POST['form_return_policy'])) {

    $valid = 1;

    if (empty($_POST['heading'])) {
        $valid = 0;
        $error_message .= 'Title can not be empty<br>';
    }

    if ($valid == 1) {
        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_return_policy SET heading=?,content=? WHERE id=1");
        $statement->execute(array($_POST['heading'], $_POST['content']));
    }

    $success_message = 'Return Policy Page Information is updated successfully.';
}
// Return Policy Page Content End




// Payment Page Content Start
if (isset($_POST['form_payment'])) {

    $valid = 1;

    if (empty($_POST['heading'])) {
        $valid = 0;
        $error_message .= 'Title can not be empty<br>';
    }

    if ($valid == 1) {
        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_payment_policy SET heading=?,content=? WHERE id=1");
        $statement->execute(array($_POST['heading'], $_POST['content']));
    }

    $success_message = 'Disclaimer Page Information is updated successfully.';
}
// Payment Page Content End 



// Contact Page Content Start
if (isset($_POST['form_contact'])) {

    $valid = 1;

    if ($valid == 1) {

        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_contact SET address=?,phone_no_1=?,phone_no_2=?,email=?,map_links=?,shop_time=? WHERE id=1");
        $statement->execute(array($_POST['address'], $_POST['phone_no_1'], $_POST['phone_no_2'], $_POST['email'], $_POST['map_links'], $_POST['shop_time']));
    }

    $success_message = 'Contact Page Information is updated successfully.';
}
// Contact Page Content End 



?>

<section class="content-header">
    <div class="content-header-left">
        <h1> Manage Page CMS</h1>
    </div>
</section>

<section class="content" style="min-height:auto;margin-bottom: -30px;">
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
        </div>
    </div>
</section>

<section class="content">

    <div class="row">
        <div class="col-md-12">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">About Us</a></li>
                    <li><a href="#tab_3" data-toggle="tab">Terms & Condition</a></li>
                    <li><a href="#tab_4" data-toggle="tab">Privacy Policy</a></li>
                    <li><a href="#tab_5" data-toggle="tab">Returns & Exchange Policy</a></li>
                    <li><a href="#tab_6" data-toggle="tab">Disclaimer</a></li>
                    <li><a href="#tab_7" data-toggle="tab">Contact</a></li>
                </ul>


                <div class="tab-content">
                    <!-- About us Page Content  Start-->
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_about WHERE id=1");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $sub_heading = $row['sub_heading'];
                        $short_desc = $row['short_desc'];
                        $description = $row['description'];
                        $mission = $row['mission'];
                        $vission = $row['vission'];
                        $meta_title = $row['meta_title'];
                        $meta_keyword = $row['meta_keyword'];
                        $meta_desc = $row['meta_desc'];
                        $image = $row['image'];
                        $image2 = $row['image2'];
                    }

                    ?>
                    <div class="tab-pane active" id="tab_1">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Home Page Current Image</label>
                                        <div class="col-sm-6">
                                            <?php if (!empty($image)) : ?>
                                                <img src="./uploads/accessroies/about/<?php echo ($image); ?>" alt="About Image" style="max-width:200px;">
                                            <?php else : ?>
                                                <p>No image uploaded.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Home Page Upload New Image</label>
                                        <div class="col-sm-6">
                                            <input type="file" name="image">
                                            <p style="color:#888;font-size:12px;margin-top:5px;">About Only upload if you want to replace the current image.</p>
                                            <small class="text-muted">Image Size :- 550px Width And 600px Height</small>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">About Page Current Image</label>
                                        <div class="col-sm-6">
                                            <?php if (!empty($image2)) : ?>
                                                <img src="./uploads/accessroies/about/<?php echo ($image2); ?>" alt="About Image" style="max-width:200px;">
                                            <?php else : ?>
                                                <p>No image uploaded.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">About Upload New Image</label>
                                        <div class="col-sm-6">
                                            <input type="file" name="image2">
                                            <p style="color:#888;font-size:12px;margin-top:5px;">About Only upload if you want to replace the current image.</p>
                                            <small class="text-muted">Image Size :- 550px Width And 600px Height</small>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">About Page Sub Heading * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="sub_heading" value="<?php echo $sub_heading; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">About Short Description * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="short_desc" id="editor1"><?php echo $short_desc; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">About Description * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="description" id="editor8"><?php echo $description; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">About Mission * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="mission" id="editor9"><?php echo $mission; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">About Vission * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="vission" id="editor10"><?php echo $vission; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">About Meta Title</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text" name="meta_title" value="<?php echo $meta_title; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">About Meta Keyword </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="meta_keyword" style="height:100px;"><?php echo $meta_keyword; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">About Meta Description </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="meta_desc" style="height:100px;"><?php echo $meta_desc; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form_about">About Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- About Us page Content End  -->



                    <!-- Term & Condition Page Content Start -->
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_term_conditions WHERE id=1");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $heading = $row['heading'];
                        $content = $row['content'];
                    }
                    ?>
                    <div class="tab-pane" id="tab_3">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Page Title * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="heading" value="<?php echo $heading; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Description * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="content" id="editor4"><?php echo $content; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form_term_condition">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Term & Condition Page Content End -->


                    <!-- Privacy Policy Page Content Start -->
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_privacy_policy WHERE id=1");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $heading = $row['heading'];
                        $content = $row['content'];
                    }
                    ?>
                    <div class="tab-pane" id="tab_4">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Page Title * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="heading" value="<?php echo $heading; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Description * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="content" id="editor5"><?php echo $content; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form_privacy_policy">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Privacy Policy Page Content End -->

                    <!-- Return Policy Page Content Start -->
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_return_policy WHERE id=1");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $heading = $row['heading'];
                        $content = $row['content'];
                    }
                    ?>
                    <div class="tab-pane" id="tab_5">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Page Title * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="heading" value="<?php echo $heading; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Description * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="content" id="editor6"><?php echo $content; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form_return_policy">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Return Policy Page Content End -->

                    <!-- Privacy Policy Page Content Start -->
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_payment_policy WHERE id=1");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $heading = $row['heading'];
                        $content = $row['content'];
                    }
                    ?>
                    <div class="tab-pane" id="tab_6">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Page Title * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="heading" value="<?php echo $heading; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Description * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="content" id="editor7"><?php echo $content; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form_payment">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Privacy Policy Page Content End -->

                    <!-- Contact Page Content Start -->
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_contact WHERE id=1");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $address = $row['address'];
                        $phone_no_1 = $row['phone_no_1'];
                        $phone_no_2 = $row['phone_no_2'];
                        $email = $row['email'];
                        $map_links = $row['map_links'];
                        $shop_time = $row['shop_time'];
                    }
                    ?>
                    <div class="tab-pane" id="tab_7">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">WhatsApp Number * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="phone_no_1" value="<?php echo $phone_no_1; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Phone Number 2 * </label>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="phone_no_2" value="<?php echo $phone_no_2; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Email * </label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="email" name="email" value="<?php echo $email; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Google Map Link * </label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text" name="map_links" value="<?php echo $map_links; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Shop Time * </label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text" name="shop_time" value="<?php echo $shop_time; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label">Address * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="address" style="height:100px;"><?php echo $address; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form_contact">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Contact Page Content Start -->

                    </form>
                </div>
            </div>

</section>

<?php require_once('footer.php'); ?>
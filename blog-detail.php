<?php
include('admin/inc/config.php');
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get session ID
$session_id = session_id();
if (empty($session_id)) {
    die('Session not started.');
}

// Validate URL param
if (isset($_GET['url']) && !empty($_GET['url'])) {
    $url = $_GET['url'];

    // Fetch blog by slug/url
    $statement = $pdo->prepare("SELECT * FROM tbl_blog WHERE url = ? AND status = 1");
    $statement->execute([$url]);
    $blog = $statement->fetch(PDO::FETCH_ASSOC);

    // If blog not found, redirect
    if (!$blog) {
        header('Location: blog.php');
        exit;
    }
} else {
    // Redirect if 'url' is missing
    header('Location: blog.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cosmicenergies | <?= $blog['b_name']; ?> | <?= $blog['b_meta_title']; ?></title>
    <meta charset="UTF-8">
    <meta name="title" content="<?= $blog['b_meta_title']; ?>">
    <meta name="keyword" content="<?= $blog['b_meta_keyword']; ?>">
    <meta name="description" content="<?= $blog['b_meta_desc']; ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- stylesheet -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/js/plugin/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="assets/js/plugin/airdatepicker/datepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/mycss.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/cart.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <!-- favicon -->
    <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">
    
    
    <link rel="stylesheet" type="text/css" href="assets/css/blog-details-page.css" />

</head>

<body>

    <div class="as_main_wrapper">

        <!-- START HEADER -->
        <?php include('include/header.php'); ?>
        <!-- END HEADER -->


        <section class="as_breadcrum_wrapper" style="background: var(--white2-color);">
            <div class="container">
                <div class="blog">
                    <div class="col-lg-12 text-center">
                        <h1><?= $blog['b_name']; ?></h1>
                        <ul class="breadcrumb" style="color:white; background:var(--white2-color);">
                            <li><a href="index.php" style="color: var(--primary-color); font-size:18px;  ">Home &nbsp;>> </a></li>
                            <li><a href="blog.php" style="color: var(--primary-color); font-size:18px;  ">&nbsp; Our Blogs &nbsp;>> </a></li>
                            <li><a style="color: var(--primary-color); font-size:18px;  ">&nbsp; <?= $blog['b_name']; ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <?php

        ?>
        <section class="as_servicedetail_wrapper as_padderBottom80 as_padderTop80">
            <div class="container">
                <div class="row blog">
                    <div class="col-lg-9 col-md-9">
                        <div class="as_blog_box as_blog_single as_padderBottom80 " style="box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px; padding:20px;" id="font-18">
                            <div class="as_blog_img">
                                <img src="./admin/uploads/blog/<?php echo $blog['b_image']; ?>" alt="<?php echo $blog['b_name']; ?>" class="img-responsive" style="width: 100%;  ">

                                <span class="as_btn"><?php echo date('j M, Y', strtotime($blog['created_at'])); ?></span> <!-- Replace with dynamic date if available -->

                            </div>
                            <ul>
                                <li>
                                    <a href="javascript:;">
                                        <img src="assets/images/svg/user.svg" alt="Cosmicenergies">By - Cosmicenergies
                                    </a>
                                </li>

                            </ul>
                            <h4 class="as_subheading"><?php echo ($blog['b_name']); ?></h4>
                            <p class="as_font14 as_margin0 as_padderBottom20" style="color: var(--gray-color); font-size:18px !important; text-align:justify;">
                                <?php echo ($blog['b_description']); ?>
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="as_blog_sidebar">
                            <div class="as_service_widget as_padderBottom40" style="box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px; padding:20px;">
                                <h3 class="as_heading">Blogs Categories</h3>
                                <ul class="numerology-list">
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_blog_category WHERE status = 1 ORDER BY blo_id DESC");
                                    $statement->execute();
                                    $categories = $statement->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($categories as $cat) {
                                    ?>
                                        <li style="font-size: 18px; color:var(--primary-color);">
                                            <a href="blog-category.php?url=<?= $cat['url']; ?>" style="color:var(--primary-color)">
                                                <span><?= $cat['blo_name']; ?></span>
                                            </a>
                                        </li>

                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Footer Section Start -->
        <?php include('include/footer.php'); ?>
        <!-- Footer Copyright Section End  -->



    </div>

    <!-- javascript -->
    <script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="assets/js/jquery.min.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/bootstrap.min.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/plugin/slick/slick.min.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/plugin/countto/jquery.countTo.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/plugin/airdatepicker/datepicker.min.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/plugin/airdatepicker/i18n/datepicker.en.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/custom.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/rocket-loader.min.js" data-cf-settings="dea942b4e5104683ffff5739-|49" defer></script>
</body>

</html>
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
if (isset($_GET['url'])) {
    $url = $_GET['url'];

    // Fetch the subcategory details based on the URL parameter
    $statement = $pdo->prepare("SELECT * FROM tbl_blog_category WHERE url = ? AND status = 1 ");
    $statement->execute([$url]);
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        // Redirect if subcategory not found
        header('location: blog-category.php');
        exit;
    }

    $blo_id = $row['blo_id'];
    $blo_name = $row['blo_name'];

    // Fetch products belonging to this subcategory
    $statement = $pdo->prepare("SELECT * FROM tbl_blog WHERE blo_id = ? AND status = 1 ");
    $statement->execute([$blo_id]);
    $blogs = $statement->fetchAll(PDO::FETCH_ASSOC);
} else {
    header('location: blog-category.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cosmicenergies | Numerology Website | Blog <?= $blo_name; ?> </title>
    <meta charset="UTF-8">
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
    
    <link rel="stylesheet" type="text/css" href="assets/css/blog-category-page.css" />

</head>

<body>

    <div class="as_main_wrapper">

        <!-- START HEADER -->
        <?php include('include/header.php'); ?>
        <!-- END HEADER -->

        <section class="as_breadcrum_wrapper" style="background: var(--white2-color);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1><?= $blo_name; ?></h1> 
                        <ul class="breadcrumb" style="color:white; background:var(--white2-color);">
                            <li><a href="index.php" style="color: var(--primary-color); font-size:18px;  ">Home &nbsp;>> </a></li>
                            <li><a href="index.php" style="color: var(--primary-color); font-size:18px;  ">&nbsp; Our Blogs &nbsp;>> </a></li>
                            <li><a href=" " style="color: var(--primary-color); font-size:18px;  ">&nbsp; <?= $blo_name; ?></a></li> 
                        </ul>
                    </div>
                </div>
            </div>
        </section>


        <!-- Blog Section Start -->
        <section class="as_zodiac_sign_wrapper as_padderTop80 as_padderBottom80" style="background: var(--white-color);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1 class="as_heading as_heading_center">Our Latest Blogs</h1>
                        <div class="text-left">

                            <div class="row d-flex justify-content-center ">

                                <?php
                                foreach ($blogs as $row) {
                                ?>

                                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                        <div class="as_product_box">
                                            <div class="as_blog_img">
                                                <a href="blog-detail.php?url=<?= $row['url']; ?>">
                                                    <img src="./admin/uploads/blog/<?php echo $row['b_image']; ?>" alt=" <?= ($row['b_name']); ?>" class="img-responsive"
                                                        style="width: 100%;  ">
                                                </a>
                                                <span class="as_btn"><?php echo date('j M, Y', strtotime($row['created_at'])); ?></span> <!-- Replace with dynamic date if available -->
                                            </div>
                                            <ul>
                                                <li><a href="blog-detail.php?url=<?= $row['url']; ?>"><img src="assets/images/svg/user.svg" alt="">&nbsp; By - Cosmicenergies</a></li>
                                            </ul>
                                            <h4 class="as_subheading" style="color: var(--text2-color);">
                                                <a href="blog-detail.php?url=<?= $row['url']; ?>">
                                                    <?= ($row['b_name']); ?>
                                                </a>
                                            </h4>
                                            <p class="as_font14 as_margin0"><?= (substr($row['b_description'], 0, 150)); ?>...</p>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>

                            </div>

                        </div>
                    </div>
                </div>
        </section>
        <!-- Blog Section End -->


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
<?php include('admin/inc/config.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get session ID
$session_id = session_id();
if (empty($session_id)) {
    die('Session not started.');
}

$statement = $pdo->prepare("SELECT * FROM tbl_about WHERE id=1");
$statement->execute();
$row = $statement->fetch(PDO::FETCH_ASSOC);

$sub_heading = $row['sub_heading'];
$short_desc = $row['short_desc'];
$description = $row['description'];
$mission = $row['mission'];
$vission = $row['vission'];
$meta_title = $row['meta_title'];
$meta_keyword = $row['meta_keyword'];
$meta_desc = $row['meta_desc'];
$image2 = $row['image2'] ?? '';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= !empty($meta_title) ? $meta_title : $sub_heading; ; ?></title>
    <meta name="title" content="<?= $meta_title; ?>">
    <meta name="keyword" content="<?= $meta_keyword; ?>">
    <meta name="description" content="<?= $meta_desc; ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <!-- This Google Font used in Captions -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="assets/css/about-page.css"/> 
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
                        <h1>About us</h1> 
                        <ul class="breadcrumb" style="color:white; background:var(--white2-color);">
                            <li><a href="index.php" style="color: var(--primary-color); font-size:18px;  ">Home &nbsp;>> </a></li>
                            <li><a  style="color: var(--primary-color); font-size:18px;  ">&nbsp;About Us </a></li> 
                        </ul>
                    </div>
                </div>
            </div>
        </section>


        <!-- About Section Start -->
        <section class="as_about_wrapper as_padderTop80 as_padderBottom80" style="background: var(--white-color);">
            <div class="container">
                <div class="row">
                    <!-- Image Section -->
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="as_about_slider">
                            <div>
                                <div class="as_aboutimg text-right">
                                    <?php if (!empty($image2)): ?>
                                        <img src="./admin/uploads/accessroies/about/<?=($image2); ?>" alt="About Image" class="img-responsive" style="padding-left:20px;" >
                                    <?php else: ?>
                                        <img src="assets/images/about-default.jpg" alt="Default Image" class="img-responsive" style="padding-left:20px;">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Text Section -->
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                        <h1 class="as_heading" style="color: var(--primary-color);"><?=($sub_heading); ?></h1>
                        <div style="color: var(--primary-color); font-size:18px !important;">
                            <?= ($short_desc); ?>
                        </div>
                    </div>

                    <!-- Text Section -->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12" style="padding-top: 20px;">
                        <div style="color: var(--primary-color); font-size:18px !important;">
                            <?= ($description); ?>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- About Section End -->

         <!-- About Section Start -->
        <section class="as_about_wrapper as_padderTop80 as_padderBottom80" style="background: var(--white2-color);">
            <div class="container">
                <div class="row">   
                    <!-- Text Section -->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <h1 class="as_heading" style="color: var(--primary-color);">Our Vision</h1>
                        <div style="color: var(--primary-color); font-size:18px !important;">
                            <?= ($vission); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section> 
        <!-- About Section End -->

        <!-- About Section Start -->
        <section class="as_about_wrapper as_padderTop80 as_padderBottom80" style="background: var(--white-color);">
            <div class="container">
                <div class="row">   
                    <!-- Text Section -->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <h1 class="as_heading" style="color: var(--primary-color);">Our Mission</h1>
                        <div style="color: var(--primary-color); font-size:18px !important;">
                            <?= ($mission); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section> 
        <!-- About Section End -->

        <!-- Testimonials Section Start -->
        <section class="as_zodiac_sign_wrapper as_padderBottom80 as_padderTop80 button-disable" style="background: var(--white2-color);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1 class="as_heading as_heading_center">What Our Customers Say</h1>
                        <p class="as_font14 as_margin0 as_padderBottom50" style="color: var(--primary-color);  font-family: 'Dancing Script', cursive; font-size:22px;"><b>"Aligned Lives, Happy Clients."</b></p>
                    </div>

                   <div class="row as_customer_slider">
                        <?php
                        $i = 0;
                        $statement = $pdo->prepare("SELECT * FROM tbl_testimonial WHERE status = 1 ORDER BY id DESC");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($result as $row) {
                            $i++;
                        ?>
                           <div class="col-lg-6 col-md-6">
                                <div class="as_customer_box text-center" style="background: var(--primary-color);">
                                    <span class="as_customer_img">
                                        <img src="assets/my-images/testimonial.png" alt="" style="width: 100px;">
                                        <span><img src="assets/images/svg/quote1.svg" alt=""></span>
                                    </span>
                                      <p class="as_margin0" style="color: var(--white-color); font-size:16px; text-align:justify;  font-weight:300; letter-spacing:1px;"> <?php echo nl2br(($row['testimonial_content'])); ?> </p>
                                    <h3 style="color: var(--white2-color);"><?php echo ($row['testimonial_name']); ?></h3>
                                </div>
                            </div> 
                        <?php } ?>
                    </div>
                </div>

            </div>
        </section>
        <!-- Testimonials Section End -->


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
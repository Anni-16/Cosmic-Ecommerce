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

if (!isset($_GET['url']) || empty($_GET['url'])) {
    echo "Invalid ID";
    exit;
}

$url = $_GET['url'];
$statement = $pdo->prepare("SELECT * FROM tbl_numerology WHERE url = ? AND status = 1");
$statement->execute([$url]);
$row = $statement->fetch(PDO::FETCH_ASSOC);

$ser_name = $row['ser_name'];
$ser_price = $row['ser_price'];
$ser_icon = $row['ser_icon'];
$sub_heading_2 = $row['sub_heading_2'];
$ser_image = $row['ser_image'];
$ser_image_2 = $row['ser_image_2'];
$ser_description = $row['ser_description'];
$description_2 = $row['description_2'];
$ser_meta_title = $row['ser_meta_title'];
$ser_meta_keyword = $row['ser_meta_keyword'];
$ser_meta_descr = $row['ser_meta_descr'];
$status = $row['status'];
$map_status = $row['map_status'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
<title> <?= !empty($ser_meta_title) ? $ser_meta_title : $ser_name; ?></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="<?= $ser_meta_title; ?>">
    <meta name="keyword" content="<?= $ser_meta_keyword; ?>">
    <meta name="description" content="<?= $ser_meta_descr; ?>">
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


    <link rel="stylesheet" type="text/css" href="assets/css/numerology-detail-page.css" />

</head>

<body>

    <div class="as_main_wrapper">

        <!-- START HEADER -->
        <?php include('include/header.php'); ?>
        <!-- End Header -->

        <!-- Breadcrumb -->
        <section class="as_breadcrum_wrapper" style="background: var(--white2-color);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1><?= $ser_name; ?></h1>
                        <ul class="breadcrumb" style="color:white; background:var(--white2-color);">
                            <li><a href="index.php" style="color: var(--primary-color); font-size:18px;  ">Home &nbsp;>> </a></li>
                            <li><a href="numerology.php" style="color: var(--primary-color); font-size:18px;  ">&nbsp; Numerology &nbsp;>></a></li>
                            <li><a style="color: var(--primary-color); font-size:18px;  ">&nbsp; <?= $ser_name; ?> </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Detail Section -->
        <section class="as_servicedetail_wrapper as_padderBottom80 as_padderTop80">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                        <div class="as_service_detail_inner" id="para-18">
                            <h1 class="as_heading" style="color:var(--primary-color)"><?= $ser_name; ?> - <?= $ser_price; ?></h1>
                            <p class="as_font14" style="color: var(--gray-color);   text-align:justify !important">
                                <?= $ser_description; ?>
                            </p>
                            <a target="_blank" href="https://api.whatsapp.com/send?phone=7619377055&text=Hello! Can I get more info on this ?." class="as_btn">
                                <!-- SVG Icon Here -->
                                <img src="./assets/my-images/chat.png" alt="Cosmicenergies" style="width:35px;"> &nbsp;
                                Chat With Us</a>
                        </div>
                    </div>
                    <div class="offset-xxl-2 col-xxl-4 col-xl-6 col-lg-6 col-md-12">
                        <h1 class="as_heading" style="color:var(--primary-color); visibility:hidden"><?= $ser_name; ?> - <?= $ser_price; ?></h1>
                        <div class="as_service_detail_inner">
                            <img src="./admin/uploads/numerology/<?= $ser_image; ?>" alt="<?= $ser_name; ?>" class="img-responsive">
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="as_servicedetail_wrapper as_padderBottom80 as_padderTop80" style="background-color: var(--white2-color);">
            <div class="container">
                <div class="row">
                    <div class=" col-xxl-5 col-xl-6 col-lg-6 col-md-12">
                        <div class="as_service_detail_inner">
                            <h1 class="as_heading" style="visibility: hidden;"><?= $sub_heading_2; ?></h1>
                            <img src="./admin/uploads/numerology/<?= $ser_image_2; ?>" alt="<?= $sub_heading_2; ?>" class="img-responsive">

                        </div>
                    </div>
                    <div class="offset-xxl-1 col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                        <div class="as_service_detail_inner" id="para-18">

                            <h1 class="as_heading"><?= $sub_heading_2; ?></h1>
                            <p class="as_font14" style="color: var(--gray-color);  text-align:justify !important"><?= $description_2; ?></p>
                            <a target="_blank" href="https://api.whatsapp.com/send?phone=7619377055&text=Hello! Can I get more info on this ?." class="as_btn">
                                <img src="./assets/my-images/chat.png" alt="Cosmicenergies" style="width:35px;"> &nbsp;
                                Chat With Us</a>
                        </div>
                    </div>

                </div>
            </div>
        </section>



        <section class="as_servicedetail_wrapper as_padderBottom80 as_padderTop80" style="display:<?= $map_status; ?>;">
            <div class="container">
                <div class="row">
                    <h2 style="text-align: center; margin-bottom: 60px;">Online Consultation</h2>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="row" style="border: 1px solid #e0e0e0; padding: 20px;border-radius: 20px;">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                                <div class="as_service_detail_inner">
                                    <img src="assets/my-images/num-bottom.png" alt="Cosmicenergies" class="img-responsive">

                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                                <div class="as_service_detail_inner">

                                    <h1 class="as_heading">Unlock Your Destiny</h1>

                                    <p class="as_font14" style="color: var(--gray-color);  font-size:18px !important; text-align:justify !important">"Discover your true path through personalized online numerology consultations. Align destiny, decisions, and success today."
                                    </p>
                                    <a target="_blank" href="https://api.whatsapp.com/send?phone=7619377055&text=Hello! Can I get more info on this ?." class="as_btn">
                                        <img src="./assets/my-images/chat.png" alt="Cosmicenergies" style="width:35px;"> &nbsp;
                                        Chat With Us</a>

                                </div>
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
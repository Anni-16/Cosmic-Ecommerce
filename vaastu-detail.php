<?php
include('admin/inc/config.php');

// Check if 'url' exists and is not empty
if (!isset($_GET['url']) || empty($_GET['url'])) {
    echo "Invalid ID";
    exit;
}

$url = $_GET['url'];

// Fetch data
$statement = $pdo->prepare("SELECT * FROM tbl_vaastu WHERE url = ? AND status = 1");
$statement->execute([$url]);
$data = $statement->fetch(PDO::FETCH_ASSOC);

// If no record found, handle it
if (!$data) {
    echo "Record not found";
    exit;
}

$ser_name      = $data['ser_name'];
$sub_heading_2 = $data['sub_heading_2'];
$ser_image     = $data['ser_image'];
$ser_image_2   = $data['ser_image_2'];
$desc1         = $data['ser_description'];
$desc2         = $data['description_2'];
$ser_icon      = $data['ser_icon'];
$map_status    = $data['map_status'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cosmicenergies | <?= $ser_name; ?> | <?= $data['ser_meta_title'] ?> </title>
    <meta charset="UTF-8">
    <meta name="title" content="<?= $data['ser_meta_title']; ?>">
    <meta name="keyword" content="<?= $data['ser_meta_keyword']; ?>">
    <meta name="description" content="<?= $data['ser_meta_descr']; ?>">
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

    <style>
        .as_breadcrum_wrapper {
            padding-top: 200px;
        }

        .main-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            width: 100%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .as_banner_wrapper {
            padding-top: 200px;
        }

        .button-disable .as_btn:after,
        .as_btn:before {
            border-left: 0px solid var(--secondary-color) !important;
        }

        .button-disable .as_btn:before {
            border-right: 0px solid var(--secondary-color) !important;
        }

        input,
        textarea,
        select {
            color: var(--primary-color) !important;
            background-color: #fff !important;
            width: 100%;
        }

        .MsoNormal{
            font-size: 18px !important;
        }

        #para-18 p{
            font-size: 18px !important;
            text-align: left !important;
        }
    </style>

</head>

<body>

    <div class="as_main_wrapper">

        <!-- START HEADER -->
        <?php include('include/header.php'); ?>
        <!-- END HEADER -->

        <!-- Breadcrumb Section -->
        <section class="as_breadcrum_wrapper" style="background: var(--white2-color);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1><?= $ser_name ?></h1> 
                        <ul class="breadcrumb" style="color:white; background:var(--white2-color);">
                            <li><a href="index.php" style="color: var(--primary-color); font-size:18px;  ">Home &nbsp;>> </a></li>
                            <li><a href="vaastu.php" style="color: var(--primary-color); font-size:18px;  ">&nbsp; Vaastu &nbsp;>>  </a></li>   
                            <li><a style="color: var(--primary-color); font-size:18px;  ">&nbsp; <?= $ser_name ?>   </a></li>   
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- First Content Section -->
        <section class="as_servicedetail_wrapper as_padderBottom80 as_padderTop80">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                        <div class="as_service_detail_inner" id="para-18">
                            <h1 class="as_heading"><?= $ser_name ?></h1>
                            <p class="as_font14" style="color: var(--gray-color);   text-align:justify !important"><?= $desc1 ?></p>
                            
                              <a target="_blank" href="https://api.whatsapp.com/send?phone=7619377055&text=Hello! Can I get more info on this ?." class="as_btn">
                            <img src="./assets/my-images/chat.png" alt="" style="width:35px;">  &nbsp;
                            Chat With Us</a>
                        </div>
                    </div>
                    <div class=" offset-xxl-2 col-xxl-4 col-xl-6 col-lg-6 col-md-12">
                        <div class="as_service_detail_inner">
                            <h1 class="as_heading " style="visibility: hidden;"><?= $ser_name ?></h1>
                            <?php if ($ser_image) : ?>
                                <img src="./admin/uploads/vaastu/<?= $ser_image ?>" alt="<?= $ser_name; ?>" class="img-responsive">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Second Content Section -->
        <section class="as_servicedetail_wrapper as_padderBottom80 as_padderTop80" style="background-color: var(--white2-color);">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-12">
                        <div class="as_service_detail_inner" >
                             <h1 class="as_heading " style="visibility: hidden;"><?= $ser_name ?></h1>
                            <?php if ($ser_image_2) : ?>
                                <img src="./admin/uploads/vaastu/<?= $ser_image_2 ?>" alt="<?= $sub_heading_2 ?>" class="img-responsive">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="offset-xxl-1 col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                        <div class="as_service_detail_inner" id="para-18">
                            <h1 class="as_heading"><?= $sub_heading_2 ?></h1>
                            <p class="as_font14" style="color: var(--gray-color);   text-align:justify !important"><?= $desc2 ?></p> 
                              <a target="_blank" href="https://api.whatsapp.com/send?phone=7619377055&text=Hello! Can I get more info on this ?." class="as_btn">
                              <img src="./assets/my-images/chat.png" alt="" style="width:35px;">  &nbsp;
                            Chat With Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>




        <section class="as_servicedetail_wrapper as_padderBottom80 as_padderTop80" style="display: <?= $map_status; ?>;">
            <div class="container">
                <div class="row">
                    <h2 style="text-align: center; margin-bottom: 60px;">Map-Only Consultation</h2>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="row" style="border: 1px solid #e0e0e0; padding: 20px;border-radius: 20px;">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                                <div class="as_service_detail_inner">
                                    <img src="assets/my-images/vasstu.png" alt="" class="img-responsive">

                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                                <div class="as_service_detail_inner">

                                    <h1 class="as_heading">Unlock Your Space's Potential</h1>

                                    <p class="as_font14" style="color: var(--gray-color);  font-size:18px !important; text-align:justify !important">Opt for a Map-Only Vaastu Consultation. No Personal Site Visit is required. You can get consultation online or by visiting our office.
                                    </p> 
                                    <a target="_blank" href="https://api.whatsapp.com/send?phone=7619377055&text=Hello! Can I get more info on this ?." class="as_btn">
                                     <img src="./assets/my-images/chat.png" alt="" style="width:35px;"> &nbsp;    
                                    Get Map Consultation</a>
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
<?php include('./admin/inc/config.php');
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get session ID
$session_id = session_id();
if (empty($session_id)) {
    die('Session not started.');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cosmicenergies | Numerology Website | Blog</title>
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
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    <!-- favicon -->
    <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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

        .modal-body {
            max-height: 500px;
            overflow-y: auto;
            color: var(--text2-color) !important;
        }

        .as_footer_wrapper a {
            color: var(--white-color);
            text-decoration: none;
        }

        .no-bottom-gap a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .as_breadcrum_wrapper a {
            color: var(--primary-color);
            text-decoration: none;
        }
    </style>

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
                        <h1 style=" color: var(--primary-color);">Our News & Events</h1>
                        <ul class="breadcrumb" style="color:white; background:var(--white2-color);">
                            <li><a href="index.php" style="color: var(--primary-color); font-size:18px;">Home &nbsp;>> </a></li>
                            <li><a style="color: var(--primary-color); font-size:18px;">&nbsp; News & Events </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Blog Section Start -->
        <section lass="as_zodiac_sign_wrapper as_padderTop80 as_padderBottom80" style="background: var(--white-color); padding-top:50px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1 class="as_heading as_heading_center" style=" color: var(--primary-color);">Our Latest News & Events</h1>
                        <p class="as_font14 as_margin0 as_padderBottom20" style="font-family: 'Dancing Script', cursive; font-size:22px; color: var(--primary-color);"><b>"News and Events You Should Know!"</b></p>
                        <div class="text-left">

                            <div class="row d-flex justify-content-center">
                                <?php
                                $i = 0;
                                $statement = $pdo->prepare("SELECT * FROM tbl_news  ORDER BY page_order ASC");

                                $statement->execute();
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($result as $index => $row) : ?>
                                    <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-4">
                                        <div class="as_product_box">
                                            <div class="as_blog_img">
                                                <img src="./admin/uploads/news/<?php echo $row['b_image']; ?>" alt="" class="img-responsive" style="width: 100%;">
                                                <p class="as_font14 as_margin0 mt-2" style="color: var(--text2-color);"><?= (substr($row['b_description'], 0, 80)); ?>...</p>
                                            </div>

                                            <!-- Read More Button -->
                                            <button type="button" class="btn btn-primary " style="background-color:var(--primary-color); border:none;" data-bs-toggle="modal" data-bs-target="#blogModal<?= $index; ?>">
                                                Read More
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="blogModal<?= $index; ?>" tabindex="-1" aria-labelledby="blogModalLabel<?= $index; ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="blogModalLabel<?= $index; ?>" style="color: var(--text2-color);"><?= $row['b_name']; ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="as_blog_img" style="padding: 10px 10px;">
                                                    <img src="./admin/uploads/news/<?php echo $row['b_image']; ?>" alt="" class="img-responsive" style="width: 100%;">
                                                </div>
                                                <div class="modal-body" style="color: var(--text2-color);">
                                                    <?= $row['b_description']; ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" style="background-color:var(--primary-color); border:none;" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Blog Section End -->

        <!-- Footer Section Start -->
        <?php include('include/footer.php'); ?>
        <!-- Footer Section End -->

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Other Scripts -->
    <script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="assets/js/jquery.min.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/bootstrap.min.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/plugin/slick/slick.min.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/plugin/countto/jquery.countTo.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/plugin/airdatepicker/datepicker.min.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/plugin/airdatepicker/i18n/datepicker.en.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
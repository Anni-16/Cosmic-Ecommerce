<?php include('admin/inc/config.php');
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get session ID
$session_id = session_id();
if (empty($session_id)) {
    die('Session not started.');
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cosmicenergies | Numerology Website | Contact</title>
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
    <link rel="stylesheet" type="text/css" href="Captcha-Code/style.css" />
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
                        <h1>Contact Us</h1>
                        <ul class="breadcrumb" style="color:white; background:var(--white2-color);">
                            <li><a href="index.php" style="color: var(--primary-color); font-size:18px;  ">Home &nbsp;>> </a></li>
                            <li><a href="contact.php" style="color: var(--primary-color); font-size:18px;  ">&nbsp;Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>


        <section class="as_contact_section as_padderTop80" style="background: var(--white-color);">
            <div class="container">
                <div class="row">
                    <?php
                    // Fetch Contact Info
                    $statement = $pdo->prepare("SELECT * FROM tbl_contact WHERE id=1");
                    $statement->execute();
                    $row = $statement->fetch(PDO::FETCH_ASSOC);

                    $address    = $row['address'];
                    $phone_no_1 = $row['phone_no_1'];
                    $phone_no_2 = $row['phone_no_2'];
                    $email      = $row['email'];
                    $map_links  = $row['map_links'];
                    $shop_time  = $row['shop_time'];
                    ?>

                    <section class="as_contact_section as_padderTop80" style="background: var(--white-color);">
                        <div class="container">
                            <div class="row">
                                <!-- Contact Info -->
                                <div class="col-lg-12 col-md-12">
                                    <div class="as_contact_info">
                                        <h1 class="as_heading">Contact Us</h1>
                                        <p class="as_font14 as_margin0" style="font-size:18px;  "><?= nl2br(($shop_time)); ?></p>

                                        <div class="row">
                                            <!-- Phone -->
                                            <div class="col-xl-4 col-lg-12 col-md-6 col-sm-6">
                                                <div class="as_info_box">
                                                    <span class="as_icon"><img src="assets/images/svg/call1.svg" alt=""></span>
                                                    <div class="as_info">
                                                        <h5>Call Us</h5>
                                                        <p class="as_margin0 as_font14" style="font-size:18px;  "><?= ($phone_no_1); ?></p>
                                                        <p class="as_margin0 as_font14" style="font-size:18px;  "><?= ($phone_no_2); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Email -->
                                            <div class="col-xl-4 col-lg-12 col-md-6 col-sm-6">
                                                <div class="as_info_box">
                                                    <span class="as_icon"><img src="assets/images/svg/mail.svg" alt=""></span>
                                                    <div class="as_info">
                                                        <h5>Mail Us</h5>
                                                        <p class="as_margin0 as_font14" style="font-size:18px;  "><a href="mailto:<?= ($email); ?>"><?= ($email); ?></a></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Address -->
                                            <div class="col-xl-4 col-lg-12 col-md-6 col-sm-6">
                                                <div class="as_info_box">
                                                    <span class="as_icon"><img src="assets/images/svg/my-map.svg" alt=""></span>
                                                    <div class="as_info">
                                                        <h5>Location</h5>
                                                        <p class="as_margin0 as_font14" style="font-size:18px;  "><?= nl2br(($address)); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="col-lg-12 col-md-12">
                        <div class="as_contact_form login_form2" style="background: var(--white2-color); margin-bottom: 100px; margin-top: 150px;">
                            <h4 class="as_subheading" style="color: var(--primary-color);">Have A Question?</h4>
                            <form action="sendmail.php" method="post">

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-2">
                                        <label style="font-size:18px;  ">Name</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="name" placeholder="Name" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-2">
                                        <label style="font-size:18px;  ">Email</label>
                                        <div class="form-group">
                                            <input class="form-control" type="email" name="email" placeholder="Email" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-2">
                                        <label style="font-size:18px;  ">Mobile No.</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="mobile" placeholder="Mobile Number" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-2">
                                        <label style="font-size:18px;  ">Gender</label>
                                        <div class="form-group as_select_box">
                                            <select class="form-control" name="gender" required>
                                                <option value="">Select Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-2">
                                        <label style="font-size:18px;  ">Your Query</label>
                                        <div class="form-group">
                                            <textarea name="query" placeholder="Your Query" class="form-control" required></textarea>
                                        </div>
                                    </div>

                                    <!-- Captcha -->

                                    <div id="captcha" class="form_div ">
                                        <div class="preview"></div>
                                        <div class="field-inner captcha_form">
                                            <input type="text" id="captcha_form" class="form_input_captcha" placeholder="Enter Code" required="">
                                            <button class="captcha_refersh" type="button">
                                                <i class="fa fa-refresh"></i>
                                            </button>
                                        </div>
                                    </div>


                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center ">
                                        <input type="submit" class="as_btn form_button" value="Submit">
                                    </div>

                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class=" ">
                <iframe src="<?= $map_links; ?>" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

            </div>
        </section>

        <!-- Footer Section Start -->
        <?php include('include/footer.php'); ?>
        <!-- Footer Copyright Section End  -->

    </div>


    <!-- Captcha-code js link  -->
    <script src="./Captcha-Code/script.js"></script>

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
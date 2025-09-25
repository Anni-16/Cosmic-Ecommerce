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

$statement = $pdo->prepare("SELECT * FROM tbl_return_policy WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $heading = $row['heading'];
    $content = $row['content'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $heading; ?> </title>
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
    
    
    <link rel="stylesheet" type="text/css" href="assets/css/returns-page.css" />
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
                        <h1><?= $heading; ?></h1> 
                        <ul class="breadcrumb" style="color:white; background:var(--white2-color);">
                            <li><a href="index.php" style="color: var(--primary-color); font-size:18px;  ">Home &nbsp;>> </a></li>
                            <li><a href=" " style="color: var(--primary-color); font-size:18px;  ">&nbsp; <?= $heading; ?>  </a></li>  
                        </ul>
                    </div>
                </div>
            </div>
        </section>


        <!-- About Section Start -->
        <section class="as_about_wrapper as_padderTop80 as_padderBottom80" style="background: var(--white-color);">
            <div class="container">
                <div class="row">
                    <!-- Main Content -->
                    <div class="col-xxl-9 col-xl-9 col-lg-8 col-md-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <h1 class="as_heading" style="color: var(--primary-color);">
                                    <?= $heading; ?>
                                </h1>
                                <p style="color: var(--gray-color); font-size:18px; text-align:justify;">
                                    <?= $content; ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-12">
                        <div class="as_service_sidebar">
                            <div class="as_service_widget as_padderBottom40" style="box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px; padding:20px;">
                                <h3 class="as_heading">Quick Links</h3>
                                <ul class="numerology-list">
                                    <li style="font-size: 18px;  color:var(--primary-color);">
                                        <a href="terms-conditions.php" style="color:var(--primary-color)">
                                            <span>Terms & Condition</span>
                                        </a>
                                    </li>
                                    <li style="font-size: 18px;  color:var(--primary-color);">
                                        <a href="privacy-policy.php" style="color:var(--primary-color)">
                                            <span>Privacy Policy</span>
                                        </a>
                                    </li>
                                    <li style="font-size: 18px;  color:var(--primary-color);">
                                        <a href="returns-exchange.php" style="color:var(--primary-color)">
                                            <span>Returns & Exchange Policy</span>
                                        </a>
                                    </li>
                                    <li style="font-size: 18px;  color:var(--primary-color);">
                                        <a href="disclaimer.php" style="color:var(--primary-color)">
                                            <span>Disclaimer</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section End -->


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
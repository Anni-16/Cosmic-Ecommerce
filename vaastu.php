<?php include('admin/inc/config.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cosmicenergies | Numerology Website | Vaastu</title>
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
                        <h1>Vaastu</h1>
                        <ul class="breadcrumb" style="color:white; background:var(--white2-color);">
                            <li><a href="index.php" style="color: var(--primary-color); font-size:18px;  ">Home &nbsp;>> </a></li>
                            <li><a style="color: var(--primary-color); font-size:18px;  ">&nbsp; Vaastu </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Vaastu Section Start -->
        <section class="as_zodiac_sign_wrapper as_padderTop80 as_padderBottom80" style="background: var(--white-color);">
            <div class="container">
                <div class="row display-flex justify-content-center">
                    <div class="col-lg-12 text-center">
                        <h1 class="as_heading as_heading_center"> Vaastu</h1>
                    </div>

                    <?php
                    $i = 0;
                    $statement = $pdo->prepare("SELECT * FROM tbl_vaastu WHERE status = 1 ORDER BY page_order ASC");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $i++;
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"  >
                            <div class="as_service_box text-center" style="background: var(--primary-color); height: 400px;">
                                <a href="vaastu-detail.php?url=<?= $row['url']; ?>">
                                    <span class="as_icon" style="background: var(--secondary-color);">
                                        <img src="./admin/uploads/vaastu/icon/<?= $row['ser_icon']; ?>" alt="<?= $row['ser_name']; ?>">
                                    </span>
                                </a>

                                <h4 class="as_subheading" style="color: var(--secondary-color);">
                                    <a href="vaastu-detail.php?url=<?= $row['url']; ?>"><?php echo ($row['ser_name']); ?>
                                    </a>
                                </h4>
                                <p style="color: var(--white-color); font-size:16px; font-weight:300; letter-spacing:1px;">
                                    <span style="color: var(--white-color);">
                                        <?php
                                        echo '<span style="color: var(--white-color);">' . implode(' ', array_slice(explode(' ', strip_tags($row['ser_description'])), 0, 10)) . '</span>';
                                        ?>
                                    </span>
                                </p>
                                <a href="vaastu-detail.php?url=<?php echo $row['url']; ?>" class="as_link">read more</a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                </div>
            </div>

        </section>
        <!-- Vaastu Section End -->


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
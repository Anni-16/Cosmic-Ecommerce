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
<html>

<head>
    <title>Cosmicenergies | Numerology Website | Home</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">
    <!-- stylesheet -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="assets/js/plugin/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="assets/js/plugin/airdatepicker/datepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/mycss.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/cart.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css" integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <!-- This Google Font used in Captions -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="assets/css/index-page.css" />

     <style>
        
        @media screen and (max-width:480px) {
        .slider .caption h1 { 
                text-align: center; 
            }

            .slider .caption h2 { 
                text-align: center; 
            }
            .news-section-mobile-hide {
                display: none;
            }

            .slider .slides li .caption { 
                padding: 0 0; 
                width:100%;
                padding:0;
            }

        }
    </style> 

</head>

<body>
    <div class="as_main_wrapper">

        <!-- START HEADER -->
        <?php include('include/header.php') ?>
        <!-- END HEADER -->


        <!-- Banner Start -->
        <div class="slider fullscreen">
            <ul class="slides">
                <?php
                $statement = $pdo->prepare("SELECT * FROM tbl_banner ORDER BY id DESC");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                ?>
                    <li>
                        <img src="./admin/uploads/banner/<?= $row['ser_image']; ?>" id="banner-image-style" class="mobile-hide-banner-image" alt="" />
                        <img src="./admin/uploads/banner/<?= $row['ser_image_2']; ?>" id="banner-image-style" alt="" class="mobile-show-banner-image" />

                        <div class="caption left-align">
                            <h1 class="banner-heading-1" style="color:#fff !important; margin:0; font-size: 34px ;"><?= ($row['ser_name']); ?></h1>
                            <h2 class="banner-heading-2" style="color: var(--secondary-color); padding-top: 20px;   margin:0; font-size: 32px ;"><?= ($row['ser_heading']); ?></h2>
                            <p style="color: red;"> <?= ($row['ser_description']); ?></p>
                        </div>
                    </li>

                <?php
                }
                ?>
            </ul>
            <!-- Custom Navigation Arrows -->
            <div class="slider-nav">
                <button id="prevSlide" class="btn-floating btn-large   arrow-btn left" style="background-color: var(--secondary-color);">
                    <i class="fa-solid" style="color: var(--primary-color); background:#ffffff00;"> <img src="./assets/my-images/my-arrow.png" alt="" style="transform: scaleX(-1);"></i>
                </button>
                <button id="nextSlide" class="btn-floating btn-large   arrow-btn right" style="background-color: var(--secondary-color);">
                    <i class="fa-solid" style="color: var(--primary-color); background:#ffffff00;"> <img src="./assets/my-images/my-arrow.png" alt=""></i>
                </button>
            </div>
        </div>
        <!-- Banner End -->


        <!-- About Section Start -->
        <?php
        $statement = $pdo->prepare("SELECT * FROM tbl_about WHERE id = 1");
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $sub_heading = $row['sub_heading'] ?? '';
        $short_desc = $row['short_desc'] ?? '';
        $meta_title = $row['meta_title'] ?? '';
        $meta_keyword = $row['meta_keyword'] ?? '';
        $meta_desc = $row['meta_desc'] ?? '';
        $image = $row['image'] ?? '';

        // Function to limit words
        function limitWords($text, $limit = 41)
        {
            $words = explode(" ", strip_tags($text));
            if (count($words) > $limit) {
                return implode(" ", array_slice($words, 0, $limit)) . "...";
            }
            return $text;
        }
        ?>

        <section class="as_about_wrapper as_padderTop80 as_padderBottom80" style="background: var(--white-color);">
            <div class="container">
                <div class="row">
                    <!-- Image Slider -->
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="as_about_slider">
                            <div>
                                <div class="as_aboutimg text-right">
                                    <?php if (!empty($image)) : ?>
                                        <img src="./admin/uploads/accessroies/about/<?= $image; ?>" alt="About Image" style="padding-left:20px;">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Text Content -->
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                        <h1 class="as_heading" style="color: var(--primary-color);">About Us</h1>
                        <h4 style="color: var(--primary-color);"><?= $sub_heading; ?></h4>
                        <p style="color: var(--primary-color); text-align:justify; font-size:18px;">
                            <?= limitWords($short_desc, 41); ?>
                        </p>

                        <a href="about.php" class="as_btn">read more</a>

                        <div class="as_contact_expert" style="background-color: var(--secondary-color);">
                            <span class="as_icon" style="background: var(--primary-color);">
                                <img src="./assets/my-images/chat.png" alt="" style="width:40px;">
                            </span>
                            <div>
                                <h5 class="as_white">Contact us at</h5>
                                <h1 class="as_orange" style="color: #fff;">
                                    <p>
                                        <a href="https://api.whatsapp.com/send?phone=<?= $phone_no_1; ?>&text=Hello! Can I get more info on this ?.">
                                            +91 <?= $phone_no_1; ?>
                                        </a>
                                    </p>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About Section End -->

        <!-- Numerlogy Section Start -->
        <section class="as_zodiac_sign_wrapper as_padderTop80 as_padderBottom80 button-disable" style="background:#eedf94;" id="num">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1 class="as_heading as_heading_center"> Numerology</h1>
                        <p class="as_font14 as_padderBottom5" style="font-family: 'Dancing Script', cursive; font-size:22px;"><b>"Decode Your Numbers, Discover Your Destiny."</b></p>
                    </div>

                    <div class="as_customer_slider">
                        <?php
                        // Fetch all numerology records from the database
                        $statement = $pdo->prepare("SELECT * FROM tbl_numerology WHERE status = 1 ORDER BY page_order ASC");
                        $statement->execute();
                        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <?php foreach ($results as $row) : ?>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="padding: 20px; ">
                                <div class="as_service_box text-center" style="background: var(--primary-color); height:400px; ">
                                    <a href="numerology-detail.php?url=<?php echo $row['url']; ?>">
                                        <span class="as_icon" style="background: var(--secondary-color);">
                                            <img src="./admin/uploads/numerology/icon/<?= $row['ser_icon']; ?>" alt="<?= $row['ser_name']; ?>">
                                        </span>
                                    </a>

                                    <a href="numerology-detail.php?url=<?php echo $row['url']; ?>">
                                        <h4 class="as_subheading" style="color: var(--white2-color);">
                                            <?php echo ($row['ser_name']); ?>
                                        </h4>
                                    </a>
                                    <p style="color: var(--white-color); font-size:16px; font-weight:300; letter-spacing:1px;">
                                        <?php
                                        echo '<span style="color: var(--white-color);">' . implode(' ', array_slice(explode(' ', strip_tags($row['ser_description'])), 0, 10)) . '</span>';
                                        ?>
                                    </p>
                                    <a href="numerology-detail.php?url=<?php echo $row['url']; ?>" class="as_link">read more</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
        </section>
        <!-- Numerlogy Section End -->

        <!-- Vaastu Section Start -->
        <section class="as_zodiac_sign_wrapper as_padderTop80 as_padderBottom80 button-disable" style="background: var(--white-color);" id="vaastu">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1 class="as_heading as_heading_center"> Vaastu</h1>
                        <p class="as_font14 as_padderBottom5" style="color: var(--primary-color); font-family: 'Dancing Script', cursive; font-size:22px;"><b>"Balance Your Space, Empower Your Life." </b></p>
                    </div>
                    <div class="as_customer_slider">
                        <?php
                        $i = 0;
                        $statement = $pdo->prepare("SELECT * FROM tbl_vaastu WHERE status = 1 ORDER BY page_order ASC");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row1) {
                            $i++;
                        ?>
                            <div class="col-lg-3 col-md-6 col-sm-6 col- -12" style="padding: 20px;  ">
                                <div class="as_service_box text-center" style="background: var(--primary-color); height:400px;">
                                    <a href="vaastu-detail.phpi?url=<?= $row1['url']; ?>">
                                        <span class="as_icon" style="background: var(--secondary-color);">
                                            <img src="./admin/uploads/vaastu/icon/<?= $row1['ser_icon']; ?>" alt="<?= $row1['ser_name']; ?>">
                                        </span>
                                    </a>

                                    <h4 class="as_subheading" style="color: var(--secondary-color);">
                                        <a href="vaastu-detail.php?url=<?php echo $row1['url']; ?>"><?php echo ($row1['ser_name']); ?>
                                        </a>
                                    </h4>
                                    <p style="color: var(--white-color); font-size:16px ;  font-weight:300; letter-spacing:1px;">
                                        <span style="color: var(--white-color);">
                                            <?php
                                            echo '<span style="color: var(--white-color);">' . implode(' ', array_slice(explode(' ', strip_tags($row1['ser_description'])), 0, 10)) . '</span>';
                                            ?>
                                        </span>
                                    </p>
                                    <a href="vaastu-detail.php?url=<?php echo $row1['url']; ?>" class="as_link">read more</a>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

        </section>
        <!-- Vaastu Section End -->

        <!-- Products Section Start -->
        <section class="as_product_wrapper as_padderBottom80 as_padderTop80" style="background: var(--white2-color);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1 class="as_heading as_heading_center">Our Latest Products</h1>
                        <p class="as_font14 as_margin0 as_padderBottom20" style="font-family: 'Dancing Script', cursive; font-size:22px;"><b>"Sacred Solutions for a Balanced Life."</b>
                        </p>

                        <div class="row as_product_slider">
                            <?php
                            $statement = $pdo->prepare(" SELECT * FROM tbl_product WHERE a_is_featured = 1 ORDER BY a_id DESC");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                            ?>
                                <div class="col-lg-3 col-md-6">
                                    <div class="as_product_box product-card-animation" style="height:480px;">
                                        <div class="as_product_img product-img">
                                            <a href="shop-detail.php?url=<?php echo $row['url']; ?>">
                                                <img src="./admin/uploads/products/<?php echo $row['a_photo']; ?>" style="width: 400px;" alt="Product Image">
                                            </a>
                                        </div>
                                        <div class="text-center hover-hide">
                                            <h4 class="as_subheading">
                                                <a href="shop-detail.php?url=<?php echo $row['url']; ?>">
                                                    <?php echo $row['a_name']; ?>
                                                </a>
                                            </h4>
                                            <span class="as_price">₹ <?php echo $row['a_current_price']; ?></span>
                                        </div>

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

        <!-- Products Section End -->


        <!-- Testimonials Section Start -->
        <section class="as_zodiac_sign_wrapper as_padderBottom80 as_padderTop80 button-disable" style="background: var(--white-color);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1 class="as_heading as_heading_center">What Our Customers Say</h1>
                        <p class="as_font14 as_margin0 as_padderBottom50" style="color: var(--secondary-color);  font-family: 'Dancing Script', cursive; font-size:22px;"><b>"Aligned Lives, Happy Clients."</b></p>
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
                                <div class="as_customer_box text-center" style="background: var(--primary-color); height:400px;">
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

        <!-- Blog Section Start -->
        <section class="as_zodiac_sign_wrapper as_padderTop80 as_padderBottom80 button-disable" style="background: var(--white2-color);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1 class="as_heading as_heading_center">Our Latest Blogs</h1>
                        <p class="as_font14 as_margin0 as_padderBottom20" style="font-family: 'Dancing Script', cursive; font-size:22px;"><b>"Decode Your Destiny with Every Read."</b></p>

                        <div class="text-left">

                            <div class="row as_blog_slider">
                                <?php
                                $statement = $pdo->prepare("SELECT * FROM tbl_blog WHERE status = 1 ORDER BY b_id DESC");
                                $statement->execute();
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row1) {
                                ?>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="as_product_box">
                                            <div class="as_blog_img">
                                                <a href="blog-detail.php?url=<?= $row1['url']; ?>">
                                                    <img src="./admin/uploads/blog/<?php echo $row1['b_image']; ?>" alt="" class="img-responsive" style="width: 100%;  ">
                                                </a>
                                                <span class="as_btn"><?php echo date('j M, Y', strtotime($row1['created_at'])); ?></span> <!-- Replace with dynamic date if available -->
                                            </div>
                                            <ul>
                                                <li><a href="blog-detail.php?url=<?= $row1['url']; ?>"><img src="assets/images/svg/user.svg" alt="">&nbsp; By - Cosmicenergies</a></li>
                                            </ul>
                                            <h4 class="as_subheading" style="color: var(--text2-color);">
                                                <a href="blog-detail.php?url=<?= $row1['url']; ?>">
                                                    <?= ($row1['b_name']); ?>
                                                </a>
                                            </h4>
                                            <p class="as_font14 as_margin0"><?= (substr($row1['b_description'], 0, 150)); ?>...</p>
                                        </div>
                                    </div>

                                <?php
                                }
                                ?>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Blog Section End -->



        <!-- News Section Start -->
        <section class="as_zodiac_sign_wrapper as_padderTop80 as_padderBottom80 button-disable news-section-mobile-hide" style="background: var(--white-color);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1 class="as_heading as_heading_center">News & Events</h1>
                        <p class="as_font14 as_margin0 as_padderBottom20" style="font-family: 'Dancing Script', cursive; font-size:22px;"><b>"News and Events You Should Know!"</b></p>

                        <div class="text-left">

                            <div class="row d-flex justify-content-center">
                                <?php
                                $i = 0;
                                $statement = $pdo->prepare("SELECT * FROM tbl_news WHERE status = 1  ORDER BY news_id DESC LIMIT 3");
                                $statement->execute();
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($result as $index => $row) : ?>
                                    <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-4">
                                        <div class="as_product_box">
                                            <div class="as_blog_img">
                                                <img src="./admin/uploads/news/<?php echo $row['b_image']; ?>" alt="<?= $row['b_name']; ?>" class="img-responsive" style="width: 100%;" data-bs-toggle="modal" data-bs-target="#blogModal<?= $index; ?>">
                                            </div>
                                            <h4 class="as_subheading" style="color: var(--text2-color);"><?= $row['b_name']; ?></h4>

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
                                                <div class="as_blog_img slider-css" style="padding: 10px 10px;">
                                                    <?php
                                                    // Fetch gallery images for this news item
                                                    $stmt_gallery = $pdo->prepare("SELECT * FROM tbl_news_photo WHERE news_id = ?");
                                                    $stmt_gallery->execute([$row['news_id']]);
                                                    $gallery_images = $stmt_gallery->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($gallery_images as $g) : ?>
                                                        <img src="./admin/uploads/news/<?php echo $row['b_image']; ?>" alt="<?= $row['b_name']; ?>" class="img-responsive" style="width: 100%;">
                                                        <img src="./admin/uploads/news/gallery/<?php echo $g['photo']; ?>" alt="<?= $row['b_name']; ?>" class="img-responsive" style="width: 100%;">
                                                    <?php endforeach; ?>
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

                            <a href="news-events.php" class="btn btn-primary " style="background-color:var(--primary-color); border:none;">View All</a>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- News Section End -->

        <!-- Footer Section Start -->
        <?php include('include/footer-index.php'); ?>
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
    <script src="assets/js/custom2.js" type="dea942b4e5104683ffff5739-text/javascript"></script>
    <script src="assets/js/cart.js"></script>
    <script src="assets/js/rocket-loader.min.js" data-cf-settings="dea942b4e5104683ffff5739-|49" defer></script>

    <!-- Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <!-- Slider Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sliderElem = document.querySelector('.slider');
            const sliderInstance = M.Slider.init(sliderElem, {
                indicators: true,
                height: window.innerHeight,
                duration: 500,
                interval: 5000
            });

            document.getElementById('prevSlide').addEventListener('click', function() {
                sliderInstance.prev();
            });

            document.getElementById('nextSlide').addEventListener('click', function() {
                sliderInstance.next();
            });
        });
    </script>



</body>

</html>
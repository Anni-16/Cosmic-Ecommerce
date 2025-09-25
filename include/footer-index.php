<section class="as_footer_wrapper " id="footer-my" style="background: var(--primary-color);">
    <div class="container">
        <div class="as_footer_inner as_padderBottom80" style="background: var(--primary-color);">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="as_footer_widget">
                        <div class="as_footer_logo">
                            <a href="index.php"><img src="./assets/my-images/footer-logo.png" alt="" style="width: 100px;"></a>
                        </div>
                        <p style="color: var(--white-color); font-size:16px;">our consultations are designed to be thoughtful, accurate, and deeply aligned with your life journey.</p>

                        <div class="as_share_box">
                            <p style="color: #fff;">Follow Us</p>
                            <ul>
                                <?php
                                $i = 0;
                                $statement = $pdo->prepare("SELECT * FROM tbl_social WHERE footer = 1");
                                $statement->execute();
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($result as $row) {
                                    $i++;
                                ?>
                                    <li>
                                        <a href="<?php echo !empty($row['social_url']) ? ($row['social_url']) : 'javascript:;'; ?>" style="background-color: var(--secondary-color);" target="_blank">
                                            <i class="<?php echo ($row['social_icon']); ?>"></i>
                                        </a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="as_footer_widget">
                        <h3 class="as_footer_heading " style="color: var(--secondary-color);">Quick Links</h3>

                        <ul>
                            <li style="color: var(--white-color); font-size:16px;  "><a href="about.php">
                                    <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="8" height="12" viewBox="0 0 8 12">
                                            <path d="M8.000,5.998 
                                        L-0.002,11.997 L1.292,5.998 L-0.002,-0.001 L8.000,5.998 ZM1.265,9.924 L6.502,5.998 L1.265,2.071 
                                        L2.112,5.998 L1.265,9.924 ZM5.451,5.998 L2.496,8.213 L2.974,5.998 L2.496,3.783 L5.451,5.998 Z" class="cls-1" style="background-color: var(--primary-color);" />
                                        </svg></span> Home</a></li>
                            <li style="color: var(--white-color); font-size:16px;  "><a href="about.php">
                                    <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="8" height="12" viewBox="0 0 8 12">
                                            <path d="M8.000,5.998 
                                        L-0.002,11.997 L1.292,5.998 L-0.002,-0.001 L8.000,5.998 ZM1.265,9.924 L6.502,5.998 L1.265,2.071 
                                        L2.112,5.998 L1.265,9.924 ZM5.451,5.998 L2.496,8.213 L2.974,5.998 L2.496,3.783 L5.451,5.998 Z" class="cls-1" style="background-color: var(--primary-color);" />
                                        </svg></span> About Us</a></li>
                            <li style="color: var(--white-color); font-size:16px;  "><a href="shop.php">
                                    <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="8" height="12" viewBox="0 0 8 12">
                                            <path d="M8.000,5.998 
                                        L-0.002,11.997 L1.292,5.998 L-0.002,-0.001 L8.000,5.998 ZM1.265,9.924 L6.502,5.998 L1.265,2.071 
                                        L2.112,5.998 L1.265,9.924 ZM5.451,5.998 L2.496,8.213 L2.974,5.998 L2.496,3.783 L5.451,5.998 Z" class="cls-1" style="background-color: var(--primary-color);" />
                                        </svg></span> Products</a></li>
                            <li style="color: var(--white-color); font-size:16px;  "><a href="blog.php">
                                    <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="8" height="12" viewBox="0 0 8 12">
                                            <path d="M8.000,5.998 
                                        L-0.002,11.997 L1.292,5.998 L-0.002,-0.001 L8.000,5.998 ZM1.265,9.924 L6.502,5.998 L1.265,2.071 
                                        L2.112,5.998 L1.265,9.924 ZM5.451,5.998 L2.496,8.213 L2.974,5.998 L2.496,3.783 L5.451,5.998 Z" class="cls-1" style="background-color: var(--primary-color);" />
                                        </svg></span> Blogs</a></li>
                            <li style="color: var(--white-color); font-size:16px;  "><a href="terms-conditions.php">
                                    <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="8" height="12" viewBox="0 0 8 12">
                                            <path d="M8.000,5.998 
                                        L-0.002,11.997 L1.292,5.998 L-0.002,-0.001 L8.000,5.998 ZM1.265,9.924 L6.502,5.998 L1.265,2.071 
                                        L2.112,5.998 L1.265,9.924 ZM5.451,5.998 L2.496,8.213 L2.974,5.998 L2.496,3.783 L5.451,5.998 Z" class="cls-1" style="background-color: var(--primary-color);" />
                                        </svg></span> Terms & Conditions</a></li>
                            <li style="color: var(--white-color); font-size:16px;  "><a href="privacy-policy.php">
                                    <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="8" height="12" viewBox="0 0 8 12">
                                            <path d="M8.000,5.998 
                                        L-0.002,11.997 L1.292,5.998 L-0.002,-0.001 L8.000,5.998 ZM1.265,9.924 L6.502,5.998 L1.265,2.071 
                                        L2.112,5.998 L1.265,9.924 ZM5.451,5.998 L2.496,8.213 L2.974,5.998 L2.496,3.783 L5.451,5.998 Z" class="cls-1" style="background-color: var(--primary-color);" />
                                        </svg></span> Privacy Policy</a></li>
                            <li style="color: var(--white-color); font-size:16px;  "><a href="disclaimer.php">
                                    <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="8" height="12" viewBox="0 0 8 12">
                                            <path d="M8.000,5.998 
                                        L-0.002,11.997 L1.292,5.998 L-0.002,-0.001 L8.000,5.998 ZM1.265,9.924 L6.502,5.998 L1.265,2.071 
                                        L2.112,5.998 L1.265,9.924 ZM5.451,5.998 L2.496,8.213 L2.974,5.998 L2.496,3.783 L5.451,5.998 Z" class="cls-1" style="background-color: var(--primary-color);" />
                                        </svg></span> Disclaimer</a></li>
                            <li style="color: var(--white-color); font-size:16px;  "><a href="contact.php">
                                    <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="8" height="12" viewBox="0 0 8 12">
                                            <path d="M8.000,5.998 
                                        L-0.002,11.997 L1.292,5.998 L-0.002,-0.001 L8.000,5.998 ZM1.265,9.924 L6.502,5.998 L1.265,2.071 
                                        L2.112,5.998 L1.265,9.924 ZM5.451,5.998 L2.496,8.213 L2.974,5.998 L2.496,3.783 L5.451,5.998 Z" class="cls-1" style="background-color: var(--primary-color);" />
                                        </svg></span> Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="as_footer_widget">
                        <h3 class="as_footer_heading" style="color: var(--secondary-color);">Numerology</h3>

                        <ul>
                            <?php
                            $i = 0;
                            $statement = $pdo->prepare("SELECT * FROM tbl_numerology WHERE status = 1 ORDER BY page_order ASC LIMIT 2");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($result as $row) {
                                $i++;
                            ?>
                                <li style="color: var(--white-color); font-size:16px;  ">
                                    <a href="numerology-detail.php?url=<?php echo $row['url']; ?>">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="8" height="12" viewBox="0 0 8 12">
                                                <path d="M8.000,5.998 L-0.002,11.997 L1.292,5.998 L-0.002,-0.001 
                     L8.000,5.998 ZM1.265,9.924 L6.502,5.998 
                     L1.265,2.071 L2.112,5.998 L1.265,9.924 
                     ZM5.451,5.998 L2.496,8.213 L2.974,5.998 
                     L2.496,3.783 L5.451,5.998 Z" class="cls-1" />
                                            </svg>
                                        </span>
                                        <?php echo ($row['ser_name']); ?>
                                    </a>
                                </li>
                            <?php
                            }
                            ?>
                            <li style="color:aliceblue; font-size:16px;  "> <a href="numerology.php">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="8" height="12" viewBox="0 0 8 12">
                                            <path d="M8.000,5.998 L-0.002,11.997 L1.292,5.998 L-0.002,-0.001 
                                 L8.000,5.998 ZM1.265,9.924 L6.502,5.998 
                                 L1.265,2.071 L2.112,5.998 L1.265,9.924 
                                 ZM5.451,5.998 L2.496,8.213 L2.974,5.998 
                                 L2.496,3.783 L5.451,5.998 Z" class="cls-1" />
                                        </svg>
                                    </span style="color:white;">
                                    View All
                                </a></li>
                        </ul>


                    </div>

                    <div class="as_footer_widget" style="margin: 0;">
                        <h3 class="as_footer_heading" style="color: var(--secondary-color);">Vaastu</h3>

                        <ul>
                            <?php
                            $i = 0;
                            $statement = $pdo->prepare("SELECT * FROM tbl_vaastu WHERE status = 1 ORDER BY page_order ASC LIMIT 2");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($result as $row) {
                                $i++;
                            ?>
                                <li style="color: var(--white-color); font-size:16px;  ">
                                    <a href="vaastu-detail.php?url=<?php echo $row['url']; ?>">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="8" height="12" viewBox="0 0 8 12">
                                                <path d="M8.000,5.998 L-0.002,11.997 L1.292,5.998 L-0.002,-0.001 
                     L8.000,5.998 ZM1.265,9.924 L6.502,5.998 
                     L1.265,2.071 L2.112,5.998 L1.265,9.924 
                     ZM5.451,5.998 L2.496,8.213 L2.974,5.998 
                     L2.496,3.783 L5.451,5.998 Z" class="cls-1" />
                                            </svg>
                                        </span>
                                        <?php echo ($row['ser_name']); ?>
                                    </a>
                                </li>
                            <?php
                            }
                            ?>
                            <li style="color:aliceblue; font-size:16px;  "> <a href="vaastu.php">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="8" height="12" viewBox="0 0 8 12">
                                            <path d="M8.000,5.998 L-0.002,11.997 L1.292,5.998 L-0.002,-0.001 
                                 L8.000,5.998 ZM1.265,9.924 L6.502,5.998 
                                 L1.265,2.071 L2.112,5.998 L1.265,9.924 
                                 ZM5.451,5.998 L2.496,8.213 L2.974,5.998 
                                 L2.496,3.783 L5.451,5.998 Z" class="cls-1" />
                                        </svg>
                                    </span style="color:white;">
                                    View All
                                </a></li>
                        </ul>


                    </div>
                </div>



                <?php
                $statement = $pdo->prepare("SELECT * FROM tbl_contact WHERE id=1");
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $address = $result['address'];
                    $phone_no_1 = $result['phone_no_1'];
                    $phone_no_2 = $result['phone_no_2'];
                    $email = $result['email'];
                    $map_links = $result['map_links'];
                    $shop_time = $result['shop_time'];
                ?>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="as_footer_widget">
                            <h3 class="as_footer_heading" style="color: var(--secondary-color);">Contact Us</h3>

                            <ul class="as_contact_list">
                                <li style="color: var(--white-color);  font-size:16px;  ">
                                    <img src="assets/images/svg/map.svg" alt="Cosmicenergies">
                                    <a href="contact.php">
                                        <p><?php echo ($address); ?></p>
                                    </a>
                                </li>
                                <li style="color: var(--white-color); font-size:16px;  ">
                                    <img src="assets/images/svg/address.svg" alt="Cosmicenergies">
                                    <p>
                                        <a href="mailto:<?php echo ($email); ?>">
                                            <span class="__cf_email__"><?php echo ($email); ?></span>
                                        </a>
                                    </p>
                                </li>
                                <li style="color: var(--white-color); font-size:16px;  ">
                                    <img src="./assets/my-images/chat-yellow.png" alt="Cosmicenergies" style="width: 20px;">
                                    <p>
                                        <a href="https://api.whatsapp.com/send?phone=<?php echo ($phone_no_1); ?>&text=Hello! Can I get more info on this ?.">
                                             <?php echo ($phone_no_1); ?>
                                        </a>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php
                }
                ?>

            </div>

        </div>
    </div>
</section>
<!-- Footer Section End -->
<!-- Footer section Extra Just For Bg  -->
<div class="" style="background: var(--primary-color);">
    <span style=" visibility: hidden;">sdfssfsdf</span>
</div>
<!-- Footer section Extra Just For Bg  -->

<!-- Footer Copyright Section Start  -->
<div style="background:var(--secondary-color)" class="no-bottom-gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p style="color: var(--primary-color); text-align: center; padding-top: 20px; height:30px;">
                    © cosmicenergies 2025 | All Rights Reserved
                    <a href="" style="display: none;"> Astrology Website Design - </a>
                    <a href="https://www.firstpointwebdesign.com/" target="_blank">Website
                        Design By - First Point Web Design</a>
                </p>
            </div>
        </div>
    </div>
</div>
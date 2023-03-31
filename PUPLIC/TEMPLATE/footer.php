
<footer class="section footer-section color-scheme-dark">
    <!-- Footer Top Start -->
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-3 col-xl-3 first-col">
                    <div class="widget-text mt-55"> <a href="#"><img src="../IMAGES/IMG_WEB/rosie-logo.png"
                                                                 height="100vh" alt="rosie"></a>
                        <p class="text_dark">Question or feedback?</p>
                        <div class="footer-top-info"> <a href="tel:+84 904859325"><i class="fa fa-phone"></i> +84 904859325</a>
                            <a href="tel:+84774911853"><i class="fa fa-phone"></i> +84 774911853</a>
                            <a href="mailto:roisiestore.hcm@gmail.com" class="text_dark">
                                <i class="fa fa-envelope"></i> roisiestore.hcm@gmail.com</a> </div>
                    </div>
                    <div class="app-stor"> <span><a href="#"><img src="../IMAGES/IMG_WEB/app-stor.png" alt="ayira"></a></span>
                        <span><a href="#"><img src="../IMAGES/IMG_WEB/google-play.png" alt="ayira"></a></span> </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 col-xl-3">
                    <div class="single-footer-widget mt-55">
                        <h2 class="widget-title">Company</h2>
                        <ul class="widget-list p-0">
                            <li><a href="#">About Us</a></li>
                            <li><a href="CONTACT.php">Get in Touch</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 col-xl-3">
                    <div class="single-footer-widget mt-55">
                        <h2 class="widget-title">Shop</h2>
                        <ul class="widget-list p-0">
                            <li><a href="NEW.php">New</a></li>
                            <li><a href="SPECIALPRICE.php">Sale & Special Offers</a></li>
                            <li><a href="MAKEUP.php">Make up</a></li>
                            <li><a href="SKINCARE.php">Skincare</a></li>
                            <li><a href="ACCESSORIES.php">Accessories</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3 col-xl-3">
                    <div class="single-footer-widget mt-55">
                        <h2 class="widget-title">Brands</h2>
                        <ul class="widget-list p-0">
                            <?php
                            $query="select * from BRAND";
                            $stmt=$dao->DML($query);
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                            $IDBR=$row['IDBR'];
                            $NAMEBR=$row['NAMEBR'];
                            ?>
                            <li><a href="SHOWPRO.php?IDBR=<?=$IDBR?>"><?=$NAMEBR?></a></li>
                            <?php
                            endwhile;
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Top End -->

    <!-- Footer Bottom Start -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-sm-12 col-lg-3">
                    <div class="copyright-content">
                        <p class="mb-0">&#169; 2021 RosieStore copyright </p>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-lg-6">
                    <div class="widget-social justify-content-start">
                        <ul class="d-flex m-0 p-0">
                            <li><a title="Facebook" href="#"><i class="fa fa-facebook-f"></i></a> </li>
                            <li><a title="Twitter" href="#"><i class="fa fa-twitter"></i></a> </li>
                            <li><a title="Youtube" href="#"><i class="fa fa-instagram"></i></a> </li>
                            <li><a title="Linkedin" href="#"><i class="fa fa-linkedin"></i></a> </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-lg-3">
                    <p class="m-0 payment"><img src="../IMAGES/IMG_WEB/payment.png" alt="ayira"></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Bottom End -->
</footer>
<!---->

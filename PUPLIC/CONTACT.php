<?php
session_start();
include("../DAO/DaoDatabase.php");
$dao = new DaoDatabase();

use PHPMailer\PHPMailer\PHPMailer;

require_once 'PHPMailer\Exception.php';
require_once 'PHPMailer\PHPMailer.php';
require_once 'PHPMailer\SMTP.php';

$mail = new PHPMailer(true);

$alert = '';

if(isset($_GET['submit'])){
    $name = $_GET['name'];
    $email = $_GET['email'];
    $phone = $_GET['phone'];
    $message = $_GET['message'];

    try{
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'roisiestore.hcm@gmail.com'; // Gmail address which you want to use as SMTP server
        $mail->Password = 'roisiestore$1234'; // Gmail address Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = '587';

        $mail->setFrom($email,$name); // Gmail address which you used as SMTP server
        $mail->addAddress('roisiestore.hcm@gmail.com'); // Email address where you want to receive emails
        // (you can use any of your gmail address including the gmail address which you used as SMTP server)

        $mail->isHTML(true);
        $mail->Subject = 'Message Received (Contact Page)';
        $mail->Body = "<h4>Name : $name 
                       <br>Email: $email
                       <br>Phone : $phone 
                       <br>Message : $message
                       </h4>";

        $mail->send();
        $alert = '<div class="alert-success">
                 <span>Message Sent! Thank you for contacting us.</span>
                </div>';
    } catch (Exception $e){
        $alert = '<div class="alert-danger">
                <span>'.$e->getMessage().'</span>
              </div>';
    }
}
?>

<!doctype html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="../IMAGES/IMG_WEB/favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../CSS/css/style.css">
    <link rel="stylesheet" href="../CSS/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/vendors/owlcarousel/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="../CSS/vendors/owlcarousel/css/owl.theme.default.min.css" />
    <link rel="stylesheet" href="../CSS/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="../CSS/css/flaticon.css">
    <title>CONTACT</title>
</head>
<body>

<div class="page-banner contact-page-banner section">
    <div class="container">
        <div class="page-banner-wrapper text-center">
            <h2 class="page-title">Contact Us</h2>
            <ul class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="HOME.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active">Contact Us</li>
            </ul>
        </div>
    </div>
</div>
<!-- page-banner End -->

<!-- My Account Start -->
<div class="faq section section-padding-03">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-7">
                <div class="section-title text-start">
                    <h4 class="title-small no_after text_dark">Let's get in touch</h4>
                    <span class="subtitle text_light  mt-3">There are no secrets to success. It is the result of preparation, hard work, and learning from failure</span> </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="single-contact-info d-flex">

                            <!-- Single Contact Icon Start -->
                            <div class="single-contact-icon"> <i class="fa fa-map-marker"></i> </div>
                            <!-- Single Contact Icon End -->

                            <!-- Single Contact Title Content Start -->
                            <p class="desc-content">24 Phan Liem<br>
                                Da Kao, District 1,<br>
                                Ho Chi Minh City</p>
                            <!-- Single Contact Title Content End -->

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="single-contact-info d-flex">

                            <!-- Single Contact Icon Start -->
                            <div class="single-contact-icon"> <i class="fa fa-phone"></i> </div>
                            <!-- Single Contact Icon End -->

                            <!-- Single Contact Title Content Start -->
                            <a href="tel:+84904859325" class="desc-content">+84 904859325</a>
                            &nbsp; &nbsp;<span style="color: #e6004c">or</span>  &nbsp;&nbsp;
                            <a href="tel:+84774911853" class="desc-content">+84 774911853</a>
                            <!-- Single Contact Title Content End -->

                        </div>
                        <div class="single-contact-info d-flex">

                            <!-- Single Contact Icon Start -->
                            <div class="single-contact-icon"> <i class="fa fa-envelope-o"></i> </div>
                            <!-- Single Contact Icon End -->

                            <!-- Single Contact Title Content Start -->
                            <a href="mailto:info@example.com" class="desc-content">roisiestore.hcm@gmail.com</a>
                            <!-- Single Contact Title Content End -->

                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-lg-6">
                        <div class="contact-social widget-social justify-content-start">
                            <ul class="d-flex m-0 p-0">
                                <li><a title="Facebook" href="#"><i class="fa fa-facebook-f"></i></a> </li>
                                <li><a title="Twitter" href="#"><i class="fa fa-twitter"></i></a> </li>
                                <li><a title="Youtube" href="#"><i class="fa fa-instagram"></i></a> </li>
                                <li><a title="Linkedin" href="#"><i class="fa fa-linkedin"></i></a> </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5">
                <div class="comments-all ask-question contact-us mt-0">
                    <div class="comments-wrpper">
                        <h4 class="comment-title">Contact Us</h4>
                        <h5 class="comment-sub-title">please feel free to to contact us, our customer support will be happy
                            to help you.</h5>
                        <div class="comments-form">
                            <form action="" method="get" onsubmit="return checkForm();">
                                <?php echo $alert; ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="single-form">
                                            <span class="required error"
                                                  id="name-alert"></span>
                                            <input type="text" name="name" id="name" placeholder="Name">
                                            <p id="info" style="color: red"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form">
                                            <input type="email" name="email" id="email" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form">
                                            <input type="text" name="phone" id="phone" placeholder="Phone">
                                            <p id="info1" style="color: red"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form">
                                            <textarea name="message" id="message" placeholder="Message" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="contact-single-form">
                                            <button name="submit" value="send" class="btn primary_dark_btn">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<!-- My Account End -->

<!-- Contact Map Start -->
<section class="contact-mape">

    <!-- Section Title Start -->
    <div class="container">
        <div class="section-title">
            <h2 class="title no_after">contact us</h2>
        </div>
    </div>
    <!-- Section Title End -->

    <!--Google Map Area Start-->
    <div class="google-map-area w-100">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.2829829435454!2d106.69300631462262!3d10.789624892312597!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528cb4ba30aa5%3A0x3a0ddc230888b922!2zMjQgUGhhbiBMacOqbSwgxJBhIEthbywgUXXhuq1uIDEsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1618999554447!5m2!1svi!2s" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    </div>
    <!--Google Map Area Start-->
</section>
<!-- Contact Map End -->


<footer class="section footer-section color-scheme-dark">
    <!-- Footer Top Start -->
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-3 col-xl-3 first-col">
                    <div class="widget-text mt-55"> <a href="#"><img src="../IMAGES/IMG_WEB/rosie-logo.png"
                                                                     height="90vh" alt="rosie"></a>
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



<script type="text/javascript">
    if(window.history.replaceState){
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<script src="../JS/LAN_JS/CONTACT.js"></script>
<script src="../JS/bootstrap.bundle.min.js"></script>
<script src="../JS/jquery-2.2.4.js"></script>
<script src="../CSS/vendors/owlcarousel/owl.carousel.min.js"></script>
<script src="../JS/custom.js"></script>
</body>
</html>
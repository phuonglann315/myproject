<?php
session_start();
include("../DAO/DaoDatabase.php");
$dao = new DaoDatabase();

use PHPMailer\PHPMailer\PHPMailer;

require_once 'PHPMailer\Exception.php';
require_once 'PHPMailer\PHPMailer.php';
require_once 'PHPMailer\SMTP.php';

$mail = new PHPMailer(true);
if (isset($_SESSION['USERNAME'])){
    header("Location:HOME.php");
}

?>
<!doctype html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image" href="../IMAGES/IMG_WEB/favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../CSS/css/style2.css">
    <link rel="stylesheet" href="../CSS/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/vendors/owlcarousel/css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="../CSS/vendors/owlcarousel/css/owl.theme.default.min.css"/>
    <link rel="stylesheet" href="../CSS/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="../CSS/css/flaticon.css">
    <link rel="stylesheet" type="text/css" href="../CSS/vendors/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="../CSS/vendors/lightGallery/css/lightgallery.css">

    <title>¨°o.O ROSIE STORE O.o°¨</title>
</head>

<body>
<div class="page-banner blog-page-banner section">
    <div class="container">
        <div class="page-banner-wrapper text-center">
            <h2 class="page-title">Reset Password</h2>
            <ul class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="HOME.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active" style="color:#ffb6c1 ">Reset Password</li>
            </ul>
        </div>
    </div>
</div>

<div class="section section-padding-04 section-padding-03">
    <div class="container">
        <div class="checkout-wrapper mt-0">

            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <?php
                    if (isset($_POST['vedified'])):
                        $EMAIL = $_POST['EMAIL'];
                        $username = $_POST['USERNAME'];
                        $query = "select count(USERNAME) as num from USERS where ( EMAIL = ? and USERNAME=? )";
                        $param = [
                            $EMAIL, $username
                        ];
                        $stmt = $dao->DMLParam($query, $param);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        $num=$row['num'];
                        if ($num != 1) {
                            $error = "Kindly check your infomation";
                            ?>
                            <div id="showmess" style="color: red"><h5><?= $error; ?></h5></div>
                            <?php
                        }
                        if ($num == 1) {
                            $query10 = "EXEC del_verified_time ";
                            $stmt10 = $dao->DML($query10);
                            $query2 = "select  count(USERNAME) as countuser from verified_action
                        where ( USERNAME=? )";
                            $param2 = [
                                $username
                            ];
                            $stmt2 = $dao->DMLParam($query2, $param2);
                            // nếu chưa thì cho vedifine
                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                            $countuser = $row2['countuser'];
                            //nếu chưa vedifi thì đổi
                            if ($countuser == 0) {
                                $verificationCode = md5(uniqid(mt_rand(), true));
                                $verificationLink = "http://localhost:8008/ROSIESTORE/PUPLIC/activeresetpass.php?code=" . $verificationCode;
                                try {
                                    $mail->isSMTP();
                                    $mail->Host = 'smtp.gmail.com';
                                    $mail->SMTPAuth = true;
                                    $mail->Username = 'roisiestore.hcm@gmail.com'; // Gmail address which you want to use as SMTP server
                                    $mail->Password = 'roisiestore$1234'; // Gmail address Password
                                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                    $mail->Port = '587';

                                    $mail->setFrom('roisiestore.hcm@gmail.com', 'Roisie Store'); // Gmail address which you used as SMTP server
                                    $mail->addAddress($EMAIL); // Email address where you want to receive emails
                                    // (you can use any of your gmail address including the gmail address which you used as SMTP server)

                                    $mail->isHTML(true);
                                    $mail->Subject = 'Verification email from Roses Store ';
                                    $mail->Body = 'Dear <strong>' . $username . '</strong> <br/> <br/>
                                       We receive request reset password for your account. <br/>
                                         Please click  <a href="' . $verificationLink . '">HERE</a> to verify your request: Reset Password<br/>
                                         
                                         if not you? Please ignore this email .<br/>
                                         
                                         Best Regards<br/>
                                         Rosie Store.
                                            
                                            ';
                                    $mail->send();

                                    $alert = "A verification email were sent to <i>" . $EMAIL . "</i>, please open your email inbox and click the link so you can reset password";

                                    $query1 = "insert into verified_action(USERNAME,verification_code) values (?,?) ";
                                    $param1 = [ $username,$verificationCode];
                                    $stmt1 = $dao->DMLParam($query1, $param1);

                                    ?>
                                    <div id="showmess"><h5><?= $alert; ?></h5></div>
                                    <?php


                                } catch (Exception $e) {
                                    $alert = '<div class="alert-danger">
                                    <span>' . $e->getMessage() . '</span>
                                  </div>';
                                }
                            }
                            if ($countuser > 0) {
                                $query10="EXEC del_verified_time ";
                                $stmt10=$dao->DML($query10);
                                $alert = "Please wait 5 minutes to request reset email account";
                                ?>
                                <div id="showmess"><h5><?= $alert; ?></h5></div>
                                <?php
                            }
                        }
                        endif;
                    ?>

                    <form method="POST" action="">
                        <div class="row">

                            <div class="col-md-12" style="margin-bottom: 10px">
                                <div class="single-form">
                                    <input type="text" name="USERNAME" placeholder="Your Username" style="width: 100%;">
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 10px">
                                <div class="single-form">
                                    <input type="text" name="EMAIL" placeholder="Your Email" style="width: 100%;">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="single-form d-flex justify-content-between submit_lost-password">
                                    <input type="submit" name="vedified" value="Send OTP" id="login1">
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="col-lg-4"></div>
            </div>
        </div>
    </div>
</div>

<?PHP

include("TEMPLATE/footer.php");
$dao->closeConn();
?>
<script src="../JS/XUAN_JS/HOME.js"></script>
<script src="../JS/bootstrap.bundle.min.js"></script>
<script src="../JS/jquery-2.2.4.js"></script>
<script src="../CSS/vendors/owlcarousel/owl.carousel.min.js"></script>
<script src="../JS/custom.js"></script>
</body>
</html>

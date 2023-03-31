<?php
session_start();
include("../DAO/DaoDatabase.php");
$dao = new DaoDatabase();

if (isset($_SESSION['USERNAME'])) {
    header("Location:HOME.php");
}
if (empty($_GET['code'])) {
    header("Location:HOME.php");
}
if (isset($_GET['code'])) {
    $verificationCode = $_GET['code'];
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
            <h2 class="page-title">My Account</h2>
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
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <?php
                    $query10 = "EXEC del_verified_time ";
                    $stmt10 = $dao->DML($query10);
                    $query = "SELECT count (USERNAME) AS num  FROM verified_action WHERE verification_code = ? ";
                    $param = [$verificationCode];
                    $stmt = $dao->DMLParam($query, $param);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $num = $row['num'];
                    // nếu mã này chỉ có 1 user name có mã
                    if ($num == 1) {
                        $query = "SELECT *  FROM verified_action WHERE verification_code = ? ";
                        $param = [$verificationCode];
                        $stmt = $dao->DMLParam($query, $param);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        $USERNAME=$row['USERNAME'];
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $query10 = "EXEC del_verified_time ";
                            $stmt10 = $dao->DML($query10);
                            $NEWPASS = $_POST['NEWPASS'];
                            $query1 = "UPDATE USERS SET PASS=? WHERE USERNAME=?";
                            $param1 = [$NEWPASS, $USERNAME];
                            $stmt1 = $dao->DMLParam($query1, $param1);
                            $query = "delete verified_action WHERE USERNAME=?";
                            $param = [$USERNAME];
                            $stmt = $dao->DMLParam($query, $param);
                            $error = "Reset Pass number successfully";
                            ?>
                            <div class="error maintenance">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 text-center"></div>
                                        <div class="col-lg-7 col-md-7 text-center">
                                            <div class="center_fix">
                                                <div class="error_form">
                                                    <h1 class="title no_after"><?= $error ?></h1>
                                                    <h2 class="sub-title">Kindly click <a href="HOME.php"
                                                                                          class="sub-title">here</a> to
                                                        login</h2>

                                                    <div class="col-lg-6 col-md-6"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        } else {
                            ?>
                            <form method="POST" action="" onsubmit="return CHECK();">
                                <div class="row">
                                    <div class="col-md-12" style="margin-bottom: 10px">
                                        <div class="single-form">
                                        <span class="required error"
                                              id="NEWPASS-info"></span>
                                            <input type="password" id="NEWPASS" name="NEWPASS"
                                                   placeholder="Your New Pass" style="width: 100%;">
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-bottom: 10px">
                                        <div class="single-form">
                                        <span class="required error"
                                              id="CFPASS-info"></span>
                                            <input type="password" name="CFPASS" id="CFPASS"
                                                   placeholder="Confirm Your New Pass" style="width: 100%;">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form d-flex justify-content-between submit_lost-password">
                                            <input type="submit" name="Reset Password" value="Reset Password"
                                                   id="login1">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <?php
                        }
                    } else {
                        $error = "Time Up ! kindly re-submit request";
                        ?>
                        <div class="error maintenance">
                            <div class="container-fluid">
                                <div class="row">

                                    <div class="col-lg-12 col-md-12 text-center">
                                        <div class="center_fix">
                                            <div class="error_form">
                                                <h1 class="title no_after"><?= $error ?></h1>
                                                <div class="col-lg-6 col-md-6"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                </div>
                <div class="col-lg-2"></div>
            </div>
        </div>
    </div>
</div>

<?PHP

$dao->closeConn();
?>
<script src="../JS/XUAN_JS/check.js"></script>
<script src="../JS/bootstrap.bundle.min.js"></script>
<script src="../JS/jquery-2.2.4.js"></script>
<script src="../CSS/vendors/owlcarousel/owl.carousel.min.js"></script>
<script src="../JS/custom.js"></script>
</body>
</html>


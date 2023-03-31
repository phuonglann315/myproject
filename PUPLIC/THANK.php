<?php
session_start();
include("../DAO/DaoDatabase.php");
$dao = new DaoDatabase();
$cart = (isset($_SESSION['cart'])) ? $_SESSION['cart'] : [];
$subtotal=0;
$total=0;
foreach ($cart as $IDPR => $value):
    $subtotal+=($value['NEWPRICE']*$value['QUANTITY']);
    $total+=1;
endforeach;
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image" href="../IMAGES/IMG_WEB/favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../CSS/css/style.css">
    <link rel="stylesheet" href="../CSS/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/vendors/owlcarousel/css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="../CSS/vendors/owlcarousel/css/owl.theme.default.min.css"/>
    <link rel="stylesheet" href="../CSS/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="../CSS/css/flaticon.css">

    <title>¨°o.O ROSIE STORE O.o°¨</title>
</head>
<body>
<?PHP
include("TEMPLATE/header.php")
?>
<!-- My Account Start -->
<div class="error maintenance">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 text-center"></div>
            <div class="col-lg-7 col-md-7 text-center">
                <div class="center_fix">
                    <div class="error_form">
                        <h1 class="title no_after">Thank you for your order</h1>
                        <h2 class="sub-title">Kindly follow order status on <a href="USER.php" class="sub-title">My Account</a></h2>

                        <div class="col-lg-6 col-md-6"> </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- My Account End -->

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="../JS/bootstrap.bundle.min.js"></script>
<script src="../JS/jquery-2.2.4.js"></script>
<script src="../CSS/vendors/owlcarousel/owl.carousel.min.js"></script>
<script src="../JS/custom.js"></script>


</body>
</html>

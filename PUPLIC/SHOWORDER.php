<?php
session_start();
include("../DAO/DaoDatabase.php");
$dao = new DaoDatabase();
if (isset($_SESSION['USERNAME'])) {
    if ($_SESSION['USERNAME'] != 'admin') {
        $username = $_SESSION['USERNAME'];
        if (isset($_GET['IDIV'])) {
            $IDIV = $_GET['IDIV'];

        } else {
            header("Location:HOME.php");
        }
    } else {
        header("Location:HOME.php");
    }

} else {
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

    <title>¨°o.O ROSIE STORE O.o°¨</title>
</head>
<body>
<div class="page-banner blog-page-banner section">
    <div class="container">
        <div class="page-banner-wrapper text-center">
            <h2 class="page-title">My Account</h2>
            <ul class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="HOME.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="USER.php"><i class="fa fa-user"></i> My account</a></li>
                <li class="breadcrumb-item active" style="color:#ffb6c1 ">Show order</li>
            </ul>
        </div>
    </div>
</div>
<!-- page-banner End -->

<div class="section section-padding-04 section-padding-03">
    <div class="container">
        <div class="my-account-order account-wrapper mt-6">
            <h4 class="account-title">Orders No <?=$IDIV?></h4>
        <?php
        $query='SELECT D.IDPR AS IDPR,NAMEPR,QUANTITY_order,D.PRICE as PRICE
FROM details_ORDERS D
inner join PRODUCT P on D.IDPR=P.IDPR
WHERE IDIV=?';

        $param=[$IDIV];
        $stmt = $dao->DMLParam($query, $param);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
            $IDPR = $row['IDPR'];
            ?>
            <div class="account-table">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3">
                                <?php
                                $query1="select * from IMAGES where IDPR=?";
                                $param1=[$IDPR];
                                $stmt1=$dao->DMLParam($query1,$param1);
                                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                                $NAMEIM=$row1['NAMEIM'];
                                ?>
                                <div class="order-img"><img class="w-100" src="../IMAGES/IMG_PRO/<?=$NAMEIM?>" alt="<?=$row['NAMEPR']?>"></div>
                            </div>
                            <div class="col-md-8">
                                <div class="product-info">
                                    <div class="product-title"> <a href="PRO_DETAILS.php?IDPR=<?=$IDPR?>"><?=$row['NAMEPR']?></a> </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"> <span class="sale-price"> VND <?=$row['PRICE']?></span> </div>
                    <div class="col-md-4">
                        <div class="delivered_status"> <div class="delivered-date">
                                <div class="delivered"></div>
                                Quantity: <?=$row['QUANTITY_order']?></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        endwhile;
        ?>
        </div>
    </div>
</div>
<script src="../JS/XUAN_JS/USER.js"></script>
<script src="../JS/bootstrap.bundle.min.js"></script>
<script src="../JS/jquery-2.2.4.js"></script>
<script src="../CSS/vendors/owlcarousel/owl.carousel.min.js"></script>
<script src="../JS/custom.js"></script>
</body>
</html>
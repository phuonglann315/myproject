<?php
session_start();
include("../DAO/DaoDatabase.php");
$dao = new DaoDatabase();
if (isset($_GET['IDPR'])) {
    $IDPR = $_GET['IDPR'];
    $query = "select TOP(1) NAMEIM,NAMEPR,PRICE,NAMEBR,BRIEFSUM,QUANTITY,P.IDCTGR as IDCTGR,P.IDBR as IDBR from PRODUCT P 
inner join  IMAGES I on P.IDPR=I.IDPR 
inner join  BRAND B on P.IDBR=B.IDBR
inner join  CATEGORY C on P.IDCTGR=C.IDCTGR
WHERE  P.IDPR=? and STATUSPRO  =1";
    $param = [$IDPR];
    $stmt = $dao->DMLParam($query, $param);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $NAMEIM = $row['NAMEIM'];
    $NAMEPR = $row['NAMEPR'];
    $PRICE = $row['PRICE'];
    $NAMEBR = $row['NAMEBR'];
    $BRIEFSUM = $row['BRIEFSUM'];
    $QUANTITY = $row['QUANTITY'];
    $IDCTGR = $row['IDCTGR'];
    $IDBR = $row['IDBR'];


} else {
    header("location:HOME.php");
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
    <link rel="stylesheet" href="../CSS/css/style1.css">
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
            <h2 class="page-title">Compare</h2>
            <ul class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="HOME.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active">Compare</li>
            </ul>
        </div>
    </div>
</div>
<div class="highlights">
    <div class="container">
        <div class="all_highlights">
            <div class="row">
                <div class="col-sm-6 col-md-3 col-xl-3">
                    <!-- Free Shipping Start  -->
                    <div class="free_shipping border-start-0 ps-0">
                        <div class="icone"><i class="flaticon-shipped"></i></div>
                        <div class="free_shipping_info">
                            <h5>Free Shipping</h5>
                            <p>Free for $50+ orders</p>
                        </div>
                    </div>
                </div>
                <!-- Free Shipping End -->

                <div class="col-sm-6 col-md-3 col-xl-3">
                    <!-- Easy Returns Start  -->
                    <div class="free_shipping">
                        <div class="icone"><i class="flaticon-return-box"></i></div>
                        <div class="free_shipping_info">
                            <h5>Easy Returns</h5>
                            <p>14 Days easy return</p>
                        </div>
                    </div>
                </div>
                <!-- Easy Returns End -->

                <!-- Fast Support Start  -->
                <div class="col-sm-6 col-md-3 col-xl-3">
                    <div class="free_shipping">
                        <div class="icone"><i class="flaticon-support"></i></div>
                        <div class="free_shipping_info">
                            <h5>Fast Support</h5>
                            <p>24/7 Customer support</p>
                        </div>
                    </div>
                </div>
                <!-- Fast Support End -->

                <!-- Member Discoun Start  -->
                <div class="col-sm-6 col-md-3 col-xl-3">
                    <div class="free_shipping border-bottom-0">
                        <div class="icone"><i class="flaticon-offer"></i></div>
                        <div class="free_shipping_info">
                            <h5>Member Discount</h5>
                            <p>Discount for elite members</p>
                        </div>
                    </div>
                </div>
                <!-- Member Discoun End -->

            </div>
        </div>
    </div>
</div>
<div class="section section-padding-04 section-padding-03">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Compare Page Content Start -->
                <div class="compare-page-content-wrap">
                    <div class="compare-table table-responsive">
                        <!-- Compare Table Start -->
                        <table class="table table-bordered mb-0">
                            <tbody>
                            <tr>
                                <td class="first-column">Product</td>
                                <td class="product-image-title">
                                    <a href="PRO_DETAILS.php?IDPR=<?=$IDPR?>" class="image">
                                        <img class="thumbnail" src="../IMAGES/IMG_PRO/<?=$NAMEIM?>" alt="">
                                    </a>
                                    <a href="PRO_DETAILS.php?IDPR=<?= $IDPR ?>"
                                       class="title no_after"><?= $NAMEPR?></a>
                                </td>
                                <?php
                                $query1 = "select TOP(1) P.IDPR, NAMEIM,NAMEPR,P.IDBR as IDBR from PRODUCT P 
                                inner join  IMAGES I on P.IDPR=I.IDPR 
                                inner join  BRAND B on P.IDBR=B.IDBR
                                inner join  CATEGORY C on P.IDCTGR=C.IDCTGR
                                WHERE  P.IDBR!=? and STATUSPRO =1 and P.IDCTGR=?";
                                $param1 = [$IDBR,$IDCTGR];
                                $stmt1 = $dao->DMLParam($query1, $param1);
                                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                                $IDBR1 = $row1['IDBR'];
                                    $IDPR1 = $row1['IDPR'];
                                $NAMEIM1 = $row1['NAMEIM'];
                                $NAMEPR1 = $row1['NAMEPR'];
                                ?>
                                <td class="product-image-title">
                                    <a href="PRO_DETAILS.php?IDPR=<?=$IDPR1?>" class="image">
                                        <img class="thumbnail" src="../IMAGES/IMG_PRO/<?=$NAMEIM1?>" alt="">
                                    </a>
                                    <a href="PRO_DETAILS.php?IDPR=<?=$IDPR1?>"
                                       class="title no_after"><?=$NAMEPR1?></a>
                                </td>
                                <?php
                                $query2 = "select TOP(1) P.IDPR, NAMEIM,NAMEPR,P.IDBR  from PRODUCT P 
                                inner join  IMAGES I on P.IDPR=I.IDPR 
                                inner join  BRAND B on P.IDBR=B.IDBR
                                inner join  CATEGORY C on P.IDCTGR=C.IDCTGR
                                WHERE  P.IDBR!=? AND P.IDBR!=? and STATUSPRO =1 and P.IDCTGR=?";
                                $param2 = [$IDBR,$IDBR1,$IDCTGR];
                                $stmt2 = $dao->DMLParam($query2, $param2);
                                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                $IDBR2 = $row2['IDBR'];
                                $IDPR2 = $row2['IDPR'];
                                $NAMEIM2 = $row2['NAMEIM'];
                                $NAMEPR2 = $row2['NAMEPR'];
                                ?>
                                <td class="product-image-title">
                                    <a href="PRO_DETAILS.php?IDPR=<?=$IDPR2?>" class="image">
                                        <img class="thumbnail" src="../IMAGES/IMG_PRO/<?=$NAMEIM2?>" alt="">
                                    </a>
                                    <a href="PRO_DETAILS.php?IDPR=<?=$IDPR2?>"
                                       class="title no_after"><?=$NAMEPR2?></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="first-column">Brand</td>
                                <td class="pro-price"><?=$NAMEBR?></td>
                                <?php
                                $query1 = "select TOP(1) NAMEIM,NAMEPR,PRICE,NAMEBR,BRIEFSUM,QUANTITY,P.IDBR as IDBR  from PRODUCT P 
                                            inner join  IMAGES I on P.IDPR=I.IDPR 
                                            inner join  BRAND B on P.IDBR=B.IDBR
                                            inner join  CATEGORY C on P.IDCTGR=C.IDCTGR
                                            WHERE  P.IDBR!=? and STATUSPRO =1 and P.IDCTGR=?";
                                $param1 = [$IDBR,$IDCTGR];
                                $stmt1 = $dao->DMLParam($query1, $param1);
                                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                                $IDBR1 = $row1['IDBR'];
                                    $NAMEBR1 = $row1['NAMEBR'];
                                    ?>
                                    <td class="pro-price"><?=$NAMEBR1?></td>
                                <?php
                                $query2 = "select TOP(1) NAMEIM,NAMEPR,PRICE,NAMEBR,BRIEFSUM,QUANTITY  from PRODUCT P 
inner join  IMAGES I on P.IDPR=I.IDPR 
inner join  BRAND B on P.IDBR=B.IDBR
inner join  CATEGORY C on P.IDCTGR=C.IDCTGR
WHERE  P.IDBR!=? and P.IDBR!=? and STATUSPRO =1 and P.IDCTGR=? ";
                                $param2 = [$IDBR,$IDBR1,$IDCTGR];
                                $stmt2 = $dao->DMLParam($query2, $param2);
                                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                $NAMEBR2 = $row2['NAMEBR'];
                                ?>
                                <td class="pro-price"><?=$NAMEBR2?></td>
                            </tr>
                            <tr>
                                <td class="first-column">Briefsum</td>
                                <td class="pro-desc">
                                    <p> <?=$BRIEFSUM?></p>
                                </td>
                                <?php
                                $query1 = "select TOP(1) NAMEIM,NAMEPR,PRICE,NAMEBR,BRIEFSUM,QUANTITY,P.IDBR as IDBR  from PRODUCT P 
inner join  IMAGES I on P.IDPR=I.IDPR 
inner join  BRAND B on P.IDBR=B.IDBR
inner join  CATEGORY C on P.IDCTGR=C.IDCTGR
WHERE  P.IDBR!=? and STATUSPRO = 1 and P.IDCTGR=?";
                                $param1 = [$IDBR,$IDCTGR];
                                $stmt1 = $dao->DMLParam($query1, $param1);
                                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                                $IDBR1=$row1['IDBR'];
                                    $BRIEFSUM1 = $row1['BRIEFSUM'];

                                    ?>
                                    <td class="pro-desc">
                                        <p> <?=$BRIEFSUM1?></p>
                                    </td>
                                <?php
                                $query2 = "select TOP(1) NAMEIM,NAMEPR,PRICE,NAMEBR,BRIEFSUM,QUANTITY  from PRODUCT P
                                inner join  IMAGES I on P.IDPR=I.IDPR
                                inner join  BRAND B on P.IDBR=B.IDBR
                                inner join  CATEGORY C on P.IDCTGR=C.IDCTGR
                                WHERE  P.IDBR!=? and P.IDBR!=? and STATUSPRO =1 and P.IDCTGR=? ";
                                $param2 = [$IDBR,$IDBR1,$IDCTGR];
                                $stmt2 = $dao->DMLParam($query2, $param2);
                                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                $BRIEFSUM2 = $row2['BRIEFSUM'];

                                ?>
                                <td class="pro-desc">
                                    <p> <?=$BRIEFSUM2?></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="first-column">Price</td>
                                <td class="pro-price">VND <?=$PRICE?></td>
                                <?php
                                $query1 = "select TOP(1) NAMEIM,NAMEPR,PRICE,NAMEBR,BRIEFSUM,QUANTITY,P.IDBR as IDBR  from PRODUCT P 
inner join  IMAGES I on P.IDPR=I.IDPR 
inner join  BRAND B on P.IDBR=B.IDBR
inner join  CATEGORY C on P.IDCTGR=C.IDCTGR
WHERE  P.IDBR!=? and STATUSPRO =1 and P.IDCTGR=?";
                                $param1 = [$IDBR,$IDCTGR];
                                $stmt1 = $dao->DMLParam($query1, $param1);
                                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                                $IDBR1=$row1['IDBR'];
                                    $PRICE1 = $row1['PRICE'];
                                    ?>
                                    <td class="pro-price">VND <?=$PRICE1?></td>
                                <?php
                                $query2 = "select TOP(1) NAMEIM,NAMEPR,PRICE,NAMEBR,BRIEFSUM,QUANTITY  from PRODUCT P
                                inner join  IMAGES I on P.IDPR=I.IDPR
                                inner join  BRAND B on P.IDBR=B.IDBR
                                inner join  CATEGORY C on P.IDCTGR=C.IDCTGR
                                WHERE  P.IDBR!=? and P.IDBR!=? and STATUSPRO =1 and P.IDCTGR=? ";
                                $param2 = [$IDBR,$IDBR1,$IDCTGR];
                                $stmt2 = $dao->DMLParam($query2, $param2);
                                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                $PRICE2 = $row2['PRICE'];
                                ?>
                                <td class="pro-price">VND <?=$PRICE2?></td>
                            </tr>

                            <tr>
                                <td class="first-column">color</td>
                                <td class="pro-color">
                                    <div class="widget-color">
                                        <ul class="color-list ps-0">
                                            <?php
                                            $query = "select * from IMAGES where IDPR=? and DETAILQUANTITY >0";
                                            $param = [$IDPR];
                                            $stmt = $dao->DMLParam($query, $param);
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                            $COLOR = $row['COLOR'];
                                            ?>
                                            <li class="active ms-0" data-tooltip="tooltip" data-placement="top"
                                                data-color="<?= $COLOR ?>"></li>&nbsp; &nbsp;
                                            <?php
                                                endwhile;
                                                ?>

                                        </ul>
                                    </div>
                                </td>
                                <?php
                                $query1 = "select TOP(1) P.IDPR as IDPR,P.IDBR as IDBR  from PRODUCT P 
                                    inner join  IMAGES I on P.IDPR=I.IDPR 
                                    inner join  BRAND B on P.IDBR=B.IDBR
                                    inner join  CATEGORY C on P.IDCTGR=C.IDCTGR
                                    WHERE  P.IDBR!=? and STATUSPRO =1 and P.IDCTGR=?";
                                $param1 = [$IDBR,$IDCTGR];
                                $stmt1 = $dao->DMLParam($query1, $param1);
                               $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                                    $IDPR1 = $row1['IDPR'];
                                $IDBR1=$row1['IDBR'];
                                    ?>
                                    <td class="pro-color">
                                        <div class="widget-color">
                                            <ul class="color-list ps-0">
                                                <?php
                                                $query = "select * from IMAGES where IDPR=? and DETAILQUANTITY >0";
                                                $param = [$IDPR1];
                                                $stmt = $dao->DMLParam($query, $param);
                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                                    $COLOR = $row['COLOR'];
                                                    ?>
                                                    <li class="active ms-0" data-tooltip="tooltip" data-placement="top"
                                                        data-color="<?= $COLOR ?>"></li>&nbsp; &nbsp;
                                                <?php
                                                endwhile;
                                                ?>

                                            </ul>
                                        </div>
                                    </td>
                                <?php
                                $query2 = "select TOP(1) P.IDPR as IDPR  from PRODUCT P
                                inner join  IMAGES I on P.IDPR=I.IDPR
                                inner join  BRAND B on P.IDBR=B.IDBR
                                inner join  CATEGORY C on P.IDCTGR=C.IDCTGR
                                WHERE  P.IDBR!=? and P.IDBR!=? and STATUSPRO = 1 and P.IDCTGR=? ";
                                $param2 = [$IDBR,$IDBR1,$IDCTGR];
                                $stmt2 = $dao->DMLParam($query2, $param2);
                                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                $IDPR2 = $row2['IDPR'];
                                ?>
                                <td class="pro-color">
                                    <div class="widget-color">
                                        <ul class="color-list ps-0">
                                            <?php
                                            $query = "select * from IMAGES where IDPR=? and DETAILQUANTITY >0";
                                            $param = [$IDPR2];
                                            $stmt = $dao->DMLParam($query, $param);
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                                $COLOR = $row['COLOR'];
                                                ?>
                                                <li class="active ms-0" data-tooltip="tooltip" data-placement="top"
                                                    data-color="<?= $COLOR ?>"></li>&nbsp; &nbsp;
                                            <?php
                                            endwhile;
                                            ?>

                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="first-column">Stock</td>
                                <td class="pro-stock">In Stock</td>
                                <td class="pro-stock">In Stock</td>
                                <td class="pro-stock">In Stock</td>
                            </tr>


                            </tbody>
                        </table>
                        <!-- Compare Table End -->
                    </div>
                </div>
                <!-- Compare Page Content End -->
            </div>
        </div>

    </div>
</div>

<?PHP
include("TEMPLATE/footer.php")
?>

<?PHP

$dao->closeConn();
?>
<script src="../JS/XUAN_JS/HOME.js"></script>
<script src="../JS/bootstrap.bundle.min.js"></script>
<script src="../JS/jquery-2.2.4.js"></script>
<script src="../CSS/vendors/owlcarousel/owl.carousel.min.js"></script>
<script src="../JS/custom.js"></script>
</body>
</html>

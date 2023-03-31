<?php
session_start();
include("../DAO/DaoDatabase.php");
$dao = new DaoDatabase();
$cart = (isset($_SESSION['cart'])) ? $_SESSION['cart'] : [];
$subtotal = 0;
$total = 0;
foreach ($cart as $IDPR => $value):
    $subtotal += ($value['NEWPRICE'] * $value['QUANTITY']);
    $total += 1;
endforeach;

if (isset($_GET['IDPR'])) {
    $IDPR = $_GET['IDPR'];
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

    <link rel="stylesheet" href="../CSS/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/vendors/owlcarousel/css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="../CSS/vendors/owlcarousel/css/owl.theme.default.min.css"/>
    <link rel="stylesheet" href="../CSS/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="../CSS/css/flaticon.css">
    <link rel="stylesheet" type="text/css" href="../CSS/vendors/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="../CSS/vendors/lightGallery/css/lightgallery.css">
    <link rel="stylesheet" href="../CSS/css/style1.css">
    <title>¨°o.O ROSIE STORE O.o°¨</title>
</head>
<body>
<?PHP
include("TEMPLATE/header.php")
?>
<section class="winter-sale color-scheme-white">
    <div class="container">
        <div class="row">
            <div class="col-sx-12 col-sm-6 col-md-6 col-lg-6 align-self-center">
                <h4 class="title text_dark no_after">love rised me, lipstick saves me</h4>
                <span class="title-subtitle text_light"> A secret makes a woman woman</span> <a
                        href="SHOWPRO.php?IDCTGR=CT1" class="primary_dark_btn primary_bg_sky_hover">Shop Now</a></div>
            <div class="col-sx-12 col-sm-6 col-md-6 col-lg-6"><img class="winter_sale"
                                                                   src="../IMAGES/IMG_WEB/winter.png" alt=""></div>
        </div>
    </div>
</section>
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
                            <p>Free for all orders</p>
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
<section class="section-padding-03 section-padding-02 product-image-summary product-v-three">
    <div class="container">
        <div class="row">
            <div class="col-md-6 product-images position-relative">
                <!-- Product Details Image Start -->
                <div class="product-details-img">
                    <!-- Single Product Image Start -->
                    <div class="slider slider-five popup-gallery">
                        <?php
                        $query3 = "select NAMEIM from IMAGES where IDPR=?";
                        $param3 = [$IDPR];
                        $stmt3 = $dao->DMLParam($query3, $param3);
                        while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)):
                            $NAMEIM3 = $row3['NAMEIM'];
                            ?>
                            <div class="slick-slide" data-src="../IMAGES/IMG_PRO/<?= $NAMEIM3 ?>">
                                <img src="../IMAGES/IMG_PRO/<?= $NAMEIM3 ?>" alt="Product" style="height: 45vh;
    position: relative;
    left: 10vw;
    top: 0px;
    z-index: 999;
    opacity: 1;">
                            </div>
                        <?php
                        endwhile;
                        ?>
                    </div>

                    <div class="slider slider-nav slider-thumb">
                        <?php
                        $query3 = "select NAMEIM from IMAGES where IDPR=?";
                        $param3 = [$IDPR];
                        $stmt3 = $dao->DMLParam($query3, $param3);
                        while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)):
                            $NAMEIM3 = $row3['NAMEIM'];
                            ?>
                            <div class="divide">
                                <img src="../IMAGES/IMG_PRO/<?= $NAMEIM3 ?>" alt="Product"
                                     style="height: 15vh;width: 10vw;border: 1px solid #ffb6c1;">
                            </div>
                        <?php
                        endwhile;
                        ?>

                    </div>
                    <!-- Single Product Thumb End -->
                    <button id="btn" class="zoom"><i class="flaticon-search-2"></i></button>
                </div>
                <!-- Product Details Image End -->
            </div>

            <div class="col-md-6 summary entry-summary">
                <?php
                $query = "select *
                    from (select IDPR,NAMEPR,PRICE,BRIEFSUM,CREATEDATE,QUANTITY ,DESCRIPTION,NAMEBR,PRODUCT.IDBR AS IDBR,NAMECTGR,
            
                     [STT]=  CASE
                     when DATEDIFF(MONTH,CREATEDATE,getdate())<1 then 'NEW'
                     when DATEDIFF(MONTH,CREATEDATE,getdate())=3 then '20%'
                     when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then '25%'
                     when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then '30%'
                             end ,
                     [NEWPRICE]=  CASE
                     when DATEDIFF(MONTH,CREATEDATE,getdate()) <3 then PRICE
                    when DATEDIFF(MONTH,CREATEDATE,getdate()) =3 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.2) AS decimal(7,0))
                     when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.25) AS decimal(7,0))
                     when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.3) AS decimal(7,0))                      
                             end 
                             from PRODUCT 
                      inner join BRAND on PRODUCT.IDBR=BRAND.IDBR
                           inner join CATEGORY on PRODUCT.IDCTGR=CATEGORY.IDCTGR
                             where PRODUCT.IDPR=? ) T ";
                $param = [$IDPR];
                $stmt = $dao->DMLParam($query, $param);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $NAMEPR = $row['NAMEPR'];
                $DESCRIPTION = $row['DESCRIPTION'];
                $BRIEFSUM = $row['BRIEFSUM'];
                $STT = $row['STT'];
                $NEWPRICE = $row['NEWPRICE'];
                $NAMEBR = $row['NAMEBR'];
                $IDBR = $row['IDBR'];
                $NAMECTGR = $row['NAMECTGR'];
                ?>

                <div class="product-list-item">

                    <div class="product-content">

                        <div class="product-category-action pt-0 d-block">
                            <div class="product-title"><h4><?= $NAMEPR ?></h4></div>
                            <div class="product-info pt-1">
                                <div> BRAND : <a href="SHOWPRO.php?IDBR=<?= $IDBR ?>"
                                                 style="color: black"><strong><?= $NAMEBR ?></strong></a></div>
                            </div>

                        </div>


                        <div class="product-price">
                            <div class="sale-price">VND <?= number_format($NEWPRICE) ?></div>
                        </div>


                        <div class="short-description">
                            <p><?= $BRIEFSUM ?></p>
                        </div>

                        <?php
                        $query = "select COLOR from IMAGES where IDPR=? and  DETAILQUANTITY >0";
                        $param = [$IDPR];
                        $stmt = $dao->DMLParam($query, $param);
                        ?>
                        <div class="d-flex quantity-cart_button">
                            <h4 class="widget-title">Color : </h4>
                            <div class="widget-color">
                                <div class="widget-item d-flex">
                                    <div class="widget-color">
                                        <ul class="color-list ps-0">
                                            <?php
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                                $COLOR = $row['COLOR'];
                                                if ($COLOR != null) {
                                                    ?>

                                                    <li class="active ms-0" data-tooltip="tooltip" data-placement="top"
                                                        data-color="<?= $COLOR ?>"></li>&nbsp; &nbsp;
                                                    <?php
                                                } else {
                                                    ?>
                                                    <h6 style="margin-top: 24px">default</h6> <INPUT type="hidden"
                                                                                                    value="colordefaul"
                                                                                                    name="COLOR">
                                                    <?php
                                                }
                                            endwhile;
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php

                        ?>
                        <FORM method="get" action="CART.php">
                            <INPUT type="hidden" value="<?= $IDPR ?>" name="IDPR">
                            <div class="d-flex quantity-cart_button">
                                <div class="product-quantity d-inline-flex">
                                    <button type="button" class="sub">-</button>
                                    <input type="text" value="1" name="QUANTITY">
                                    <button type="button" class="add">+</button>
                                </div>
                                <div class="ayira-cart-btn">
                                    <div class="btn-add header-action-btn-cart">
                                        <button type="submit" value="add" class="add_to_cart_button">Add to Cart
                                        </button>
                                        <a href="./order.php?IDPR=<?=$IDPR?>" class="load-more primary_dark_btn" style="position: relative;margin-left: 5px;
    top: -3px">Buy Now</a>
                                    </div>

                                    <!-- View All Products End -->
                                </div>
                            </div>
                        </FORM>
                        <!-- product-info Start -->
                        <div class="product-info">
                            <div class="single-info"><span class="label">Share : </span>
                                <ul class="d-flex m-0 p-0 ps-2">
                                    <li><a title="Facebook" class="facebook" href="https://www.facebook.com/"><i
                                                    class="fa fa-facebook-f"></i></a></li>
                                    <li><a title="Twitter" class="twitter" href="https://twitter.com/"><i
                                                    class="fa fa-twitter"></i></a>
                                    </li>
                                    <li><a title="instagram" class="instagram" href="https://www.instagram.com/"><i
                                                    class="fa fa-instagram"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- product-info Start -->
                        <?php
                        $query = "select *
                    from (select IDPR,NAMEPR,PRICE,BRIEFSUM,CREATEDATE,QUANTITY ,DESCRIPTION,NAMEBR,PRODUCT.IDBR AS IDBR,NAMECTGR,
            
                     [STT]=  CASE
                     when DATEDIFF(MONTH,CREATEDATE,getdate())<1 then 'NEW'
                     when (DATEDIFF(MONTH,CREATEDATE,getdate())>1 and DATEDIFF(MONTH,CREATEDATE,getdate())<3 )then 'nomarl'
                     
                     when DATEDIFF(MONTH,CREATEDATE,getdate())=3 then '20%'
                     when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then '25%'
                     when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then '30%'
                             end ,
                     [NEWPRICE]=  CASE
                     when DATEDIFF(MONTH,CREATEDATE,getdate()) <3 then PRICE
                       when (DATEDIFF(MONTH,CREATEDATE,getdate())>1 and DATEDIFF(MONTH,CREATEDATE,getdate())<3 )then PRODUCT.PRICE
                    when DATEDIFF(MONTH,CREATEDATE,getdate()) =3 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.2) AS decimal(7,0))
                     when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.25) AS decimal(7,0))
                     when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.3) AS decimal(7,0))                      
                             end 
                             from PRODUCT 
                      inner join BRAND on PRODUCT.IDBR=BRAND.IDBR
                           inner join CATEGORY on PRODUCT.IDCTGR=CATEGORY.IDCTGR
                             where PRODUCT.IDPR=? ) T ";
                        $param = [$IDPR];
                        $stmt = $dao->DMLParam($query, $param);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        $NAMEPR = $row['NAMEPR'];
                        $DESCRIPTION = $row['DESCRIPTION'];
                        $BRIEFSUM = $row['BRIEFSUM'];
                        $STT = $row['STT'];
                        $NEWPRICE = $row['NEWPRICE'];
                        $NAMEBR = $row['NAMEBR'];
                        $IDBR = $row['IDBR'];
                        $NAMECTGR = $row['NAMECTGR'];
                        ?>
                        <!-- Widget Item Start -->
                        <div class="widget-item">
                            <div class="product-details-tabs widget-link">
                                <ul class="ps-0">
                                    <li><a href="#">Description</a>
                                        <div class="category-toggle collapsed" data-bs-toggle="collapse"
                                             data-bs-target="#category01"><span class="add"><i
                                                        class="fa fa-angle-down"></i></span> <span class="remove"><i
                                                        class="fa fa-angle-up"></i></span></div>
                                        <div class="collapse" id="category01">
                                            <div class="product-anotherinfo-wrapper">
                                                <div class="row w-100">
                                                    <div class="col-md-12">
                                                        <?= $DESCRIPTION ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    </li>
                                    <li><a href="#">Additional information</a>
                                        <div class="category-toggle collapsed" data-bs-toggle="collapse"
                                             data-bs-target="#category02"><span class="add"><i
                                                        class="fa fa-angle-down"></i></span> <span class="remove"><i
                                                        class="fa fa-angle-up"></i></span></div>
                                        <div class="collapse" id="category02">
                                            <div class="product-anotherinfo-wrapper">
                                                <div class="row w-100">
                                                    <div class="col-md-12">
                                                        <ul>
                                                            <li><span> Product Type</span> <?= $NAMECTGR ?> </li>
                                                            <li><span>Brand</span><?= $NAMEBR ?> </li>
                                                            <li><span>Product Code</span> <?= $IDPR ?> </li>
                                                            <li><span>Sales Package</span> 1</li>
                                                            <li><span>Combo</span> Single</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li><a href="./COMPARE.php?IDPR=<?= $IDPR ?>">Compare</a>
                                    <li><a href="./downloadpro.php?IDPR=<?= $IDPR ?>">Download File</a>
                                    <li><a href="#">Shipping and Return Policy</a>
                                        <div class="category-toggle collapsed" data-bs-toggle="collapse"
                                             data-bs-target="#category04"><span class="add"><i
                                                        class="fa fa-angle-down"></i></span> <span class="remove"><i
                                                        class="fa fa-angle-up"></i></span></div>
                                        <div class="collapse" id="category04">
                                            <div class="replacement">
                                                <p>If there is any issues with your product, you can raise a refund or
                                                    replacement request within 10 days of receiving the product.</p>
                                                <p> Successful pick-up of the product is subject to the following
                                                    conditions being met: </p>
                                                <ul>
                                                    <li>Correct and complete product (with the original brand, article
                                                        number, undetached MRP tag, product's original packaging,
                                                        freebies and accessories)
                                                    </li>
                                                    <li>The product should be in unused, undamaged and original
                                                        condition without any stains, scratches, tears or holes
                                                    </li>
                                                </ul>
                                                <p>Know more about the Return Policy <a href="#">here</a></p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Widget Item End -->

                        <div class="shipping-delivery">

                            <!-- Free Shipping Start  -->
                            <div class="shipping">
                                <div class="icone"><i class="flaticon-shield"></i></div>
                                <div class="free_shipping_info">
                                    <h5>100% Original
                                        Products</h5>
                                </div>
                            </div>
                            <!-- Free Shipping End -->

                            <!-- Easy Returns Start  -->
                            <div class="shipping">
                                <div class="icone"><i class="flaticon-delivery-truck"></i></div>
                                <div class="free_shipping_info">
                                    <h5>Free Delivery on
                                        above $149</h5>
                                </div>
                            </div>
                            <!-- Easy Returns End -->

                            <!-- Fast Support Start  -->
                            <div class="shipping">
                                <div class="icone"><i class="flaticon-return-of-investment"></i></div>
                                <div class="free_shipping_info">
                                    <h5>Easy Return
                                        upto 14 days </h5>
                                </div>
                            </div>
                            <!-- Fast Support End -->

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<section class="new_arrivals section-padding-03">
    <div class="container">
        <!-- Section Title Start -->
        <div class="section-title text-center">
            <h4 class="title text_darkt">Related Products</h4>
            <span class="title-subtitle text_light"><strong>Love of beauty is taste. The creation of beauty is art</strong></span>
        </div>
        <!-- Section Title End -->

        <!-- product Start -->
        <div class="row">
            <div class="col-md-12">
                <!-- product carousel Start -->
                <ul class="thumbnails owl-carousel owl-theme owl-loaded owl-drag list-unstyled" id="new_arrivals">
                    <?php
                    $query4 = "select * from PRODUCT where IDPR=?";
                    $param4 = [$IDPR];
                    $stmt4 = $dao->DMLParam($query4, $param4);
                    $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
                    $IDCTGR = $row4['IDCTGR'];
                    $query5 = "select * from PRODUCT where IDCTGR=? and IDPR!=?
                    and STATUSPRO = 1 order by CREATEDATE DESC  ";
                    $param5 = [$IDCTGR, $IDPR];
                    $stmt5 = $dao->DMLParam($query5, $param5);
                    while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)):
                        $IDPR = $row5['IDPR'];
                        $NAMEPR = $row5['NAMEPR'];
                        $PRICE = $row5['PRICE'];
                        $BRIEFSUM = $row5['BRIEFSUM'];
                        $query1 = "select  * from IMAGES where (IDPR=? and DETAILQUANTITY >0)";
                        $param1 = [$IDPR];
                        $stmt1 = $dao->DMLParam($query1, $param1);
                        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                        $NAMEIM = $row1['NAMEIM'];
                        ?>
                        <li>
                            <div class="product-grid-item">
                                <div class="product-element-top"><a href="./PRO_DETAILS.php?IDPR=<?= $IDPR ?>"> <img
                                                class="thumbnail" src="../IMAGES/IMG_PRO/<?= $NAMEIM ?>"
                                                alt="<?= $NAMEPR ?>"> </a></div>
                                <div class="product-content">
                                    <div class="product-category-action">
                                        <div class="product-title"><a
                                                    href="./PRO_DETAILS.php?IDPR=<?= $IDPR ?>"><?= $NAMEPR ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-category-action">
                                        <?= $BRIEFSUM ?>
                                    </div>
                                    <div class="wrap-price">
                                        <div class="wrapp-swap">
                                            <div class="swap-elements">
                                                <div class="price">
                                                    <div class="product-price">
                                                        <div class="sale-price">VND <?= $PRICE ?></div>
                                                    </div>
                                                </div>
                                                <div class="btn-add header-action-btn-cart"><a
                                                            href="CART.php?IDPR=<?= $IDPR ?>&action=add"
                                                            class="add_to_cart_button">
                                                        <i class="fa fa-shopping-cart"></i> Add to cart</a></div>

                                            </div>
                                        </div>
                                        <div class="swatches-on-grid">
                                            <div class="widget-color">
                                                <ul class="color-list ps-0">
                                                    <?php
                                                    $query2 = "select  COLOR from IMAGES where (IDPR=? and DETAILQUANTITY >0)";
                                                    $param2 = [$IDPR];
                                                    $stmt2 = $dao->DMLParam($query2, $param2);
                                                    while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)):
                                                        $COLOR = $row2['COLOR'];
                                                        ?>
                                                        <li data-color="<?= $COLOR ?>"></li>
                                                    <?php
                                                    endwhile;
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php
                    endwhile;
                    ?>
                </ul>
                <!-- product carousel End -->
            </div>
            <div class="col-md-12">
                <!-- View All Products Start -->
                <div class="text-center"><a href="./NEW.php" class="load-more primary_dark_btn">View All Products</a>
                </div>
                <!-- View All Products End -->
            </div>
        </div>
        <!-- product End -->
    </div>
</section>
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
<script src="../CSS/vendors/lightGallery/js/lightgallery.min.js"></script>
<script src="../CSS/vendors/lightGallery/js/lg-thumbnail.min.js"></script>
<script src="../CSS/vendors/lightGallery/js/lg-fullscreen.min.js"></script>
<script src="../CSS/vendors/slick/slick.min.js"></script>
<script>
    /*----------------------------------------*/
    /*  Lightgallery Active
    /*----------------------------------------*/

    $(".popup-gallery").lightGallery({
        pager: false, // Enable/Disable pager
        thumbnail: false, // Enable thumbnails for the gallery
        fullScreen: true, // Enable/Disable fullscreen mode
        zoom: true, // Enable/Disable zoom option
        rotateLeft: true, // Enable/Disable Rotate Left
        rotateRight: true, // Enable/Disable Rotate Right
    });

    $(".zoom").on("click", function (e) {
        $(".popup-gallery .slick-active").trigger("click");
    });
</script>
<script src="../JS/custom.js"></script>
<script>
    $('.slider-five').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        navText: [
            "<i class='flaticon-next'></i>",
            "<i class='flaticon-back'></i>"
        ],
        asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.slider-five',
        dots: true,
        centerMode: true,
        focusOnSelect: true,
        arrows: true,
    });
</script>
<script>
    function checkcolor() {


        return true;
    }
</script>
</body>
</html>


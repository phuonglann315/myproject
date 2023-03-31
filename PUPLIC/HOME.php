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
<html>
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
<div class="slider slider-one">
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <ol class="carousel-indicators">
            <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"></li>
            <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></li>

        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active"><img src="../IMAGES/IMG_WEB/slider-1.jpeg" class="d-block w-100"
                                                   alt="MAKEUP">
                <div class="carousel-caption text-start color-scheme-dark">
                    <div class="container">
                        <h3>WAKE UP<br>
                            and <br>
                            <span>MAKE UP</span></h3>
                        <a href="SHOWPRO.php" class="slider-btn primary_dark_btn">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item"><img src="../IMAGES/IMG_WEB/slider-5.jpg" class="d-block w-100" alt="SKINCARE">
                <div class="carousel-caption text-start color-scheme-dark">
                    <div class="container">
                        <h3>Be yourself more<br>
                            do care more </h3>
                        <a href="SKINCARE.php" class="slider-btn primary_dark_btn">Shop Now</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Slider End -->

<!-- Our Highlights Start -->
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
<!-- Our Highlights End -->

<section class="new_arrivals section-padding-03">
    <div class="container">
        <!-- Section Title Start -->
        <div class="section-title text-center">
            <h4 class="title text_darkt">New Arrivals</h4>
            <span class="title-subtitle text_light"><strong>Love of beauty is taste. The creation of beauty is art</strong></span> </div>
        <!-- Section Title End -->

        <!-- product Start -->
        <div class="row">
            <div class="col-md-12">
                <!-- product carousel Start -->
                <ul class="thumbnails owl-carousel owl-theme owl-loaded owl-drag list-unstyled" id="new_arrivals">
                    <?PHP
                    $query = "select *
                    from (select IDPR,NAMEPR,PRICE,BRIEFSUM,CREATEDATE, STATUSPRO,
					        CASE when DATEDIFF(month ,CREATEDATE,getdate()) <=1 then 'NEW'
                                     end AS stt
                                    from PRODUCT 
                                    where QUANTITY>0 and STATUSPRO = 1 ) t
                    where stt is not null order by IDPR DESC  ";
                    $stmt = $dao->DML($query);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                        $IDPR = $row['IDPR'];
                        $NAMEPR = $row['NAMEPR'];
                        $PRICE = $row['PRICE'];
                        $BRIEFSUM = $row['BRIEFSUM'];
                        $query1 = "select  * from IMAGES where (IDPR=? and DETAILQUANTITY >0)";
                        $param1 = [$IDPR];
                        $stmt1 = $dao->DMLParam($query1, $param1);
                        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                        $NAMEIM = $row1['NAMEIM'];
                        ?>
                        <li>
                            <div class="product-grid-item">
                                <div class="product-element-top"> <a href="./PRO_DETAILS.php?IDPR=<?=$IDPR?>"> <img  class="thumbnail" src="../IMAGES/IMG_PRO/<?=$NAMEIM?>" alt="<?=$NAMEPR?>"> </a> <span class="new product-label">New</span> </div>
                                <div class="product-content">
                                    <div class="product-category-action">
                                        <div class="product-title"><a href="./PRO_DETAILS.php?IDPR=<?=$IDPR?>"><?=$NAMEPR?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-category-action">
                                        <?=$BRIEFSUM?>
                                    </div>
                                    <div class="wrap-price">
                                        <div class="wrapp-swap">
                                            <div class="swap-elements">
                                                <div class="price">
                                                    <div class="product-price">
                                                        <div class="sale-price">VND <?=$PRICE?></div>
                                                    </div>
                                                </div>
                                                <div class="btn-add header-action-btn-cart"> <a href="CART.php?IDPR=<?=$IDPR?>" class="add_to_cart_button"> <i class="fa fa-shopping-cart"></i> Add to cart</a> </div>

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
                                                        <li data-color="<?=$COLOR?>"></li>
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
                <div class="text-center"> <a href="./NEW.php" class="load-more primary_dark_btn">View All Products</a> </div>
                <!-- View All Products End -->
            </div>
        </div>
        <!-- product End -->
    </div>
</section>
<section class="winter-sale " >
    <div class="container">
        <div class="row" style="margin-top: 20px">
            <div class="col-sx-12 col-sm-12 col-md-12 col-lg-6 " style="text-align: center">
                <h4 class="title text_dark no_after">100 Years of Movie Makeup</h4>
            </div>
            <div class="col-sx-12 col-sm-12 col-md-12 col-lg-6" style="margin-top: 2px" > <video autoplay muted loop  id="myVideo">
                    <source src="../IMAGES/IMG_WEB/try.mp4">
                </video> </div>
        </div>
    </div>
</section>
<section class="trending_products section-padding-03 trending_products-one all_tab">
    <div class="container">
        <!-- Section Title Start -->
        <div class="section-title text-center">
            <h4 class="title text_dark">YOUR BRAND</h4>
            <!-- Section Title End -->
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs justify-content-center text-uppercase" id="myTab" role="tablist">
                        <?PHP
                        $query = "select * from BRAND where IDBR='BR1'";
                        $stmt = $dao->DML($query);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        $IDBR = $row['IDBR'];
                        $NAMEBR = $row['NAMEBR'];
                        ?>
                        <li class="nav-item" role="presentation"> <a class="nav-link active text_light" id="<?=$NAMEBR?>"
                                                                     data-bs-toggle="tab" href="#BR1" role="tab" aria-selected="true"><?=$NAMEBR?></a> </li>
                        <?PHP
                        $query4 = "select * from BRAND where IDBR!=?";
                        $param4=[$IDBR];
                        $stmt4 = $dao->DMLParam($query4,$param4);
                        while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)):
                            $IDBR4 = $row4['IDBR'];
                            $NAMEBR4 = $row4['NAMEBR'];
                            ?>
                            <li class="nav-item" role="presentation"> <a class="nav-link text_light" id="<?=$NAMEBR4?>" data-bs-toggle="tab" href="#<?=$IDBR4?>" role="tab"  aria-selected="false"><?=$NAMEBR4?></a> </li>
                        <?php
                        endwhile;
                        ?>
                    </ul>
                </div>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="BR1" role="tabpanel"
                         aria-labelledby="<?=$NAMEBR?>">
                        <div class="row">
                            <?php
                            $query = "select TOP 4 * from PRODUCT where (IDBR='BR1' and QUANTITY>0 and STATUSPRO = 1) order by IDPR DESC ";

                            $stmt = $dao->DML($query);
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                $IDPR = $row['IDPR'];
                                $NAMEPR = $row['NAMEPR'];
                                $PRICE = $row['PRICE'];
                                $BRIEFSUM = $row['BRIEFSUM'];
                                $query1 = "select  * from IMAGES where (IDPR=? and DETAILQUANTITY >0)";
                                $param1 = [$IDPR];
                                $stmt1 = $dao->DMLParam($query1, $param1);
                                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                                $NAMEIM = $row1['NAMEIM'];
                                ?>

                                <div class="col-sx-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="product-grid-item">
                                        <div class="product-element-top"> <a href="./PRO_DETAILS.php?IDPR=<?=$IDPR?>"> <img  class="thumbnail" src="../IMAGES/IMG_PRO/<?=$NAMEIM?>" alt="<?=$NAMEPR?>"> </a> </div>

                                        <div class="product-content">
                                            <div class="product-category-action">
                                                <div class="product-title">  <a href="./PRO_DETAILS.php?IDPR=<?=$IDPR?>"><?=$NAMEPR?></a> </div>
                                            </div>
                                            <div class="product-category-action">
                                                <?=$BRIEFSUM?>
                                            </div>
                                            <div class="wrap-price">
                                                <div class="wrapp-swap">
                                                    <div class="swap-elements">

                                                        <div class="price">
                                                            <div class="product-price">
                                                                <div class="sale-price">VND <?=$PRICE?></div>
                                                            </div>
                                                        </div>
                                                        <div class="btn-add header-action-btn-cart"> <a href="CART.php?IDPR=<?=$IDPR?>"
                                                                                                        class="add_to_cart_button"> <i class="fa fa-shopping-cart"></i> Add to cart</a> </div>
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
                                                                <li data-color="<?=$COLOR?>"></li>
                                                            <?php
                                                            endwhile;
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            endwhile;
                            ?>
                        </div>

                        <div class="col-md-12 xuan">
                            <!-- View All Products Start -->
                            <div class="text-center"> <a href="./SHOWPRO.php?IDBR=BR1" class="load-more primary_dark_btn">View All Products</a> </div>
                            <!-- View All Products End -->
                        </div>
                    </div>
                    <?PHP
                    $query4 = "select * from BRAND where IDBR!=?";
                    $param4=[$IDBR];
                    $stmt4 = $dao->DMLParam($query4,$param4);
                    while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)):
                        $IDBR4 = $row4['IDBR'];
                        $NAMEBR4 = $row4['NAMEBR'];
                        ?>
                        <div class="tab-pane fade" id="<?=$IDBR4?>" role="tabpanel" aria-labelledby="<?=$NAMEBR4?>">
                            <div class="row">
                                <?php
                                $query5 = "select TOP 4 * from PRODUCT where (IDBR=? and QUANTITY>0 and STATUSPRO = 1 ) order by IDPR DESC";
                                $param5=[$IDBR4];
                                $stmt5 = $dao->DMLParam($query5,$param5);
                                while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)):
                                    $IDPR1 = $row5['IDPR'];
                                    $NAMEPR1 = $row5['NAMEPR'];
                                    $PRICE1 = $row5['PRICE'];
                                    $BRIEFSUM1 = $row5['BRIEFSUM'];
                                    $query6 = "select  * from IMAGES where (IDPR=? and DETAILQUANTITY >0)";
                                    $param6 = [$IDPR1];
                                    $stmt6 = $dao->DMLParam($query6, $param6);
                                    $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);
                                    $NAMEIM1 = $row6['NAMEIM'];
                                    ?>
                                    <div class="col-sx-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="product-grid-item">
                                            <div class="product-element-top"> <a href="./PRO_DETAILS.php?IDPR=<?=$IDPR1?>"> <img  class="thumbnail" src="../IMAGES/IMG_PRO/<?=$NAMEIM1?>" alt="<?=$NAMEPR1?>"> </a> </div>

                                            <div class="product-content">
                                                <div class="product-category-action">
                                                    <div class="product-title">  <a href="./PRO_DETAILS.php?IDPR=<?=$IDPR1?>"><?=$NAMEPR1?></a> </div>
                                                </div>
                                                <div class="product-category-action">
                                                    <?=$BRIEFSUM1?>
                                                </div>
                                                <div class="wrap-price">
                                                    <div class="wrapp-swap">
                                                        <div class="swap-elements">
                                                            <div class="price">
                                                                <div class="product-price">
                                                                    <div class="sale-price">VND <?=$PRICE1?></div>
                                                                </div>
                                                            </div>

                                                            <div class="btn-add header-action-btn-cart"> <a href="CART.php?IDPR=<?=$IDPR1?>"
                                                                                                            class="add_to_cart_button"> <i class="fa fa-shopping-cart"></i> Add to cart</a> </div>
                                                        </div>
                                                    </div>
                                                    <div class="swatches-on-grid">
                                                        <div class="widget-color">
                                                            <ul class="color-list ps-0">
                                                                <?php
                                                                $query2 = "select  COLOR from IMAGES where (IDPR=? and DETAILQUANTITY >0)";
                                                                $param2 = [$IDPR1];
                                                                $stmt2 = $dao->DMLParam($query2, $param2);
                                                                while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)):
                                                                    $COLOR = $row2['COLOR'];
                                                                    ?>
                                                                    <li data-color="<?=$COLOR?>"></li>
                                                                <?php
                                                                endwhile;
                                                                ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                                endwhile;
                                ?>
                            </div>
                            <div class="col-md-12 xuan">
                                <!-- View All Products Start -->
                                <div class="text-center"> <a href="./SHOWPRO.php?IDBR=<?=$IDBR4?>" class="load-more primary_dark_btn">View All Products</a> </div>
                                <!-- View All Products End -->
                            </div>
                        </div>
                    <?php
                    endwhile;
                    ?>

                </div>

            </div>
        </div>
</section>
<section class="winter-sale color-scheme-white">
    <div class="container">
        <div class="row">
            <div class="col-sx-12 col-sm-6 col-md-6 col-lg-6 align-self-center">
                <h4 class="title text_dark no_after">love rised me, lipstick saves me</h4>
                <span class="title-subtitle text_light"> A secret makes a woman woman</span> <a href="SHOWPRO.php?IDCTGR=CT1" class="primary_dark_btn primary_bg_sky_hover">Shop Now</a> </div>
            <div class="col-sx-12 col-sm-6 col-md-6 col-lg-6"> <img class="winter_sale" src="../IMAGES/IMG_WEB/winter.png" alt=""> </div>
        </div>
    </div>
</section>
<section class="new_arrivals section-padding-05">
    <div class="container">
        <!-- Section Title Start -->
        <div class="section-title text-center">
            <h4 class="title text_dark">SPECIALPRICE</h4>
            <span class="title-subtitle text_light">Love of beauty is taste. The creation of beauty is art</span> </div>
        <!-- Section Title End -->

        <!-- product Start -->
        <div class="row">
            <div class="col-md-12">

                <!-- product carousel Start -->

                <ul class="thumbnails owl-carousel owl-theme owl-loaded owl-drag list-unstyled" id="best_selling">
                    <?PHP
                    $query = "select *
                    from (select IDPR,NAMEPR,PRICE,BRIEFSUM,CREATEDATE,QUANTITY, STATUSPRO ,
							[DISCOUNT]=  CASE when DATEDIFF(MONTH,CREATEDATE,getdate())=3 then '20%'
							when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then '25%'
							when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then '30%'
							
                             end ,
					      [NEWPRICE]=  CASE when DATEDIFF(MONTH,CREATEDATE,getdate()) =3 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.2) AS decimal(7,0))
					      when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.25) AS decimal(7,0))
					      when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.3) AS decimal(7,0))
					      
                             end 
                             from PRODUCT 
                             where QUANTITY>0 and STATUSPRO = 1) t
                    where t.DISCOUNT is not null order by IDPR DESC ";
                    $stmt = $dao->DML($query);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                        $IDPR = $row['IDPR'];
                        $NAMEPR = $row['NAMEPR'];
                        $PRICE = $row['PRICE'];
                        $BRIEFSUM = $row['BRIEFSUM'];
                        $DISCOUNT=$row['DISCOUNT'];
                        $NEWPRICE=$row['NEWPRICE'];
                        $query1 = "select  * from IMAGES where (IDPR=? and DETAILQUANTITY >0)";
                        $param1 = [$IDPR];
                        $stmt1 = $dao->DMLParam($query1, $param1);
                        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                        $NAMEIM = $row1['NAMEIM'];
                        ?>
                        <li>
                            <div class="product-grid-item">
                                <div class="product-element-top"> <a href="./PRO_DETAILS.php?IDPR=<?=$IDPR?>"> <img  class="thumbnail" src="../IMAGES/IMG_PRO/<?=$NAMEIM?>" alt="<?=$NAMEPR?>"> </a><span class="off product-label"><?=$DISCOUNT?> off</span></div>

                                    <div class="product-content">
                                        <div class="product-category-action">
                                            <div class="product-title"><a href="./PRO_DETAILS.php?IDPR=<?=$IDPR?>"><?=$NAMEPR?></a> </div>

                                        </div>
                                        <div class="product-category-action">
                                            <?=$BRIEFSUM?>
                                        </div>
                                        <div class="wrap-price">
                                            <div class="wrapp-swap">
                                                <div class="swap-elements">
                                                    <div class="price">
                                                        <div class="product-price">
                                                            <div class="sale-price"><strong style="color: #d34b56">NEW PRICE:&nbsp; VND &nbsp; <?=$NEWPRICE?></strong> </div>
                                                        </div>
                                                    </div>
                                                    <div class="btn-add header-action-btn-cart"> <a href="CART.php?IDPR=<?=$IDPR?>" class="add_to_cart_button"> <i class="fa fa-shopping-cart"></i> Add to cart</a> </div>
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
                                                            <li data-color="<?=$COLOR?>"></li>
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
                <div class="text-center"> <a href="./SPECIALPRICE.php" class="load-more primary_dark_btn">View All Products</a> </div>
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
<script src="../JS/custom.js"></script>
</body>
</html>
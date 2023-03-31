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

    <title>¨°o.O ROSIE STORE (¯`v´¯)O.o°¨</title>
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
<section class="trending_products section-padding-03 trending_products-one all_tab">
    <div class="container">
        <!-- Section Title Start -->
        <div class="section-title text-center">
            <h4 class="title text_dark">Be Your Own Kind Of Beautiful</h4>
            <!-- Section Title End -->
        </div>
        <?PHP
        // nếu có bất kỳ search nào được truyền qua đây
        if (isset($_GET['search'])) :
            $string = $_GET['search'];
            ?>
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs justify-content-center text-uppercase" id="myTab" role="tablist">
                        <?php

                        $query = "select * from BRAND where IDBR='BR1'";
                        $stmt = $dao->DML($query);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        $NAMEBR = $row['NAMEBR'];
                        $IDBR = $row['IDBR'];
                        ?>
                        <li class="nav-item" role="presentation"><a class="nav-link active text_light"
                                                                    id="<?= $NAMEBR ?>"
                                                                    data-bs-toggle="tab" href="#BR1" role="tab"
                                                                    aria-selected="true"><?= $NAMEBR ?></a></li>
                        <?PHP
                        $query4 = "select * from BRAND where IDBR!='BR1'";
                        $stmt4 = $dao->DML($query4);
                        while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)):
                            $IDBR4 = $row4['IDBR'];
                            $NAMEBR4 = $row4['NAMEBR'];
                            ?>
                            <li class="nav-item" role="presentation"><a class="nav-link text_light" id="<?= $NAMEBR4 ?>"
                                                                        data-bs-toggle="tab" href="#<?= $IDBR4 ?>"
                                                                        role="tab"
                                                                        aria-selected="false"><?= $NAMEBR4 ?></a></li>
                        <?php
                        endwhile;
                        ?>
                    </ul>
                </div>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="BR1" role="tabpanel"
                         aria-labelledby="<?= $NAMEBR ?>">
                        <div class="row">
                            <?php
                            $query6 = "select COUNT(IDPR) as total        
						from PRODUCT P			 
						INNER JOIN BRAND B ON P.IDBR = B.IDBR			  
                         INNER JOIN CATEGORY C ON P.IDCTGR = C.IDCTGR          
						  where concat(IDPR, NAMEPR, QUANTITY, NAMEBR, NAMECTGR) like ? collate SQL_Latin1_General_CP1_CI_AI  and P.IDBR='BR1' and QUANTITY>0 and STATUSPRO = 1 ";
                            $param6 = ["%{$string}%"];
                            $stmt6 = $dao->DMLParam($query6, $param6);
                            $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);
                            $total_records = $row6['total'];
                            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $limit = 12;// số item hiển thị trên 1 trang
                            $total_page = ceil($total_records / $limit);
                            if ($current_page > $total_page) {
                                $current_page = $total_page;
                            } else if ($current_page < 1) {
                                $current_page = 1;
                            }
                            $start = (($current_page - 1) * $limit + 1);
                            $end = ($start + $limit - 1);
                            if ($total_records == 0) {
                                ?>
                                <div class="col-md-12"><h5 style="color:#ffb6c1;text-align: center; ">We're sorry, there are no results for
                                        your search</h5></div>
                                <?php
                            } else {
                                $query1 = "select *
                                from (select *, ROW_NUMBER() OVER (ORDER BY IDPR DESC) as rownum
                                       from (select *
                    from (select IDPR,NAMEPR,PRICE,BRIEFSUM,CREATEDATE,QUANTITY, STATUSPRO ,NAMEBR,NAMECTGR,PRODUCT.IDBR,
							[STT]=  CASE 
							when DATEDIFF(MONTH,CREATEDATE,getdate())<=1 then 'NEW'
							when (DATEDIFF(MONTH,CREATEDATE,getdate())>1 and DATEDIFF(MONTH,CREATEDATE,getdate())<3 )then 'nomarl'
							when DATEDIFF(MONTH,CREATEDATE,getdate())=3 then '20%'
							when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then '25%'
							when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then '30%'
							
                             end ,
					      [NEWPRICE]=  CASE 
						  when DATEDIFF(MONTH,CREATEDATE,getdate())<=1 then PRODUCT.PRICE
						  when (DATEDIFF(MONTH,CREATEDATE,getdate())>1 and DATEDIFF(MONTH,CREATEDATE,getdate())<3 )then PRODUCT.PRICE
						  when DATEDIFF(MONTH,CREATEDATE,getdate()) =3 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.2) AS decimal(7,0))
					      when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.25) AS decimal(7,0))
					      when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.3) AS decimal(7,0))
					      
                             end 
                             from PRODUCT 
							 INNER JOIN BRAND B on B.IDBR=PRODUCT.IDBR
							 INNER JOIN CATEGORY C ON C.IDCTGR=PRODUCT.IDCTGR
                    where concat(IDPR, NAMEPR, QUANTITY, NAMEBR, NAMECTGR) like ? collate SQL_Latin1_General_CP1_CI_AI and PRODUCT.IDBR='BR1' and QUANTITY>0 and STATUSPRO = 1 ) as t)  as t1)as tem
                                where tem.rownum between $start and $end
                                 order by tem.rownum ASC ";
                                $param1 = ["%{$string}%"];
                                $stmt1 = $dao->DMLParam($query1, $param1);
                                while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)):
                                    $IDPR = $row1['IDPR'];
                                    $NAMEPR = $row1['NAMEPR'];
                                    $PRICE = $row1['NEWPRICE'];
                                    $BRIEFSUM = $row1['BRIEFSUM'];
                                    $STT = $row1['STT'];
                                    $query = "select  * from IMAGES where (IDPR=? and DETAILQUANTITY >0)";
                                    $param = [$IDPR];
                                    $stmt = $dao->DMLParam($query, $param);
                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $NAMEIM = $row['NAMEIM'];
                                    ?>
                                    <div class="col-sx-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="product-grid-item">
                                            <div class="product-element-top"><a
                                                        href="./PRO_DETAILS.php?IDPR=<?= $IDPR ?>">
                                                    <img class="thumbnail" src="../IMAGES/IMG_PRO/<?= $NAMEIM ?>"
                                                         alt="<?= $NAMEPR ?>"> </a>
                                                <?php
                                                if ($STT == 'NEW') {

                                                    ?>
                                                    <span class="new product-label">New</span>
                                                    <?php
                                                }
                                                if ($STT == 'nomarl') {
                                                    ?>
                                                    <span style="background-color: transparent"></span>
                                                    <?php
                                                }
                                                if (!($STT == 'nomarl') && !($STT == 'NEW')) {
                                                    ?>
                                                    <span class="off product-label"><?= $STT ?> off</span>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="ayira-buttons">
                                                <div class="quick-view">
                                                    <a href="#" class="open-quick-view" data-bs-toggle="modal"
                                                       data-bs-target="#quick_view"><i
                                                                class="flaticon-search-2"></i></a>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-category-action">
                                                    <div class="product-title"><a
                                                                href="./PRO_DETAILS.php?IDPR=<?= $IDPR ?>"><?= $NAMEPR ?></a>
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
                                                                        href="CART.php?IDPR=<?= $IDPR ?>"
                                                                        class="add_to_cart_button"> <i
                                                                            class="fa fa-shopping-cart"></i> Add to cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="swatches-on-grid">
                                                        <div class="widget-color">
                                                            <ul class="color-list ps-0">
                                                                <?php
                                                                $query2 = "select  COLOR from IMAGES where (IDPR=? and DETAILQUANTITY >0 )";
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
                                    </div>

                                <?php
                                endwhile;
                            }
                            ?>
                            <div class="pagination">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php
                                        if (($current_page > 1) && ($total_page > 1)) {
                                            echo '<li class="page-item"><a STYLE="background-color:#ffb6c1;border-color: #ffb6c1 "class="page-link" href="SHOWPRO.php?IDBR=BR1&search=' . $string . '&page=' . ($current_page - 1) . '">Prev</a></li> ';
                                        }
                                        // Lặp khoảng giữa
                                        for ($i = 1; $i <= $total_page; $i++) {
                                            // Nếu là trang hiện tại thì hiển thị thẻ span
                                            // ngược lại hiển thị thẻ a
                                            if ($i == $current_page) {
                                                echo '<li class="page-item active">
                                                  <span class="page-link" STYLE="background-color:#ffb6c1;border-color: #ffb6c1 ">' . $i . '<span class="sr-only">(current)</span>
                                                  </span>
                                                </li>';
                                            } else {
                                                echo ' <li class="page-item " aria-current="page"><a class="page-link"<a STYLE="background-color:#ffb6c1;border-color: #ffb6c1 " href="SHOWPRO.php?IDBR=BR1&search=' . $string . '&page=' . $i . '">' . $i . '</a></li> ';
                                            }
                                        }

                                        // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
                                        if ($current_page < $total_page && $total_page > 1) {
                                            echo '<li class="page-item"><a class="page-link"<a STYLE="background-color:#ffb6c1;border-color: #ffb6c1 " href="SHOWPRO.php?IDBR=BR1&search=' . $string . '&page=' . ($current_page + 1) . '">Next</a> </li> ';
                                        }
                                        ?>
                                    </ul>
                                </nav>
                            </div>


                        </div>
                    </div>
                    <?PHP
                    $query4 = "select * from BRAND where (IDBR!='BR1')";
                    $stmt4 = $dao->DML($query4);
                    while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)):
                        $IDBR4 = $row4['IDBR'];
                        $NAMEBR4 = $row4['NAMEBR'];
                        ?>
                        <div class="tab-pane fade" id="<?= $IDBR4 ?>" role="tabpanel" aria-labelledby="<?= $NAMEBR4 ?>">
                        <div class="row">
                            <?php
                            $query5 = "select COUNT(IDPR) as total        
						from PRODUCT P			 
						INNER JOIN BRAND B ON P.IDBR = B.IDBR			  
                         INNER JOIN CATEGORY C ON P.IDCTGR = C.IDCTGR          
						  where concat(IDPR, NAMEPR, QUANTITY, NAMEBR, NAMECTGR) like ? collate SQL_Latin1_General_CP1_CI_AI  and P.IDBR=? and QUANTITY>0 and STATUSPRO = 1";
                            $param5 = ["%{$string}%", $IDBR4];
                            $stmt5 = $dao->DMLParam($query5, $param5);
                            $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
                            $total_records = $row5['total'];
                            $current_page = 1;
                            $limit = 12;
                            $total_page = ceil($total_records / $limit);
                            if ($current_page > $total_page) {
                                $current_page = $total_page;
                            } else if ($current_page < 1) {
                                $current_page = 1;
                            }
                            $start = (($current_page - 1) * $limit + 1);
                            $end = ($start + $limit - 1);
                            if ($total_records == 0) {
                                ?>
                                <div class="col-md-12"><h5 style="color:#ffb6c1;text-align: center; ">We're sorry, there are no results for
                                        your search</h5></div>
                                <?php
                            } else {
                                $query1 = "select *
                                from (select *, ROW_NUMBER() OVER (ORDER BY IDPR DESC) as rownum
                                       from (select *
                    from (select IDPR,NAMEPR,PRICE,BRIEFSUM,CREATEDATE,QUANTITY, STATUSPRO ,NAMEBR,NAMECTGR,PRODUCT.IDBR,
							[STT]=  CASE 
							when DATEDIFF(MONTH,CREATEDATE,getdate())<=1 then 'NEW'
							when (DATEDIFF(MONTH,CREATEDATE,getdate())>1 and DATEDIFF(MONTH,CREATEDATE,getdate())<3 )then 'nomarl'
							when DATEDIFF(MONTH,CREATEDATE,getdate())=3 then '20%'
							when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then '25%'
							when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then '30%'
							
                             end ,
					      [NEWPRICE]=  CASE 
						  when DATEDIFF(MONTH,CREATEDATE,getdate())<=1 then PRODUCT.PRICE
						  when (DATEDIFF(MONTH,CREATEDATE,getdate())>1 and DATEDIFF(MONTH,CREATEDATE,getdate())<3 )then PRODUCT.PRICE
						  when DATEDIFF(MONTH,CREATEDATE,getdate()) =3 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.2) AS decimal(7,0))
					      when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.25) AS decimal(7,0))
					      when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.3) AS decimal(7,0))
					      
                             end 
                             from PRODUCT 
							 INNER JOIN BRAND B on B.IDBR=PRODUCT.IDBR
							 INNER JOIN CATEGORY C ON C.IDCTGR=PRODUCT.IDCTGR
                    where concat(IDPR, NAMEPR, QUANTITY, NAMEBR, NAMECTGR) like ? collate SQL_Latin1_General_CP1_CI_AI and PRODUCT.IDBR=? and QUANTITY>0 and STATUSPRO = 1 ) as t)  as t1)as tem
                                where tem.rownum between $start and $end
                                 order by tem.rownum ASC ";
                                $param1 = ["%{$string}%", $IDBR4];
                                $stmt1 = $dao->DMLParam($query1, $param1);
                                while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)):
                                    $IDPR = $row1['IDPR'];
                                    $NAMEPR = $row1['NAMEPR'];
                                    $PRICE = $row1['NEWPRICE'];
                                    $BRIEFSUM = $row1['BRIEFSUM'];
                                    $STT = $row1['STT'];
                                    $query = "select  * from IMAGES where (IDPR=? and DETAILQUANTITY >0)";
                                    $param = [$IDPR];
                                    $stmt = $dao->DMLParam($query, $param);
                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $NAMEIM = $row['NAMEIM'];
                                    ?>
                                    <div class="col-sx-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="product-grid-item">
                                            <div class="product-element-top"><a
                                                        href="./PRO_DETAILS.php?IDPR=<?= $IDPR ?>">
                                                    <img class="thumbnail" src="../IMAGES/IMG_PRO/<?= $NAMEIM ?>"
                                                         alt="<?= $NAMEPR ?>"> </a>
                                                <?php
                                                if ($STT == 'NEW') {

                                                    ?>
                                                    <span class="new product-label">New</span>
                                                    <?php
                                                }
                                                if ($STT == 'nomarl') {
                                                    ?>
                                                    <span style="background-color: transparent"></span>
                                                    <?php
                                                }
                                                if (!($STT == 'nomarl') && !($STT == 'NEW')) {
                                                    ?>
                                                    <span class="off product-label"><?= $STT ?> off</span>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="ayira-buttons">
                                                <div class="quick-view">
                                                    <a href="#" class="open-quick-view" data-bs-toggle="modal"
                                                       data-bs-target="#quick_view"><i
                                                                class="flaticon-search-2"></i></a>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-category-action">
                                                    <div class="product-title"><a
                                                                href="./PRO_DETAILS.php?IDPR=<?= $IDPR ?>"><?= $NAMEPR ?></a>
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
                                                                        href="CART.php?IDPR=<?= $IDPR ?>"
                                                                        class="add_to_cart_button"> <i
                                                                            class="fa fa-shopping-cart"></i> Add to cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="swatches-on-grid">
                                                        <div class="widget-color">
                                                            <ul class="color-list ps-0">
                                                                <?php
                                                                $query2 = "select  COLOR from IMAGES where (IDPR=? and DETAILQUANTITY >0 )";
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
                                    </div>

                                <?php
                                endwhile;
                            }
                            ?>
                            <div class="pagination">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php
                                        if (($current_page > 1) && ($total_page > 1)) {
                                            echo '<li class="page-item"><a STYLE="background-color:#ffb6c1;border-color: #ffb6c1 " class="page-link" href="SHOWPRO.php?IDBR=' . $IDBR4 . '&search=' . $string . '&page=' . ($current_page - 1) . '" STYLE="background-color:#ffb6c1;border-color: #ffb6c1 ">Prev</a></li> ';
                                        }

                                        // Lặp khoảng giữa
                                        for ($i = 1; $i <= $total_page; $i++) {
                                            // Nếu là trang hiện tại thì hiển thị thẻ span
                                            // ngược lại hiển thị thẻ a
                                            if ($i == $current_page) {
                                                echo '<li class="page-item active">
                                                  <span class="page-link" STYLE="background-color:#ffb6c1;border-color: #ffb6c1 ">' . $i . '<span class="sr-only">(current)</span>
                                                  </span>
                                                </li>';
                                            } else {
                                                echo ' <li class="page-item " aria-current="page"><a class="page-link"<a STYLE="background-color:#ffb6c1;border-color: #ffb6c1 " href="SHOWPRO.php?IDBR=' . $IDBR4 . '&search=' . $string . '&page=' . $i . '">' . $i . '</a></li> ';
                                            }
                                        }

                                        // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
                                        if ($current_page < $total_page && $total_page > 1) {
                                            echo '<li class="page-item"><a class="page-link"<a STYLE="background-color:#ffb6c1;border-color: #ffb6c1 " href="SHOWPRO.php?IDBR=' . $IDBR4 . '&search=' . $string . '&page=' . ($current_page + 1) . '">Next</a> </li> ';
                                        }

                                        ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>

                        </div>
                    <?php
                    endwhile;
                    ?>
                </div>

            </div>
        <?php
        endif;//endif search
        //NẾU CÓ IDBR TRUYỀN QUA
        if (isset($_GET['IDBR']) && empty($_GET['IDCTGR']) && empty($_GET['search'])) :
            ?>
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs justify-content-center text-uppercase" id="myTab" role="tablist">
                        <?php
                        //Nếu user ko search thif show ra tất cả theo IDBR được truyền qua
                        $query = "select * from BRAND where IDBR=?";
                        $param = [
                            $_GET['IDBR']
                        ];
                        $stmt = $dao->DMLParam($query, $param);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        $NAMEBR = $row['NAMEBR'];
                        $IDBR = $row['IDBR'];
                        ?>
                        <li class="nav-item" role="presentation"><a class="nav-link active text_light"
                                                                    id="<?= $NAMEBR ?>"
                                                                    data-bs-toggle="tab" href="#<?= $IDBR ?>" role="tab"
                                                                    aria-selected="true"><?= $NAMEBR ?></a></li>
                        <?PHP
                        $query4 = "select * from BRAND where IDBR!=?";
                        $param4 = [$_GET['IDBR']];
                        $stmt4 = $dao->DMLParam($query4, $param4);
                        while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)):
                            $IDBR4 = $row4['IDBR'];
                            $NAMEBR4 = $row4['NAMEBR'];
                            ?>
                            <li class="nav-item" role="presentation"><a class="nav-link text_light" id="<?= $NAMEBR4 ?>"
                                                                        data-bs-toggle="tab" href="#<?= $IDBR4 ?>"
                                                                        role="tab"
                                                                        aria-selected="false"><?= $NAMEBR4 ?></a></li>
                        <?php
                        endwhile;
                        ?>
                    </ul>
                </div>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="<?= $IDBR ?>" role="tabpanel"
                         aria-labelledby="<?= $NAMEBR ?>">

                        <div class="row">
                            <?php
                            $query = "select COUNT (IDPR) as total 
                                        from PRODUCT 
                                        where (IDBR=? and QUANTITY>0 and STATUSPRO = 1) ";

                            $param = [$_GET['IDBR']];
                            $stmt = $dao->DMLParam($query, $param);
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            $total_records = $row['total'];
                            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $limit = 12;// số item hiển thị trên 1 trang
                            $total_page = ceil($total_records / $limit);
                            if ($current_page > $total_page) {
                                $current_page = $total_page;
                            } else if ($current_page < 1) {
                                $current_page = 1;
                            }
                            $start = (($current_page - 1) * $limit + 1);
                            $end = ($start + $limit - 1);
                            $query = "select *
                                from (select *, ROW_NUMBER() OVER (ORDER BY IDPR DESC) as rownum
                                       from (select *
                    from (select IDPR,NAMEPR,PRICE,BRIEFSUM,CREATEDATE,QUANTITY, STATUSPRO ,NAMEBR,NAMECTGR,PRODUCT.IDBR,
							[STT]=  CASE 
							when DATEDIFF(MONTH,CREATEDATE,getdate())<=1 then 'NEW'
							when (DATEDIFF(MONTH,CREATEDATE,getdate())>1 and DATEDIFF(MONTH,CREATEDATE,getdate())<3 )then 'nomarl'
							when DATEDIFF(MONTH,CREATEDATE,getdate())=3 then '20%'
							when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then '25%'
							when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then '30%'
							
                             end ,
					      [NEWPRICE]=  CASE 
						  when DATEDIFF(MONTH,CREATEDATE,getdate())<=1 then PRODUCT.PRICE
						  when (DATEDIFF(MONTH,CREATEDATE,getdate())>1 and DATEDIFF(MONTH,CREATEDATE,getdate())<3 )then PRODUCT.PRICE
						  when DATEDIFF(MONTH,CREATEDATE,getdate()) =3 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.2) AS decimal(7,0))
					      when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.25) AS decimal(7,0))
					      when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.3) AS decimal(7,0))
					      
                             end 
                             from PRODUCT 
							 INNER JOIN BRAND B on B.IDBR=PRODUCT.IDBR
							 INNER JOIN CATEGORY C ON C.IDCTGR=PRODUCT.IDCTGR
                    where PRODUCT.IDBR=? and QUANTITY>0 and STATUSPRO = 1 ) as t)  as t1)as tem
                                where tem.rownum between $start and $end
                                 order by tem.rownum ASC ";
                            $param = [$_GET['IDBR']];
                            $stmt = $dao->DMLParam($query, $param);
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                $IDPR = $row['IDPR'];
                                $NAMEPR = $row['NAMEPR'];
                                $PRICE = $row['NEWPRICE'];
                                $BRIEFSUM = $row['BRIEFSUM'];
                                $STT = $row['STT'];
                                $query1 = "select  * from IMAGES where (IDPR=? and DETAILQUANTITY >0)";
                                $param1 = [$IDPR];
                                $stmt1 = $dao->DMLParam($query1, $param1);
                                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                                $NAMEIM = $row1['NAMEIM'];
                                ?>
                                <div class="col-sx-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="product-grid-item">
                                        <div class="product-element-top"><a href="./PRO_DETAILS.php?IDPR=<?= $IDPR ?>">
                                                <img class="thumbnail" src="../IMAGES/IMG_PRO/<?= $NAMEIM ?>"
                                                     alt="<?= $NAMEPR ?>"> </a>
                                            <?php
                                            if ($STT == 'NEW') {

                                                ?>
                                                <span class="new product-label">New</span>
                                                <?php
                                            }
                                            if ($STT == 'nomarl') {
                                                ?>
                                                <span style="background-color: transparent"></span>
                                                <?php
                                            }
                                            if (!($STT == 'nomarl') && !($STT == 'NEW')) {
                                                ?>
                                                <span class="off product-label"><?= $STT ?> off</span>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="ayira-buttons">
                                            <div class="quick-view">
                                                <a href="#" class="open-quick-view" data-bs-toggle="modal"
                                                   data-bs-target="#quick_view"><i
                                                            class="flaticon-search-2"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <div class="product-category-action">
                                                <div class="product-title"><a
                                                            href="./PRO_DETAILS.php?IDPR=<?= $IDPR ?>"><?= $NAMEPR ?></a>
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
                                                                    href="CART.php?IDPR=<?= $IDPR ?>"
                                                                    class="add_to_cart_button"> <i
                                                                        class="fa fa-shopping-cart"></i> Add to cart</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swatches-on-grid">
                                                    <div class="widget-color">
                                                        <ul class="color-list ps-0">
                                                            <?php
                                                            $query2 = "select  COLOR from IMAGES where (IDPR=? and DETAILQUANTITY >0 )";
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
                                </div>

                            <?php
                            endwhile;
                            ?>
                            <div class="pagination">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php
                                        if (($current_page > 1) && ($total_page > 1)) {
                                            echo '<li class="page-item"><a STYLE="background-color:#ffb6c1;border-color: #ffb6c1 " class="page-link" href="SHOWPRO.php?IDBR=' . $IDBR . '&page=' . ($current_page - 1) . '">Prev</a></li> ';
                                        }
                                        // Lặp khoảng giữa
                                        for ($i = 1; $i <= $total_page; $i++) {
                                            // Nếu là trang hiện tại thì hiển thị thẻ span
                                            // ngược lại hiển thị thẻ a
                                            if ($i == $current_page) {
                                                echo '<li class="page-item active">
                                                  <span class="page-link" STYLE="background-color:#ffb6c1;border-color: #ffb6c1 ">' . $i . '<span class="sr-only">(current)</span>
                                                  </span>
                                                </li>';
                                            } else {
                                                echo ' <li class="page-item " aria-current="page"><a class="page-link"<a STYLE="background-color:#ffb6c1;border-color: #ffb6c1 "href="SHOWPRO.php?IDBR=' . $IDBR . '&page=' . $i . '">' . $i . '</a></li> ';
                                            }
                                        }

                                        // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
                                        if ($current_page < $total_page && $total_page > 1) {
                                            echo '<li class="page-item"><a class="page-link"<a STYLE="background-color:#ffb6c1;border-color: #ffb6c1 " href="SHOWPRO.php?IDBR=' . $IDBR . '&page=' . ($current_page + 1) . '">Next</a> </li> ';
                                        }
                                        ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <?PHP
                    $query4 = "select * from BRAND where (IDBR!=?)";
                    $param4 = [$_GET['IDBR']];
                    $stmt4 = $dao->DMLParam($query4, $param4);
                    while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)):
                        $IDBR4 = $row4['IDBR'];
                        $NAMEBR4 = $row4['NAMEBR'];
                        ?>
                        <div class="tab-pane fade" id="<?= $IDBR4 ?>" role="tabpanel" aria-labelledby="<?= $NAMEBR4 ?>">
                            <div class="row">
                                <?php
                                $query5 = "select  COUNT (IDPR) as total
                                from PRODUCT where (IDBR=? and QUANTITY>0 and STATUSPRO = 1)";
                                $param5 = [$IDBR4];
                                $stmt5 = $dao->DMLParam($query5, $param5);
                                $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
                                $total_records = $row5['total'];
                                $current_page = 1;
                                $limit = 12;
                                $total_page = ceil($total_records / $limit);
                                if ($current_page > $total_page) {
                                    $current_page = $total_page;
                                } else if ($current_page < 1) {
                                    $current_page = 1;
                                }
                                $start = (($current_page - 1) * $limit + 1);
                                $end = ($start + $limit - 1);

                                $query5 = "select *
                                from (select *, ROW_NUMBER() OVER (ORDER BY IDPR DESC) as rownum
                                       from (select *
                    from (select IDPR,NAMEPR,PRICE,BRIEFSUM,CREATEDATE,QUANTITY, STATUSPRO ,NAMEBR,NAMECTGR,PRODUCT.IDBR,
							[STT]=  CASE 
							when DATEDIFF(MONTH,CREATEDATE,getdate())<=1 then 'NEW'
							when (DATEDIFF(MONTH,CREATEDATE,getdate())>1 and DATEDIFF(MONTH,CREATEDATE,getdate())<3 )then 'nomarl'
							when DATEDIFF(MONTH,CREATEDATE,getdate())=3 then '20%'
							when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then '25%'
							when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then '30%'
							
                             end ,
					      [NEWPRICE]=  CASE 
						  when DATEDIFF(MONTH,CREATEDATE,getdate())<=1 then PRODUCT.PRICE
						  when (DATEDIFF(MONTH,CREATEDATE,getdate())>1 and DATEDIFF(MONTH,CREATEDATE,getdate())<3 )then PRODUCT.PRICE
						  when DATEDIFF(MONTH,CREATEDATE,getdate()) =3 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.2) AS decimal(7,0))
					      when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.25) AS decimal(7,0))
					      when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.3) AS decimal(7,0))
					      
                             end 
                             from PRODUCT 
							 INNER JOIN BRAND B on B.IDBR=PRODUCT.IDBR
							 INNER JOIN CATEGORY C ON C.IDCTGR=PRODUCT.IDCTGR
                             where PRODUCT.IDBR=? and QUANTITY>0 and STATUSPRO = 1 ) as t)  as t1)as tem
                                where tem.rownum between $start and $end
                                 order by tem.rownum ASC  ";
                                $param5 = [$IDBR4];
                                $stmt5 = $dao->DMLParam($query5, $param5);
                                while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)):
                                    $IDPR1 = $row5['IDPR'];
                                    $NAMEPR1 = $row5['NAMEPR'];
                                    $PRICE1 = $row5['NEWPRICE'];
                                    $BRIEFSUM1 = $row5['BRIEFSUM'];
                                    $STT1 = $row5['STT'];
                                    $query6 = "select  * from IMAGES where (IDPR=? and DETAILQUANTITY >0)";
                                    $param6 = [$IDPR1];
                                    $stmt6 = $dao->DMLParam($query6, $param6);
                                    $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);
                                    $NAMEIM1 = $row6['NAMEIM'];
                                    ?>
                                    <div class="col-sx-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="product-grid-item">
                                            <div class="product-element-top"><a
                                                        href="./PRO_DETAILS.php?IDPR=<?= $IDPR1 ?>"> <img
                                                            class="thumbnail" src="../IMAGES/IMG_PRO/<?= $NAMEIM1 ?>"
                                                            alt="<?= $NAMEPR1 ?>"> </a>
                                                <?php
                                                if ($STT1 == 'NEW') {

                                                    ?>
                                                    <span class="new product-label">New</span>
                                                    <?php
                                                }
                                                if ($STT1 == 'nomarl') {
                                                    ?>
                                                    <span style="background-color: transparent"></span>
                                                    <?php
                                                }
                                                if (!($STT1 == 'nomarl') && !($STT1 == 'NEW')) {
                                                    ?>
                                                    <span class="off product-label"><?= $STT1 ?> off</span>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="ayira-buttons">
                                                <div class="quick-view">
                                                    <a href="#" class="open-quick-view" data-bs-toggle="modal"
                                                       data-bs-target="#quick_view"><i
                                                                class="flaticon-search-2"></i></a>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-category-action">
                                                    <div class="product-title"><a
                                                                href="./PRO_DETAILS.php?IDPR=<?= $IDPR1 ?>"><?= $NAMEPR1 ?></a>
                                                    </div>
                                                </div>
                                                <div class="product-category-action">
                                                    <?= $BRIEFSUM1 ?>
                                                </div>
                                                <div class="wrap-price">
                                                    <div class="wrapp-swap">
                                                        <div class="swap-elements">
                                                            <div class="price">
                                                                <div class="product-price">
                                                                    <div class="sale-price">VND <?= $PRICE1 ?></div>
                                                                </div>
                                                            </div>

                                                            <div class="btn-add header-action-btn-cart"><a
                                                                        href="CART.php?IDPR=<?= $IDPR1 ?>"
                                                                        class="add_to_cart_button">
                                                                    <i class="fa fa-shopping-cart"></i> Add to cart</a>
                                                            </div>
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
                                    </div>

                                <?php
                                endwhile;
                                ?>
                                <div class="pagination">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                            <?php
                                            if (($current_page > 1) && ($total_page > 1)) {
                                                echo '<li class="page-item"><a STYLE="background-color:#ffb6c1;border-color: #ffb6c1"   class="page-link" href="SHOWPRO.php?IDBR=' . $IDBR4 . '&page=' . ($current_page - 1) . '">Prev</a></li> ';
                                            }

                                            // Lặp khoảng giữa
                                            for ($i = 1; $i <= $total_page; $i++) {
                                                // Nếu là trang hiện tại thì hiển thị thẻ span
                                                // ngược lại hiển thị thẻ a
                                                if ($i == $current_page) {
                                                    echo '<li class="page-item active">
                                                  <span class="page-link" STYLE="background-color:#ffb6c1;border-color: #ffb6c1">' . $i . '<span class="sr-only">(current)</span>
                                                  </span>
                                                </li>';
                                                } else {
                                                    echo ' <li class="page-item " aria-current="page"><a STYLE="background-color:#ffb6c1;border-color: #ffb6c1" class="page-link"<a href="SHOWPRO.php?IDBR=' . $IDBR4 . '&page=' . $i . '">' . $i . '</a></li> ';
                                                }
                                            }

                                            // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
                                            if ($current_page < $total_page && $total_page > 1) {
                                                echo '<li class="page-item"><a class="page-link"<a STYLE="background-color:#ffb6c1;border-color: #ffb6c1" href="SHOWPRO.php?IDBR=' . $IDBR4 . '&page=' . ($current_page + 1) . '">Next</a> </li> ';
                                            }

                                            ?>
                                        </ul>
                                    </nav>
                                </div>
                            </div>

                        </div>
                    <?php
                    endwhile;
                    ?>

                </div>

            </div>
        <?php
        endif;//endif IDBR
        //NẾU CÓ IDCTGR TRUYỀN QUA
        if (isset($_GET['IDCTGR']) || (isset($_GET['IDCTGR']) && isset($_GET['IDBR']))) {
            $IDCTGR = $_GET['IDCTGR'];
            ?>
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
                        <li class="nav-item" role="presentation"><a class="nav-link active text_light"
                                                                    id="<?= $NAMEBR ?>"
                                                                    data-bs-toggle="tab" href="#BR1" role="tab"
                                                                    aria-selected="true"><?= $NAMEBR ?></a></li>
                        <?PHP
                        $query4 = "select * from BRAND where IDBR!=?";
                        $param4 = [$IDBR];
                        $stmt4 = $dao->DMLParam($query4, $param4);
                        while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)):
                            $IDBR4 = $row4['IDBR'];
                            $NAMEBR4 = $row4['NAMEBR'];
                            ?>
                            <li class="nav-item" role="presentation"><a class="nav-link text_light" id="<?= $NAMEBR4 ?>"
                                                                        data-bs-toggle="tab" href="#<?= $IDBR4 ?>"
                                                                        role="tab"
                                                                        aria-selected="false"><?= $NAMEBR4 ?></a></li>
                        <?php
                        endwhile;
                        ?>
                    </ul>
                </div>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="BR1" role="tabpanel"
                         aria-labelledby="<?= $NAMEBR ?>">
                        <div class="row">
                            <?php
                            $query = "select COUNT (IDPR) as total 
                                        from PRODUCT 
                                        where (IDBR='BR1'and QUANTITY>0 and STATUSPRO = 1 and IDCTGR=?) ";
                            $param = [$IDCTGR];
                            $stmt = $dao->DMLParam($query, $param);
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            $total_records = $row['total'];
                            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $limit = 12;// số item hiển thị trên 1 trang
                            $total_page = ceil($total_records / $limit);
                            if ($current_page > $total_page) {
                                $current_page = $total_page;
                            } else if ($current_page < 1) {
                                $current_page = 1;
                            }
                            $start = (($current_page - 1) * $limit + 1);
                            $end = ($start + $limit - 1);
                            $query = "select *
                                from (select *, ROW_NUMBER() OVER (ORDER BY IDPR DESC) as rownum
                                       from (select *
                    from (select IDPR,NAMEPR,PRICE,BRIEFSUM,CREATEDATE,QUANTITY, STATUSPRO ,NAMEBR,NAMECTGR,PRODUCT.IDBR,PRODUCT.IDCTGR,
							[STT]=  CASE 
							when DATEDIFF(MONTH,CREATEDATE,getdate())<=1 then 'NEW'
							when (DATEDIFF(MONTH,CREATEDATE,getdate())>1 and DATEDIFF(MONTH,CREATEDATE,getdate())<3 )then 'nomarl'
							when DATEDIFF(MONTH,CREATEDATE,getdate())=3 then '20%'
							when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then '25%'
							when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then '30%'
							
                             end ,
					      [NEWPRICE]=  CASE 
						  when DATEDIFF(MONTH,CREATEDATE,getdate())<=1 then PRODUCT.PRICE
						  when (DATEDIFF(MONTH,CREATEDATE,getdate())>1 and DATEDIFF(MONTH,CREATEDATE,getdate())<3 )then PRODUCT.PRICE
						  when DATEDIFF(MONTH,CREATEDATE,getdate()) =3 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.2) AS decimal(7,0))
					      when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.25) AS decimal(7,0))
					      when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.3) AS decimal(7,0))
					      
                             end 
                             from PRODUCT 
							 INNER JOIN BRAND B on B.IDBR=PRODUCT.IDBR
							 INNER JOIN CATEGORY C ON C.IDCTGR=PRODUCT.IDCTGR
                             where PRODUCT.IDCTGR=? and PRODUCT.IDBR='BR1' and QUANTITY>0 and STATUSPRO = 1 ) as t)  as t1)as tem
                                where tem.rownum between $start and $end
                                  order by tem.rownum ASC   ";
                            $param = [$IDCTGR];
                            $stmt = $dao->DMLParam($query, $param);
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                $IDPR = $row['IDPR'];
                                $NAMEPR = $row['NAMEPR'];
                                $PRICE = $row['NEWPRICE'];
                                $BRIEFSUM = $row['BRIEFSUM'];
                                $STT = $row['STT'];
                                $query1 = "select  * from IMAGES where (IDPR=? and DETAILQUANTITY >0)";
                                $param1 = [$IDPR];
                                $stmt1 = $dao->DMLParam($query1, $param1);
                                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                                $NAMEIM = $row1['NAMEIM'];
                                ?>

                                <div class="col-sx-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="product-grid-item">
                                        <div class="product-element-top"><a href="./PRO_DETAILS.php?IDPR=<?= $IDPR ?>">
                                                <img class="thumbnail" src="../IMAGES/IMG_PRO/<?= $NAMEIM ?>"
                                                     alt="<?= $NAMEPR ?>"> </a>
                                            <?php
                                            if ($STT == 'NEW') {

                                                ?>
                                                <span class="new product-label">New</span>
                                                <?php
                                            }
                                            if ($STT == 'nomarl') {
                                                ?>
                                                <span style="background-color: transparent"></span>
                                                <?php
                                            }
                                            if (!($STT == 'nomarl') && !($STT == 'NEW')) {
                                                ?>
                                                <span class="off product-label"><?= $STT ?> off</span>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="ayira-buttons">
                                            <div class="quick-view">
                                                <a href="#" class="open-quick-view" data-bs-toggle="modal"
                                                   data-bs-target="#quick_view"><i
                                                            class="flaticon-search-2"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <div class="product-category-action">
                                                <div class="product-title"><a
                                                            href="./PRO_DETAILS.php?IDPR=<?= $IDPR ?>"><?= $NAMEPR ?></a>
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
                                                                    href="CART.php?IDPR=<?= $IDPR ?>"
                                                                    class="add_to_cart_button"> <i
                                                                        class="fa fa-shopping-cart"></i> Add to cart</a>
                                                        </div>
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
                                </div>
                            <?php
                            endwhile;
                            ?>
                            <div class="pagination">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php
                                        if (($current_page > 1) && ($total_page > 1)) {
                                            echo '<li class="page-item"><a STYLE="background-color:#ffb6c1;border-color: #ffb6c1" class="page-link" href="SHOWPRO.php?IDCTGR=' . $IDCTGR . '&IDBR=BR1&page=' . ($current_page - 1) . '">Prev</a></li> ';
                                        }
                                        // Lặp khoảng giữa
                                        for ($i = 1; $i <= $total_page; $i++) {
                                            // Nếu là trang hiện tại thì hiển thị thẻ span
                                            // ngược lại hiển thị thẻ a
                                            if ($i == $current_page) {
                                                echo '<li class="page-item active">
                                                  <span class="page-link" STYLE="background-color:#ffb6c1;border-color: #ffb6c1">' . $i . '<span class="sr-only">(current)</span>
                                                  </span>
                                                </li>';
                                            } else {
                                                echo ' <li class="page-item " aria-current="page"><a class="page-link"<a STYLE="background-color:#ffb6c1;border-color: #ffb6c1" href="SHOWPRO.php?IDCTGR=' . $IDCTGR . '&IDBR=BR1&page=' . $i . '">' . $i . '</a></li> ';
                                            }
                                        }

                                        // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
                                        if ($current_page < $total_page && $total_page > 1) {
                                            echo '<li class="page-item"><a class="page-link"<a STYLE="background-color:#ffb6c1;border-color: #ffb6c1" href="SHOWPRO.php?IDCTGR=' . $IDCTGR . '&IDBR=BR1&page=' . ($current_page + 1) . '">Next</a> </li> ';
                                        }
                                        ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>

                    </div>
                    <?PHP
                    $query4 = "select * from BRAND where IDBR!='BR1'";
                    $stmt4 = $dao->DML($query4);
                    while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)):
                        $IDBR4 = $row4['IDBR'];
                        $NAMEBR4 = $row4['NAMEBR'];
                        ?>
                        <div class="tab-pane fade" id="<?= $IDBR4 ?>" role="tabpanel" aria-labelledby="<?= $NAMEBR4 ?>">
                            <div class="row">
                                <?php
                                $query5 = "select  COUNT (IDPR) as total
                                from PRODUCT where (IDBR=? and IDCTGR=? and QUANTITY>0 and STATUSPRO = 1 )";
                                $param5 = [$IDBR4, $IDCTGR];
                                $stmt5 = $dao->DMLParam($query5, $param5);
                                $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
                                $total_records = $row5['total'];
                                $current_page = 1;
                                $limit = 12;
                                $total_page = ceil($total_records / $limit);
                                if ($current_page > $total_page) {
                                    $current_page = $total_page;
                                } else if ($current_page < 1) {
                                    $current_page = 1;
                                }
                                $start = (($current_page - 1) * $limit + 1);
                                $end = ($start + $limit - 1);

                                $query5 = "select *
                                from (select *, ROW_NUMBER() OVER (ORDER BY IDPR DESC) as rownum
                                       from (select *
                    from (select IDPR,NAMEPR,PRICE,BRIEFSUM,CREATEDATE,QUANTITY, STATUSPRO ,NAMEBR,NAMECTGR,PRODUCT.IDBR,PRODUCT.IDCTGR,
							[STT]=  CASE 
							when DATEDIFF(MONTH,CREATEDATE,getdate())<=1 then 'NEW'
							when (DATEDIFF(MONTH,CREATEDATE,getdate())>1 and DATEDIFF(MONTH,CREATEDATE,getdate())<3 )then 'nomarl'
							when DATEDIFF(MONTH,CREATEDATE,getdate())=3 then '20%'
							when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then '25%'
							when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then '30%'
							
                             end ,
					      [NEWPRICE]=  CASE 
						  when DATEDIFF(MONTH,CREATEDATE,getdate())<=1 then PRODUCT.PRICE
						  when (DATEDIFF(MONTH,CREATEDATE,getdate())>1 and DATEDIFF(MONTH,CREATEDATE,getdate())<3 )then PRODUCT.PRICE
						  when DATEDIFF(MONTH,CREATEDATE,getdate()) =3 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.2) AS decimal(7,0))
					      when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.25) AS decimal(7,0))
					      when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.3) AS decimal(7,0))
					      
                             end 
                             from PRODUCT 
							 INNER JOIN BRAND B on B.IDBR=PRODUCT.IDBR
							 INNER JOIN CATEGORY C ON C.IDCTGR=PRODUCT.IDCTGR
                             where  PRODUCT.IDBR=? and PRODUCT.IDCTGR=? and QUANTITY>0 and STATUSPRO = 1 ) as t)  as t1)as tem
                                where tem.rownum between $start and $end
                                 order by tem.rownum ASC";
                                $param5 = [$IDBR4, $IDCTGR];
                                $stmt5 = $dao->DMLParam($query5, $param5);
                                while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)):
                                    $IDPR1 = $row5['IDPR'];
                                    $NAMEPR1 = $row5['NAMEPR'];
                                    $PRICE1 = $row5['NEWPRICE'];
                                    $BRIEFSUM1 = $row5['BRIEFSUM'];
                                    $STT1 = $row5['STT'];
                                    $query6 = "select  * from IMAGES where (IDPR=? and DETAILQUANTITY >0)";
                                    $param6 = [$IDPR1];
                                    $stmt6 = $dao->DMLParam($query6, $param6);
                                    $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);
                                    $NAMEIM1 = $row6['NAMEIM'];
                                    ?>
                                    <div class="col-sx-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="product-grid-item">
                                            <div class="product-element-top"><a
                                                        href="./PRO_DETAILS.php?IDPR=<?= $IDPR1 ?>"> <img
                                                            class="thumbnail" src="../IMAGES/IMG_PRO/<?= $NAMEIM1 ?>"
                                                            alt="<?= $NAMEPR1 ?>"> </a>
                                                <?php
                                                if ($STT1 == 'NEW') {

                                                    ?>
                                                    <span class="new product-label">New</span>
                                                    <?php
                                                }
                                                if ($STT1 == 'nomarl') {
                                                    ?>
                                                    <span style="background-color: transparent"></span>
                                                    <?php
                                                }
                                                if (!($STT1 == 'nomarl') && !($STT1 == 'NEW')) {
                                                    ?>
                                                    <span class="off product-label"><?= $STT1 ?> off</span>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="ayira-buttons">
                                                <div class="quick-view">
                                                    <a href="#" class="open-quick-view" data-bs-toggle="modal"
                                                       data-bs-target="#quick_view"><i
                                                                class="flaticon-search-2"></i></a>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-category-action">
                                                    <div class="product-title"><a
                                                                href="./PRO_DETAILS.php?IDPR=<?= $IDPR1 ?>"><?= $NAMEPR1 ?></a>
                                                    </div>
                                                </div>
                                                <div class="product-category-action">
                                                    <?= $BRIEFSUM1 ?>
                                                </div>
                                                <div class="wrap-price">
                                                    <div class="wrapp-swap">
                                                        <div class="swap-elements">
                                                            <div class="price">
                                                                <div class="product-price">
                                                                    <div class="sale-price">VND <?= $PRICE1 ?></div>
                                                                </div>
                                                            </div>

                                                            <div class="btn-add header-action-btn-cart"><a
                                                                        href="CART.php?IDPR=<?= $IDPR1 ?>"
                                                                        class="add_to_cart_button"> <i
                                                                            class="fa fa-shopping-cart"></i> Add to cart</a>
                                                            </div>
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
                                    </div>

                                <?php
                                endwhile;
                                ?>
                                <div class="pagination">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                            <?php
                                            if (($current_page > 1) && ($total_page > 1)) {
                                                echo '<li class="page-item"><a STYLE="background-color:#ffb6c1;border-color: #ffb6c1"class="page-link" href="SHOWPRO.php?IDCTGR=' . $IDCTGR . '&IDBR=' . $IDBR4 . '&page=' . ($current_page - 1) . '">Prev</a></li> ';
                                            }

                                            // Lặp khoảng giữa
                                            for ($i = 1; $i <= $total_page; $i++) {
                                                // Nếu là trang hiện tại thì hiển thị thẻ span
                                                // ngược lại hiển thị thẻ a
                                                if ($i == $current_page) {
                                                    echo '<li class="page-item active">
                                                  <span class="page-link" STYLE="background-color:#ffb6c1;border-color: #ffb6c1">' . $i . '<span class="sr-only">(current)</span>
                                                  </span>
                                                </li>';
                                                } else {
                                                    echo ' <li class="page-item " aria-current="page"><a STYLE="background-color:#ffb6c1;border-color: #ffb6c1" class="page-link"<a href="SHOWPRO.php?IDCTGR=' . $IDCTGR . '&IDBR=' . $IDBR4 . '&page=' . $i . '">' . $i . '</a></li> ';
                                                }
                                            }

                                            // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
                                            if ($current_page < $total_page && $total_page > 1) {
                                                echo '<li class="page-item"><a class="page-link"<a STYLE="background-color:#ffb6c1;border-color: #ffb6c1" href="SHOWPRO.php?IDCTGR=' . $IDCTGR . '&IDBR=' . $IDBR4 . '&page=' . ($current_page + 1) . '">Next</a> </li> ';
                                            }

                                            ?>
                                        </ul>
                                    </nav>
                                </div>
                            </div>

                        </div>
                    <?php
                    endwhile;
                    ?>

                </div>

            </div>
            <?php
        } //endif IDCTGR
        //NẾU KO CÓ THÌ HIỆN THEO BRAND, THỨ TƯ IDBR VÀ NEW
        elseif (empty($_GET['search']) && empty($_GET['IDBR']) && !isset($_GET['IDCTGR'])) {
            ?>
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs justify-content-center text-uppercase" id="myTab" role="tablist">
                        <?php

                        $query = "select * from BRAND where IDBR='BR1'";
                        $stmt = $dao->DML($query);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        $NAMEBR = $row['NAMEBR'];

                        ?>
                        <li class="nav-item" role="presentation"><a class="nav-link active text_light"
                                                                    id="<?= $NAMEBR ?>"
                                                                    data-bs-toggle="tab" href="#BR1" role="tab"
                                                                    aria-selected="true"><?= $NAMEBR ?></a></li>
                        <?PHP
                        $query4 = "select * from BRAND where IDBR!='BR1'";

                        $stmt4 = $dao->DML($query4);
                        while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)):
                            $IDBR4 = $row4['IDBR'];
                            $NAMEBR4 = $row4['NAMEBR'];
                            ?>
                            <li class="nav-item" role="presentation"><a class="nav-link text_light" id="<?= $NAMEBR4 ?>"
                                                                        data-bs-toggle="tab" href="#<?= $IDBR4 ?>"
                                                                        role="tab"
                                                                        aria-selected="false"><?= $NAMEBR4 ?></a></li>
                        <?php
                        endwhile;
                        ?>
                    </ul>
                </div>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="BR1" role="tabpanel"
                         aria-labelledby="<?= $NAMEBR ?>">

                        <div class="row">
                            <?php
                            $query = "select COUNT (IDPR) as total 
                                        from PRODUCT 
                                        where (IDBR='BR1' and QUANTITY>0 and STATUSPRO = 1) ";
                            $stmt = $dao->DML($query);
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            $total_records = $row['total'];
                            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $limit = 12;// số item hiển thị trên 1 trang
                            $total_page = ceil($total_records / $limit);
                            if ($current_page > $total_page) {
                                $current_page = $total_page;
                            } else if ($current_page < 1) {
                                $current_page = 1;
                            }
                            $start = (($current_page - 1) * $limit + 1);
                            $end = ($start + $limit - 1);
                            $query = "select *
                                from (select *, ROW_NUMBER() OVER (ORDER BY IDPR DESC) as rownum
                                       from (select *
                    from (select IDPR,NAMEPR,PRICE,BRIEFSUM,CREATEDATE,QUANTITY, STATUSPRO ,NAMEBR,NAMECTGR,PRODUCT.IDBR,
							[STT]=  CASE 
							when DATEDIFF(MONTH,CREATEDATE,getdate())<=1 then 'NEW'
							when (DATEDIFF(MONTH,CREATEDATE,getdate())>1 and DATEDIFF(MONTH,CREATEDATE,getdate())<3 )then 'nomarl'
							when DATEDIFF(MONTH,CREATEDATE,getdate())=3 then '20%'
							when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then '25%'
							when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then '30%'
							
                             end ,
					      [NEWPRICE]=  CASE 
						  when DATEDIFF(MONTH,CREATEDATE,getdate())<=1 then PRODUCT.PRICE
						  when (DATEDIFF(MONTH,CREATEDATE,getdate())>1 and DATEDIFF(MONTH,CREATEDATE,getdate())<3 )then PRODUCT.PRICE
						  when DATEDIFF(MONTH,CREATEDATE,getdate()) =3 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.2) AS decimal(7,0))
					      when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.25) AS decimal(7,0))
					      when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.3) AS decimal(7,0))
					      
                             end 
                             from PRODUCT 
							 INNER JOIN BRAND B on B.IDBR=PRODUCT.IDBR
							 INNER JOIN CATEGORY C ON C.IDCTGR=PRODUCT.IDCTGR
                    where PRODUCT.IDBR='BR1' and QUANTITY>0 and STATUSPRO = 1 ) as t)  as t1)as tem
                                where tem.rownum between $start and $end
                                 order by tem.rownum ASC ";

                            $stmt = $dao->DML($query);
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                $IDPR = $row['IDPR'];
                                $NAMEPR = $row['NAMEPR'];
                                $PRICE = $row['NEWPRICE'];
                                $BRIEFSUM = $row['BRIEFSUM'];
                                $STT = $row['STT'];
                                $query1 = "select  * from IMAGES where (IDPR=? and DETAILQUANTITY >0)";
                                $param1 = [$IDPR];
                                $stmt1 = $dao->DMLParam($query1, $param1);
                                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                                $NAMEIM = $row1['NAMEIM'];
                                ?>
                                <div class="col-sx-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="product-grid-item">
                                        <div class="product-element-top"><a href="./PRO_DETAILS.php?IDPR=<?= $IDPR ?>">
                                                <img class="thumbnail" src="../IMAGES/IMG_PRO/<?= $NAMEIM ?>"
                                                     alt="<?= $NAMEPR ?>"> </a>
                                            <?php
                                            if ($STT == 'NEW') {

                                                ?>
                                                <span class="new product-label">New</span>
                                                <?php
                                            }
                                            if ($STT == 'nomarl') {
                                                ?>
                                                <span style="background-color: transparent"></span>
                                                <?php
                                            }
                                            if (!($STT == 'nomarl') && !($STT == 'NEW')) {
                                                ?>
                                                <span class="off product-label"><?= $STT ?> off</span>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="ayira-buttons">
                                            <div class="quick-view">
                                                <a href="#" class="open-quick-view" data-bs-toggle="modal"
                                                   data-bs-target="#quick_view"><i
                                                            class="flaticon-search-2"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <div class="product-category-action">
                                                <div class="product-title"><a
                                                            href="./PRO_DETAILS.php?IDPR=<?= $IDPR ?>"><?= $NAMEPR ?></a>
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
                                                                    href="CART.php?IDPR=<?= $IDPR ?>"
                                                                    class="add_to_cart_button"> <i
                                                                        class="fa fa-shopping-cart"></i> Add to cart</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swatches-on-grid">
                                                    <div class="widget-color">
                                                        <ul class="color-list ps-0">
                                                            <?php
                                                            $query2 = "select  COLOR from IMAGES where (IDPR=? and DETAILQUANTITY >0 )";
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
                                </div>
                            <?php
                            endwhile;
                            ?>
                            <div class="pagination">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php
                                        if (($current_page > 1) && ($total_page > 1)) {
                                            echo '<li class="page-item"><a STYLE="background-color:#ffb6c1;border-color: #ffb6c1 " class="page-link" href="SHOWPRO.php?IDBR=BR1&page=' . ($current_page - 1) . '">Prev</a></li> ';
                                        }
                                        // Lặp khoảng giữa
                                        for ($i = 1; $i <= $total_page; $i++) {
                                            // Nếu là trang hiện tại thì hiển thị thẻ span
                                            // ngược lại hiển thị thẻ a
                                            if ($i == $current_page) {
                                                echo '<li class="page-item active">
                                                  <span class="page-link" STYLE="background-color:#ffb6c1;border-color: #ffb6c1 ">' . $i . '<span class="sr-only">(current)</span>
                                                  </span>
                                                </li>';
                                            } else {
                                                echo ' <li class="page-item " aria-current="page"><a class="page-link"<a STYLE="background-color:#ffb6c1;border-color: #ffb6c1 " href="SHOWPRO.php?IDBR=BR1&page=' . $i . '">' . $i . '</a></li> ';
                                            }
                                        }

                                        // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
                                        if ($current_page < $total_page && $total_page > 1) {
                                            echo '<li class="page-item"><a class="page-link"<a STYLE="background-color:#ffb6c1;border-color: #ffb6c1 " href="SHOWPRO.php?IDBR=BR1&page=' . ($current_page + 1) . '">Next</a> </li> ';
                                        }
                                        ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <?PHP
                    $query4 = "select * from BRAND where (IDBR!='BR1')";
                    $stmt4 = $dao->DML($query4);
                    while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)):
                        $IDBR4 = $row4['IDBR'];
                        $NAMEBR4 = $row4['NAMEBR'];
                        ?>
                        <div class="tab-pane fade" id="<?= $IDBR4 ?>" role="tabpanel" aria-labelledby="<?= $NAMEBR4 ?>">
                            <div class="row">
                                <?php
                                $query5 = "select  COUNT (IDPR) as total
                                from PRODUCT where (IDBR=? and QUANTITY>0 and STATUSPRO = 1)";
                                $param5 = [$IDBR4];
                                $stmt5 = $dao->DMLParam($query5, $param5);
                                $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
                                $total_records = $row5['total'];
                                $current_page = 1;
                                $limit = 12;
                                $total_page = ceil($total_records / $limit);
                                if ($current_page > $total_page) {
                                    $current_page = $total_page;
                                } else if ($current_page < 1) {
                                    $current_page = 1;
                                }
                                $start = (($current_page - 1) * $limit + 1);
                                $end = ($start + $limit - 1);

                                $query5 = "select *
                                from (select *, ROW_NUMBER() OVER (ORDER BY IDPR DESC) as rownum
                                       from (select *
                    from (select IDPR,NAMEPR,PRICE,BRIEFSUM,CREATEDATE,QUANTITY, STATUSPRO ,NAMEBR,NAMECTGR,PRODUCT.IDBR,
							[STT]=  CASE 
							when DATEDIFF(MONTH,CREATEDATE,getdate())<=1 then 'NEW'
							when (DATEDIFF(MONTH,CREATEDATE,getdate())>1 and DATEDIFF(MONTH,CREATEDATE,getdate())<3 )then 'nomarl'
							when DATEDIFF(MONTH,CREATEDATE,getdate())=3 then '20%'
							when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then '25%'
							when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then '30%'
							
                             end ,
					      [NEWPRICE]=  CASE 
						  when DATEDIFF(MONTH,CREATEDATE,getdate())<=1 then PRODUCT.PRICE
						  when (DATEDIFF(MONTH,CREATEDATE,getdate())>1 and DATEDIFF(MONTH,CREATEDATE,getdate())<3 )then PRODUCT.PRICE
						  when DATEDIFF(MONTH,CREATEDATE,getdate()) =3 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.2) AS decimal(7,0))
					      when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.25) AS decimal(7,0))
					      when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.3) AS decimal(7,0))
					      
                             end 
                             from PRODUCT 
							 INNER JOIN BRAND B on B.IDBR=PRODUCT.IDBR
							 INNER JOIN CATEGORY C ON C.IDCTGR=PRODUCT.IDCTGR
                             where PRODUCT.IDBR=? and QUANTITY>0 and STATUSPRO = 1 ) as t)  as t1)as tem
                                where tem.rownum between $start and $end
                                 order by tem.rownum ASC  ";
                                $param5 = [$IDBR4];
                                $stmt5 = $dao->DMLParam($query5, $param5);
                                while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)):
                                    $IDPR1 = $row5['IDPR'];
                                    $NAMEPR1 = $row5['NAMEPR'];
                                    $PRICE1 = $row5['NEWPRICE'];
                                    $BRIEFSUM1 = $row5['BRIEFSUM'];
                                    $STT1 = $row5['STT'];
                                    $query6 = "select  * from IMAGES where (IDPR=? and DETAILQUANTITY >0)";
                                    $param6 = [$IDPR1];
                                    $stmt6 = $dao->DMLParam($query6, $param6);
                                    $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);
                                    $NAMEIM1 = $row6['NAMEIM'];
                                    ?>
                                    <div class="col-sx-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="product-grid-item">
                                            <div class="product-element-top"><a
                                                        href="./PRO_DETAILS.php?IDPR=<?= $IDPR1 ?>"> <img
                                                            class="thumbnail" src="../IMAGES/IMG_PRO/<?= $NAMEIM1 ?>"
                                                            alt="<?= $NAMEPR1 ?>"> </a>
                                                <?php
                                                if ($STT1 == 'NEW') {

                                                    ?>
                                                    <span class="new product-label">New</span>
                                                    <?php
                                                }
                                                if ($STT1 == 'nomarl') {
                                                    ?>
                                                    <span style="background-color: transparent"></span>
                                                    <?php
                                                }
                                                if (!($STT1 == 'nomarl') && !($STT1 == 'NEW')) {
                                                    ?>
                                                    <span class="off product-label"><?= $STT1 ?> off</span>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="ayira-buttons">
                                                <div class="quick-view">
                                                    <a href="#" class="open-quick-view" data-bs-toggle="modal"
                                                       data-bs-target="#quick_view"><i
                                                                class="flaticon-search-2"></i></a>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-category-action">
                                                    <div class="product-title"><a
                                                                href="./PRO_DETAILS.php?IDPR=<?= $IDPR1 ?>"><?= $NAMEPR1 ?></a>
                                                    </div>
                                                </div>
                                                <div class="product-category-action">
                                                    <?= $BRIEFSUM1 ?>
                                                </div>
                                                <div class="wrap-price">
                                                    <div class="wrapp-swap">
                                                        <div class="swap-elements">
                                                            <div class="price">
                                                                <div class="product-price">
                                                                    <div class="sale-price">VND <?= $PRICE1 ?></div>
                                                                </div>
                                                            </div>

                                                            <div class="btn-add header-action-btn-cart"><a
                                                                        href="CART.php?IDPR=<?= $IDPR1 ?>"
                                                                        class="add_to_cart_button">
                                                                    <i class="fa fa-shopping-cart"></i> Add to cart</a>
                                                            </div>
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
                                    </div>
                                <?php
                                endwhile;
                                ?>
                                <div class="pagination">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                            <?php
                                            if (($current_page > 1) && ($total_page > 1)) {
                                                echo '<li class="page-item"><a STYLE="background-color:#ffb6c1;border-color: #ffb6c1 " class="page-link" href="SHOWPRO.php?IDBR=' . $IDBR4 . '&page=' . ($current_page - 1) . '">Prev</a></li> ';
                                            }

                                            // Lặp khoảng giữa
                                            for ($i = 1; $i <= $total_page; $i++) {
                                                // Nếu là trang hiện tại thì hiển thị thẻ span
                                                // ngược lại hiển thị thẻ a
                                                if ($i == $current_page) {
                                                    echo '<li class="page-item active">
                                                  <span class="page-link" STYLE="background-color:#ffb6c1;border-color: #ffb6c1 ">' . $i . '<span class="sr-only">(current)</span>
                                                  </span>
                                                </li>';
                                                } else {
                                                    echo ' <li class="page-item " aria-current="page"><a STYLE="background-color:#ffb6c1;border-color: #ffb6c1 "class="page-link"<a href="SHOWPRO.php?IDBR=' . $IDBR4 . '&page=' . $i . '">' . $i . '</a></li> ';
                                                }
                                            }

                                            // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
                                            if ($current_page < $total_page && $total_page > 1) {
                                                echo '<li class="page-item"><a class="page-link"<a STYLE="background-color:#ffb6c1;border-color: #ffb6c1 " href="SHOWPRO.php?IDBR=' . $IDBR4 . '&page=' . ($current_page + 1) . '">Next</a> </li> ';
                                            }

                                            ?>
                                        </ul>
                                    </nav>
                                </div>
                            </div>

                        </div>
                    <?php
                    endwhile;
                    ?>

                </div>

            </div>

            <?php
        }
        ?>
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


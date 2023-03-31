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

    <title>NEW ARRIVAL</title>
</head>

<body>
<?PHP
include("TEMPLATE/header.php")
?>
<section class="new_arrivals section-padding-03">
    <div class="container">
        <!-- Section Title Start -->
        <div class="section-title text-center">
            <h4 class="title text_darkt">What's New?</h4>
            <hr>
            <span class="title-subtitle text_light"><strong></strong></span></div>
        <!-- Section Title End -->
        <div class="page-banner new-page-banner section">
            <div class="container"></div>
        </div>
        <!-- product Start -->
        <div class="row">
            <div class="col-md-12">
                <!-- product carousel Start -->
                <ul class="nav nav-tabs justify-content-center text-uppercase" id="myTab" role="tablist"
                    id="new_arrivals">
                    <?PHP
                    $query = "select COUNT (IDPR) as total                  
                    from (select IDPR,CREATEDATE, 
					        CASE when DATEDIFF(DAY,CREATEDATE,getdate()) <=15 then 'NEW'
                                     end AS stt
                                    from PRODUCT 
                                    where QUANTITY>0) t where stt is not null";

                    $stmt = $dao->DML($query);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $total_records=$row['total'];
                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $limit = 12;// số item hiển thị trên 1 trang
                    $total_page = ceil($total_records / $limit);
                    if ($current_page > $total_page){
                        $current_page = $total_page;
                    }
                    else if ($current_page < 1){
                        $current_page = 1;
                    }
                    $start = (($current_page - 1) * $limit +1);
                    $end=($start+$limit-1);
                    $query = "select *

                               from ( select *, ROW_NUMBER() OVER (ORDER BY IDPR DESC) as rownum
                                                from (select IDPR,NAMEPR,PRICE,BRIEFSUM,CREATEDATE,
														CASE when DATEDIFF(DAY,CREATEDATE,getdate())<15 then 'NEW'
														end AS stt 
									from PRODUCT 
                                    where QUANTITY > 0) T
									where T.stt is not null ) tem
                                                where tem.rownum between $start and $end  order by tem.rownum ASC";
                    $stmt = $dao->DML($query);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                        $IDPR = $row['IDPR'];
                        $NAMEPR = $row['NAMEPR'];
                        $PRICE = $row['PRICE'];
                        $BRIEFSUM = $row['BRIEFSUM'];
                        $query1 = "select  * from IMAGES where IDPR=?";
                        $param1 = [$IDPR];
                        $stmt1 = $dao->DMLParam($query1, $param1);
                        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                        $NAMEIM = $row1['NAMEIM'];
                        ?>
                        <div class="col-sx-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="product-grid-item">
                                <div class="product-element-top"><a href="./PRO_DETAILS.php?IDPR=<?= $IDPR ?>">
                                        <img class="thumbnail" src="../IMAGES/IMG_PRO/<?= $NAMEIM ?>"
                                         height="300vh"    alt="<?= $NAMEPR ?>" > </a>
                                    <span class="new product-label">New</span></div>
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
                                                <div class="btn-add header-action-btn-cart"> <a href="CART.php?IDPR=<?=$IDPR?>"
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
                        </div>
                        <?php
                        endwhile;
                        ?>
                </ul>
                <!-- product carousel End -->
            </div>
            <div class="pagination">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php
                        if (($current_page > 1) && ($total_page > 1) ){
                            echo '<li class="page-item"><a class="page-link" href="NEW.php?IDBR='.'&page=' . ($current_page - 1) . '">Prev</a></li> ';
                        }

                        // Lặp khoảng giữa
                        for ($i = 1; $i <= $total_page; $i++) {
                            // Nếu là trang hiện tại thì hiển thị thẻ span
                            // ngược lại hiển thị thẻ a
                            if ($i == $current_page) {
                                echo '<li class="page-item active">
                                                  <span class="page-link">' . $i . '<span class="sr-only">(current)</span>
                                                  </span>
                                                </li>';
                            } else {
                                echo ' <li class="page-item " aria-current="page"><a class="page-link"<a href="NEW.php?IDBR='.'&page=' . $i . '">' . $i . '</a></li> ';
                            }
                        }

                        // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
                        if ($current_page < $total_page && $total_page > 1) {
                            echo '<li class="page-item"><a class="page-link"<a href="NEW.php?IDBR='.'&page=' . ($current_page + 1) . '">Next</a> </li> ';
                        }
                        ?>
                    </ul>
                </nav>
            </div>
            <!-- product End -->
        </div>
</section>
<?php
include('TEMPLATE/footer.php');
$dao->closeConn();
?>


<script src="../JS/XUAN_JS/HOME.js"></script>
<script src="../JS/bootstrap.bundle.min.js"></script>
<script src="../JS/jquery-2.2.4.js"></script>
<script src="../CSS/vendors/owlcarousel/owl.carousel.min.js"></script>
<script src="../JS/custom.js"></script>
</body>
</html>

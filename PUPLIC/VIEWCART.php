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

<div class="section section-padding-04 section-padding-03">
    <div class="container">
        <!-- Checkout Start -->
        <div class="checkout-wrapper mt-0">

            <div class="row">
                <div class="cart-wrapper">
                    <div class="cart-table table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="product-name" colspan="3">Product</th>
                                <th class="product-price">Price</th>
                                <th class="">Quantity</th>
                                <th class="product-subtotal">Total</th>
                            </tr>
                            </thead>
                            <?php
                            $subtotal = 0;
                            $total = 0;
                            foreach ($cart as $IDPR => $value):
                                $NAMEPR = $value['NAMEPR'];
                                $PRICE = $value['NEWPRICE'];
                                $QUANTITY = $value['QUANTITY'];
                                $subtotal += ($PRICE * $QUANTITY);
                                $total += 1;
                                ?>
                                <tbody>
                                <tr>
                                    <td class="product-action">
                                        <div class="cart-product-remove"><a
                                                    href="CART.php?IDPR=<?= $IDPR ?>&action=delete"><i
                                                        class="flaticon-error"></i></a></div>
                                    </td>
                                    <?php
                                    $query2 = "select * from IMAGES where IDPR=?";
                                    $param2 = [$IDPR];
                                    $stmt2 = $dao->DMLParam($query2, $param2);
                                    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                    $NAMEIM = $row2['NAMEIM'];
                                    ?>
                                    <td class="product-image"><a class="name"
                                                                 href="PRO_DETAILS.php?IDPR=<?= $IDPR ?>"><img
                                                    src="../IMAGES/IMG_PRO/<?= $NAMEIM ?>"
                                                    alt="<?= $NAMEPR ?>"></a>
                                    </td>
                                    <td class="product-name"><a class="name"
                                                                href="PRO_DETAILS.php?IDPR=<?= $IDPR ?>"><?= $NAMEPR ?>
                                            <br>
                                        </a>
                                    </td>
                                    <td class=" product-price subtotal
                                                        ">
                                        <div class="product-price"><span
                                                    class="sale-price text_dark"><?= number_format($PRICE) ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <form action="CART.php">
                                            <input type="hidden" name="IDPR" value="<?= $IDPR ?>">

                                            <div class="product-quantity d-inline-flex">
                                                <button type="button" class="sub">-</button>
                                                <input type="text" value="<?= $value['QUANTITY'] ?>"
                                                       name="QUANTITY">
                                                <button type="button" class="add">+</button>
                                            </div>
                                            <input type="submit" value="update" name="action" style="margin-top: 5px;
                                                     margin-left: 10px;"></input>
                                        </form>
                                    </td>
                                    <td class="product-price">
                                        <div class="product-price"><span
                                                    class="sale-price">VND <?= number_format($PRICE * $QUANTITY) ?></span>
                                        </div>
                                    </td>
                                </tr>

                                </tbody>
                            <?php
                            endforeach;
                            ?>
                            <tbody>
                            <tr>
                                <td class="product-action">
                                </td>
                                <td class="product-image"></td>
                                <td class="product-name"><h5>SubTotal</h5></td>

                                <td class="product-price subtotal"></td>
                                <td></td>
                                <td class="product-price">
                                    <div class="product-price"><span
                                                class="sale-price"><strong><?= number_format($subtotal) ?></strong></span></div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="checkout-payment">
                <div class="checkout-btn ">
                    <a href="./PLACEORDER.php" class="load-more primary_dark_btn" style="position: relative;margin-left: 5px;
                                top: -3px">Place Order</a>
                </div>
            </div>

        </div>
        <!-- Checkout End -->
    </div>

    <!-- Checkout End -->


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

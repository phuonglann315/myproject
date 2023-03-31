<?php
session_start();
include("../DAO/DaoDatabase.php");
$dao = new DaoDatabase();
$cart = (isset($_SESSION['cart'])) ? $_SESSION['cart'] : [];
if (isset($_GET['action'])) {
    //dau tien vo bang USERS xoa het tat ca nhung lock ở user có thời gian lock từ 15p
    $query10 = "EXEC del_locktime ";
    $stmt10 = $dao->DML($query10);
    switch ($_GET['action']) {
        case "login":
            $pass = $_POST['PASS'];
            $user = $_POST['USERNAME'];
            $user = strtolower($user);
            $query = "select lower(USERNAME),PASS,locktime from USERS
                where ( USERNAME = ? and  PASS = ? and locktime is null and STTUSER !=0)";
            $param = [
                $user, $pass
            ];
            $stmt = $dao->DMLParam($query, $param);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //nếu ko có dòng nào thì bắt đầu check tại sao
            if ($stmt->rowCount() == 0) {
                // đầu tiên check user có tồn tại hay ko
                $query = "select USERNAME from USERS 
                where ( USERNAME = ?)";
                $param = [
                    $user
                ];
                $stmt = $dao->DMLParam($query, $param);
                //nếu ko có usẻ nào như này tức là user ko tồn tại
                if ($stmt->rowCount() == 0) {
                    echo '<script language="javascript">';
                    echo 'alert(" USERNAME NOT EXIST")';
                    echo '</script>';
                }//nếu có user này tồn tại thì kiểm tra xem user bị khóa hay ko
                else {
                    $query = "select USERNAME from USERS 
                where ( USERNAME = ?  and (locktime is not null or STTUSER =0) )";
                    $param = [
                        $user
                    ];
                    $stmt = $dao->DMLParam($query, $param);
                    //nếu ko có dòng nào tức là user này ko bị lock, kiểm tra sang pass
                    if ($stmt->rowCount() == 0) {
                        $query = "select USERNAME,PASS from USERS
                    where (USERNAME  = ? and  PASS = ?)";
                        $param = [
                            $user, $pass
                        ];
                        $stmt = $dao->DMLParam($query, $param);
                        //nếu ko có dòng pass và user nào khớp tức pass sai
                        if ($stmt->rowCount() == 0) {
                            // đầu tiên check coi đã sai pass bao nhiu lần
                            $query = "select * from LOCKUSERS where (USERNAME=?)";
                            $param = [$user];
                            $stmt = $dao->DMLParam($query, $param);
                            // nếu trong bảng  ghi nhận lần log in sai dưới 5 lần
                            if (($stmt->rowCount() <= 4)) {
                                $query1 = "select max(COUNTS) as tem from LOCKUSERS WHERE USERNAME=?";
                                $param1 = [$user];
                                $stmt1 = $dao->DMLParam($query1, $param1);
                                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                                $max = $row1['tem'];
                                $max1 = $max + 1;
                                // nếu pass sai thì insert vào bảng lock
                                $query2 = "insert into LOCKUSERS(USERNAME) values(?)";
                                $param2 = [$user];
                                $stmt2 = $dao->DMLParam($query2, $param2);
                                echo "<script language='JavaScript'>alert(\" WRONG PASS $max1 TIME, YOUR USER WILL LOCK WHEN WRONG PASS 5 TIME\");</script>";
                            }
                            if (($stmt->rowCount() == 5)) {
                                echo '<script language="javascript">';
                                echo 'alert(" YOUR ACCOUNT LOCKED,KINDLY RE-LOGIN AFTER 15 MINUTE")';
                                echo '</script>';
                            }
                        }
                    }//nếu có dòng tức là user đang bị lock
                    else {
                        echo '<script language="javascript">';
                        echo 'alert(" YOUR ACCOUNT LOCKED,KINDLY RE-LOGIN AFTER 15 MINUTE")';
                        echo '</script>';
                    }

                }
            } //Nếu có thì cho đăng nhập, gán session cho user
            else {
                $query="delete FROM LOCKUSERS where USERNAME =?";
                $param=[$user];
                $stmt=$dao->DMLParam($query,$param);
                $_SESSION['USERNAME'] = $user;
                header("Location: PLACEORDER.php");

            }//nếu có dữ liệu khớp thì vô index
            break;
        case "signup":
            $pass = $_POST['PASS'];
            $user = $_POST['USERNAME'];
            $user = strtolower($user);
            $phone = $_POST['PHONE'];
            $email = $_POST['EMAIL'];
            $query = "select lower (USERNAME) from USERS
                where ( USERNAME = ? )";
            $param = [
                $user
            ];
            $stmt = $dao->DMLParam($query, $param);
            //nếu ko có USERNAME thì
            if ($stmt->rowCount() == 0) {
                //check tiếp xem có email ko
                $query = "select upper(EMAIL) from USERS
                    where (EMAIL = ? )";
                $param = [
                    $email
                ];
                $stmt = $dao->DMLParam($query, $param);
                if ($stmt->rowCount() == 0) {
                    //check tiếp xem có PHONE ko
                    $query = "select PHONE from USERS
                        where ( PHONE = ? )";
                    $param = [
                        $_POST['PHONE']
                    ];
                    $stmt = $dao->DMLParam($query, $param);
                    if ($stmt->rowCount() == 0) {//NẾU KO CÓ PHONE THÌ INSERT VÀO
                        $query1 = "insert into USERS(USERNAME,PASS, EMAIL, PHONE,STTUSER)
                             values (?,?,?,?,1)";
                        $param1 = [
                            strtolower($user),
                            $pass,
                            $email,
                            $phone
                        ];
                        $dao->DMLParam($query1, $param1);
                        $_SESSION['USERNAME'] = $user;
                        header("Location: PLACEORDER.php");

                    } else {
                        echo '<script language="javascript">';
                        echo 'alert(" PHONE HAS AVAILABLE")';
                        echo '</script>';
                    }//nếu có PHONE thì báo lỗi
                } else {
                    echo '<script language="javascript">';
                    echo 'alert("EMAIL HAS AVAILABLE")';
                    echo '</script>';

                }//nếu có EMAIL thì báo lỗi
            } else {
                echo '<script language="javascript">';
                echo 'alert("USERNAME HAS AVAILABLE")';
                echo '</script>';

            }//nếu có USERNAME thì báo lỗi
            break;
        case "order":
            $USERNAME = $_SESSION['USERNAME'];
            $FULLNAME = $_POST['FULLNAME'];
            if(isset($_POST['PHONE'])!='null'){
                $PHONE = $_POST['PHONE'];
            }
            else{
                $PHONE= $_POST['phone'];
            }
            $ADDRESS = $_POST['ADDRESS'];
            $NOTE = $_POST['NOTE'];
            $query2 = "insert into ORDERS (USERNAME,FULLNAME,PHONE,ADDDRESS,NOTE,STTO) values (?,?,?,?,?,0)";
            $param2 = [$USERNAME, $FULLNAME, $PHONE, $ADDRESS, $NOTE];
            $stmt2 = $dao->DMLParam($query2, $param2);

            $IDIV = '0';

            foreach ($cart as  $value):
                $IDPR=$value['IDPR'];
                $PRICE = $value['NEWPRICE'];
                $QUANTITY = $value['QUANTITY'];
                $query = "select max(IDIV) as IDIV from ORDERS where USERNAME=?";
                $param = [$USERNAME];
                $stmt = $dao->DMLParam($query, $param);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $IDIV = $row['IDIV'];

                $query3 = "insert into details_ORDERS (IDIV,IDPR,QUANTITY_order,PRICE) values (?,?,?,?)";
                $param3 = [$IDIV, $IDPR, $QUANTITY, $PRICE];
                $stmt3 = $dao->DMLParam($query3, $param3);
            endforeach;
            unset($_SESSION['cart']);
            header("Location: THANK.php");
            break;
    }
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
    <link rel="stylesheet" href="../CSS/css/style.css">
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
            <h2 class="page-title">Place Order</h2>
            <ul class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="HOME.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="VIEWCART.php"><i class="fa fa-shopping-bag"></i> Cart</a></li>
                <li class="breadcrumb-item active" style="color:#ffb6c1 "><i class="fa fa-address-card"></i>Place Order</li>
            </ul>
        </div>
    </div>
</div>
<div class="section section-padding-04 section-padding-03">
    <div class="container">
        <?php
        if (!isset($_SESSION['USERNAME'])) {
            ?>
            <div class=" content-wrapper">
                <h1>Kindly <a href="#" class="action" data-bs-toggle="modal" data-bs-target="#login">Login</a> To Place
                    Order</h1>
            </div>
            <div class="modal fade login" id="login" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-body">
                            <div class="column-left">
                                <div class="login-wrpper">
                                    <h4 class="title title-small no_after mb-0">Login</h4>
                                    <div class="comments-form">
                                        <form name="login" method="POST" action="PLACEORDER.php?action=login">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="single-form">
                                                        <input type="text" name="USERNAME" placeholder="Your Username">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="single-form">
                                                        <input type="password" name="PASS" placeholder="Your Password">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="single-form d-flex justify-content-between submit_lost-password">
                                                        <input type="submit" value="login" id="login1">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <a href="#" class="lost-password">Lost your password?</a>

                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <div class="column-right">
                                <div class="not-member">
                                    <h4 class="title title-small no_after text_white mb-0">Not a member?</h4>
                                    <span class="subtitle text_white mt-3">To keep connected with us please
            login with your personal info.</span>
                                    <a href="#" class="load-more primary_dark_btn mt-4" data-dismiss="modal"
                                       data-bs-toggle="modal" data-bs-target="#register">Create an account</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade login" id="register" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-body">
                            <div class="column-right">
                                <div class="not-member">
                                    <h4 class="title title-small no_after text_white mb-0">Welcome Back!</h4>
                                    <span class="subtitle text_white mt-3">To keep connected with us please
            login your personal info.</span> <a href="#" class="load-more primary_dark_btn mt-4" data-bs-toggle="modal"
                                                data-bs-target="#login">Login</a></div>
                            </div>
                            <div class="column-left">
                                <div class="login-wrpper">
                                    <h4 class="title title-small no_after mb-0">Create an account</h4>
                                    <div class="comments-form">
                                        <form name="signup" method="POST" action="PLACEORDER.php?action=signup"
                                              onsubmit="return CHECK();">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="single-form">
                                            <span class="required error"
                                                  id="USERNAME-info"></span>
                                                        <input type="text" placeholder="Username" name="USERNAME"
                                                               id="USERNAME">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="single-form">
                                             <span class="required error"
                                                   id="PASS-info"></span>
                                                        <input type="password" name="PASS" value=""
                                                               placeholder="What is your password?"
                                                               id="PASS">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="single-form">
                                             <span class="required error"
                                                   id="CFPASS-info"></span>
                                                        <input type="password" name="CFPASS" value=""
                                                               placeholder="Confirm your password?"
                                                               id="CFPASS">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="single-form">
                                             <span class="required error"
                                                   id="EMAIL-info"></span>
                                                        <input type="text" name="EMAIL" value=""
                                                               placeholder="What is your email?"
                                                               id="EMAIL">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="single-form">
                                            <span class="required error"
                                                  id="PHONE-info"></span>
                                                        <input type="text" name="PHONE" value=""
                                                               placeholder="What is your phone number?"
                                                               id="PHONE">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <p>By registering, you agree to Rosie Store's terms of service & privacy policy</p>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="single-form d-flex justify-content-between submit_lost-password">
                                                        <input type="submit" value="signup" id="login2">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            $username=$_SESSION['USERNAME'];
            $query4="select * from USERS where USERNAME=?";
            $param4=[$username];
            $stmt4=$dao->DMLParam($query4,$param4);
            $row4=$stmt4->fetch(PDO::FETCH_ASSOC);
            $phone=$row4['PHONE'];
            ?>
            <h3>Order Information</h3>
            <div class="checkout-wrapper mt-0">

                <div class="row">
                    <div class="col-lg-6">
                        <!-- Cart Start -->
                        <div class="cart-wrapper">
                            <div class="cart-table table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="product-name" colspan="2">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="">Quantity</th>
                                        <th class="product-subtotal">Total</th>
                                    </tr>
                                    </thead>
                                    <?php
                                    $subtotal = 0;
                                    foreach ($cart as $IDPR => $value):
                                        $NAMEPR = $value['NAMEPR'];
                                        $PRICE = $value['NEWPRICE'];
                                        $QUANTITY = $value['QUANTITY'];
                                        $subtotal += ($PRICE * $QUANTITY);
                                        ?>
                                        <tbody>
                                        <tr>
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
                                            <td class=" product-price subtotal
                                                        ">
                                                <div class="product-price"><span
                                                            class="sale-price text_dark"><?= $QUANTITY ?></span>
                                                </div>
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

                                        <td class="product-name"><h5>SubTotal</h5></td>

                                        <td class="product-price subtotal"></td>
                                        <td></td>
                                        <td class="product-price">
                                            <div class="product-price"><span
                                                        class="sale-price"><strong><?= number_format($subtotal) ?></strong></span>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-6">
                        <form action="PLACEORDER.php?action=order" method="post" onsubmit="return abc();">
                            <div class="checkout-order">
                                <div class="checkout-title">
                                    <h4 class="title no_after">Delivery Information</h4>
                                </div>
                                <div class="checkout-order-table table-responsive">

                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <span  class="required error" id="FULLNAME-info"></span>
                                            <td class="product-name"><p class="text-uppercase">Name:</p></td>

                                            <td class="product-price"><input type="text" name="FULLNAME" id="FULLNAME" style="width: 100%"></td>
                                        </tr>
                                        </tbody>
                                        <tbody>
                                        <tr>
                                            <td class="product-name"><p class="text-uppercase">Phone:</p></td>
                                            <td class="product-price"><input type="text" name="PHONE" style="width: 100%">
                                                <input type="hidden" name="phone" value="<?=$phone?>">
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tbody>
                                        <tr>
                                            <span  class="required error" id="ADDRESS-info"></span>
                                            <td class="product-name"><p class="text-uppercase">Address:</p></td>
                                            <td class="product-price"><input type="text" name="ADDRESS" id="ADDRESS" style="width: 100%"></td>
                                        </tr>
                                        <tr>
                                            <td class="product-name"><p class="text-uppercase">Note:</p></td>
                                            <td class="product-price"><textarea name="NOTE" style="width: 100%"></textarea></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <div class="d-flex">
                                        <div class="shipp"></div>
                                    </div>
                                </div>
                                <div class="checkout-payment">
                                    <div class="checkout-btn ">
                                        <button type="submit" name="order" VALUE="order">Proceed
                                            to
                                            Checkout
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
            <?php
        }
        ?>
    </div>
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

<?php
session_start();
include("../DAO/DaoDatabase.php");
$dao = new DaoDatabase();

use PHPMailer\PHPMailer\PHPMailer;

require_once 'PHPMailer\Exception.php';
require_once 'PHPMailer\PHPMailer.php';
require_once 'PHPMailer\SMTP.php';

$mail = new PHPMailer(true);

$alert = '';

if (isset($_SESSION['USERNAME'])) {
    if ($_SESSION['USERNAME'] != 'admin') {
        $username = $_SESSION['USERNAME'];
    } else {
        header("Location:ADMIN.php");
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
                <li class="breadcrumb-item active" style="color:#ffb6c1 ">My account</li>
            </ul>
        </div>
    </div>
</div>
<!-- page-banner End -->


<div class="section section-padding-04 section-padding-03">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <!-- My Account Menu Start -->
                <div class="my-account-menu mt-6" id="abc">
                    <ul class="nav account-menu-list flex-column">
                        <li><a class="active" data-bs-toggle="pill" href="#pills-dashboard"><i
                                        class="flaticon-id-card"></i> My Order</a></li>
                        <li><a data-bs-toggle="pill" href="#pills-account"><i class="flaticon-account"></i> Account
                                Details</a></li>
                        <li><a href="logout.php"><i class="flaticon-power-button-1"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <!-- Tab content start -->
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['changepass'])):
                        $PASS = $_POST['PASS'];
                        $NEWPASS = $_POST['NEWPASS'];
                        $query = "select * from USERS
                        where ( USERNAME = ? )";
                        $param = [
                            $username
                        ];
                        $stmt = $dao->DMLParam($query, $param);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        $pass = $row['PASS'];
                        if ($pass === $PASS) {
                            $query1 = "update USERS set PASS=?
                            where ( USERNAME = ? )";
                            $param1 = [
                                $NEWPASS, $username
                            ];
                            $stmt1 = $dao->DMLParam($query1, $param1);
                            ?>
                            <div id="showmess"><h5>Change Password successfully</h5></div>
                            <?php
                        } else {
                            ?>
                            <div id="showmess"><h5>Current password not match, kindly re-input</h5></div>
                            <?php
                        }
                    endif;
                    if (isset($_POST['changephone'])):
                        $PHONE = $_POST['PHONE'];
                        $NEWPHONE = $_POST['NEWPHONE'];
                        $query = "select PHONE from USERS
                        where ( PHONE = ? )";
                        $param = [
                            $NEWPHONE
                        ];
                        $stmt = $dao->DMLParam($query, $param);
                        if ($stmt->rowCount() == 0) {
                            $query = "update USERS set PHONE=?
                        where ( USERNAME = ? )";
                            $param = [
                                $NEWPHONE, $username
                            ];
                            $stmt = $dao->DMLParam($query, $param);
                            ?>
                            <div id="showmess"><h5>Reset Phone number successfully</h5></div>

                            <?php
                        } else {
                            ?>
                            <div id="showmess"><h5>Reset Phone number failed due phone number is already in the
                                    system</h5>
                            </div>
                            <?php
                        }

                    endif;
                    if (isset($_POST['changeemail'])):
                        // đầu tiên kiểm tra xem email này có trong database chưa
                        $EMAIL = $_POST['EMAIL'];
                        $NEWEMAIL = $_POST['NEWEMAIL'];
                        $query = "select USERNAME from USERS where ( EMAIL = ? )";
                        $param = [
                            $NEWEMAIL
                        ];
                        $stmt = $dao->DMLParam($query, $param);
                        // nếu chưa tồn tại thì mới cho đổi
                        if ($stmt->rowCount() == 0) {
                            $query10="EXEC del_verified_time ";
                            $stmt10=$dao->DML($query10);
                            // đầu tiên kiểm tra xem đã vedifi chưa
                            $query2 = "select  count(USERNAME) as countuser from verified_action
                        where ( USERNAME=? )";
                            $param2 = [
                                $username
                            ];
                            $stmt2 = $dao->DMLParam($query2, $param2);
                            // nếu chưa thì cho vedifine
                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                            $countuser = $row2['countuser'];
                            //nếu chưa vedifi thì đổi
                            if ($countuser == 0) {
                                $verificationCode = md5(uniqid(mt_rand(), true));
                                $verificationLink = "http://localhost:8008/ROSIESTORE/PUPLIC/activate.php?code=" . $verificationCode;
                                try {
                                    $mail->isSMTP();
                                    $mail->Host = 'smtp.gmail.com';
                                    $mail->SMTPAuth = true;
                                    $mail->Username = 'roisiestore.hcm@gmail.com'; // Gmail address which you want to use as SMTP server
                                    $mail->Password = 'roisiestore$1234'; // Gmail address Password
                                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                    $mail->Port = '587';

                                    $mail->setFrom('roisiestore.hcm@gmail.com', 'Roisie Store'); // Gmail address which you used as SMTP server
                                    $mail->addAddress($EMAIL); // Email address where you want to receive emails
                                    // (you can use any of your gmail address including the gmail address which you used as SMTP server)

                                    $mail->isHTML(true);
                                    $mail->Subject = 'Verification email from Roses Store ';
                                    $mail->Body = 'Dear <strong>' . $username . '</strong> <br/> <br/>

                                         Please click  <a href="' . $verificationLink . '">HERE</a> to verify your request: Change email address<br/>
                                         
                                         if not you? Please ignore this email .<br/>
                                         
                                         Best Regards<br/>
                                         Rosie Store.
                                            
                                            ';
                                    $mail->send();

                                    $alert = "A verification email were sent to <i>" . $EMAIL . "</i>, please open your email inbox and click the given link so you can change email";
                                    $query1 = "insert into verified_action(USERNAME,NEWINFO,verification_code) values (?,?,?) ";
                                    $param1 = [ $username , $NEWEMAIL, $verificationCode];
                                    $stmt1 = $dao->DMLParam($query1, $param1);

                                    ?>
                                    <div id="showmess"><h5><?= $alert; ?></h5></div>
                                    <?php


                                } catch (Exception $e) {
                                    $alert = '<div class="alert-danger">
                                    <span>' . $e->getMessage() . '</span>
                                  </div>';
                                }
                            }
                            // nếu rồi thì check coi có cookie nào như vậy hay ko
                            if ($countuser > 0) {
                                $query10="EXEC del_verified_time ";
                                $stmt10=$dao->DML($query10);
                                $alert = "Please wait 5 minutes to request reset email account";
                                ?>
                                    <div id="showmess"><h5><?= $alert; ?></h5></div>
                                    <?php
                            }
                        } else {
                            ?>
                            <div id="showmess"><h5>Reset email failed due email is already in the system </h5></div>
                            <?php
                        }
                    endif;
                }
                ?>
                <div class="tab-content my-account-tab" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-dashboard">
                        <div class="my-account-order account-wrapper mt-6">
                            <div class="widget-item">
                                <div class="product-details-tabs widget-link">
                                    <ul class="ps-0">
                                        <?php
                                        $query = "select COUNT (IDIV) as total 
                                        from ORDERS 
                                        where (USERNAME=? ) ";
                                        $param = [$username];
                                        $stmt = $dao->DMLParam($query, $param);
                                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $total_records = $row['total'];
                                        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                                        $limit = 10;// số item hiển thị trên 1 trang
                                        $total_page = ceil($total_records / $limit);
                                        if ($current_page > $total_page) {
                                            $current_page = $total_page;
                                        } else if ($current_page < 1) {
                                            $current_page = 1;
                                        }
                                        $start = (($current_page - 1) * $limit + 1);
                                        $end = ($start + $limit - 1);
                                        $query = "select * from ORDERS where USERNAME =?  order by CREATETIME  DESC ";
                                        $param = [$username];
                                        $stmt = $dao->DMLParam($query, $param);
                                        if ($stmt->rowCount() == 0) {
                                            ?>
                                            <h6>Oh! You have not any orders.<a href="HOME.php" style="color:#ffb6c1 ">Click
                                                    here</a> to start our web shopping experience</h6>
                                            <?php
                                        }
                                        else {
                                            if (isset($_GET['search'])) {
                                                $query = "select count (P.IDPR) as total from PRODUCT P
                                                inner join details_ORDERS d on P.IDPR = d.IDPR
                                                inner join ORDERS O on d.IDIV = O.IDIV
                             
                                                inner join BRAND B on B.IDBR = P.IDBR
                                                inner join CATEGORY C on C.IDCTGR = P.IDCTGR
                                                where USERNAME=? and concat(d.IDPR,NAMEPR,NAMEBR,NAMECTGR)LIKE ? collate SQL_Latin1_General_CP1_CI_AI
                                                ";
                                                $param = [$username, "%{$_GET['search']}%"];
                                                $stmt = $dao->DMLParam($query, $param);
                                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                $total_records = $row['total'];
                                                $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                                                $limit = 10;// số item hiển thị trên 1 trang
                                                $total_page = ceil($total_records / $limit);
                                                if ($current_page > $total_page) {
                                                    $current_page = $total_page;
                                                } else if ($current_page < 1) {
                                                    $current_page = 1;
                                                }
                                                $start = (($current_page - 1) * $limit + 1);
                                                $end = ($start + $limit - 1);
                                                if ($total_records != 0) {
                                                    ?>

                                                    <h4 class="account-title">My orders </h4>
                                                    <div class="header-top-search">
                                                        <form method="get" action="USER.php">
                                                            <input type="text" name="search"
                                                                   placeholder="Search here......">
                                                            <button type="submit" value="search"><i
                                                                        class="flaticon-search"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <?php
                                                    $query2 = "select tem.IDIV as IDIV,tem.STTO
                                                            from (select *, ROW_NUMBER() OVER (ORDER BY IDPR DESC) as rownum
                                                             from (select *
                                                            from (select  P.IDPR AS IDPR,NAMEBR,NAMECTGR,FULLNAME,ADDDRESS,PHONE,O.IDIV AS IDIV,STTO,CREATETIME,SUBPAID,O.CFBY as CFBY
                                                            from PRODUCT P
                                                            inner join details_ORDERS d on P.IDPR = d.IDPR                                                
                                                             inner join ORDERS O on d.IDIV = O.IDIV                                               
                                                            inner join IMAGES I on P.IDPR = I.IDPR                                                 
                                                            inner join BRAND B on B.IDBR = P.IDBR                                                
                                                            inner join CATEGORY C on C.IDCTGR = P.IDCTGR                                                
                                                            where USERNAME=? and concat(d.IDPR,NAMEPR,NAMEBR,NAMECTGR,FULLNAME,ADDDRESS,PHONE ) collate SQL_Latin1_General_CP1_CI_AI LIKE ? 
                                                            collate SQL_Latin1_General_CP1_CI_AI  
                                                            group by P.IDPR,NAMEBR,NAMECTGR,FULLNAME,ADDDRESS,PHONE,O.IDIV ,STTO,CREATETIME,SUBPAID,CFBY) 
                                                            as t)  as t1)as tem
                                                            where tem.rownum between $start and $end 
                                                            group by IDIV,tem.STTO
                                                            order by tem.STTO ASC  ";
                                                    $param2 = [$username, "%{$_GET['search']}%"];
                                                    $stmt2 = $dao->DMLParam($query2, $param2);
                                                    while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)):
                                                        $IDIV=$row2['IDIV'];
                                                        $query1="select * from ORDERS where IDIV=?";
                                                        $param1=[$IDIV];
                                                        $stmt1 = $dao->DMLParam($query1, $param1);
                                                        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                                                        $STTO = $row1['STTO'];
                                                        $IDIV = $row1['IDIV'];
                                                        ?>

                                                        <li class="account-table"><a href="#">Order No <?= $IDIV ?>
                                                                <div class="category-toggle collapsed"
                                                                     data-bs-toggle="collapse"
                                                                     data-bs-target="#HD<?= $IDIV ?>"><span class="add"><i
                                                                                class="fa fa-angle-down"></i></span>
                                                                    <span
                                                                            class="remove"><i
                                                                                class="fa fa-angle-up"></i></span></div>
                                                                <div class="collapse" id="HD<?= $IDIV ?>">
                                                                    <div class="product-anotherinfo-wrapper">
                                                                        <div class="row">
                                                                            <div class="col-md-3 ">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0 test">Name</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0"><?= $row1['FULLNAME'] ?></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-3 ">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0 test">Phone</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0"><?= $row1['PHONE'] ?></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-3">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0 test">Address</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0"><?= $row1['ADDDRESS'] ?></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-3">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0 test">Create
                                                                                        time</label>

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0"><?= $row1['CREATETIME'] ?></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-3">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0 test">Sub
                                                                                        Total</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0">VND <?= $row1['SUBPAID'] ?></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-3">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0 test">STATUS</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0" style="WIDTH: 9rem;">
                                                                                        <?php
                                                                                        if ($STTO == 1) {
                                                                                            echo '<i style="color: green;">Confirm</i>';
                                                                                        }
                                                                                        if ($STTO == 0) {
                                                                                            echo '<i style="color: orange;WIDTH: 9rem;">Waiting Confirm</i>';
                                                                                        }
                                                                                        if ($STTO == 2) {
                                                                                            echo '<i style="color: red;WIDTH: 9rem;">Cancel by' . ' ' . $row['CFBY'] . '</i>';
                                                                                        }
                                                                                        ?></label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="single-form test">
                                                                                    <label class="form-label mt-0 test" style="WIDTH: 9rem;"> <?php
                                                                                        if ($STTO == 0) {
                                                                                            ?>
                                                                                            <a href="./cancelorder.php?IDIV=<?= $IDIV ?>"
                                                                                               style="color: red;WIDTH: 9rem;">Cancel</a>

                                                                                            <?php
                                                                                        }

                                                                                        ?></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-3">
                                                                                <div class="single-form test">
                                                                                    <label class="form-label mt-0 test"><a
                                                                                                href="./SHOWORDER.php?IDIV=<?= $IDIV ?>"
                                                                                                style="color: green;padding: 0px"
                                                                                                class="test">View
                                                                                            </a></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                        </li>
                                                    <?php
                                                    endwhile;
                                                    ?>
                                                    <div class="pagination">
                                                        <nav aria-label="Page navigation example">
                                                            <ul class="pagination">
                                                                <?php
                                                                if (($current_page > 1) && ($total_page > 1)) {
                                                                    echo '<li class="page-item" style="margin-right: 5px;" ><a class="page-link " href="USER.php?search='.$_GET['search'].'&page=' . ($current_page - 1) . '" style="background-color:#ffb6c1;border-color: #ffb6c1;padding-left: 0px">Prev</a></li> ';

                                                                }
                                                                // Lặp khoảng giữa
                                                                for ($i = 1; $i <= $total_page; $i++) {
                                                                    // Nếu là trang hiện tại thì hiển thị thẻ span
                                                                    // ngược lại hiển thị thẻ a
                                                                    if ($i == $current_page) {
                                                                        echo '<li class="page-item active" style="margin-right: 5px;">
                                              <span class="page-link" STYLE="background-color:#ffb6c1;border-color: #ffb6c1 ">' . $i . '<span class="sr-only">(current)</span>
                                              </span>
                                            </li>';
                                                                    } else {
                                                                        echo ' <li class="page-item " aria-current="page" style="margin-right: 5px;">
    <a class="page-link "<a href="USER.php?search='.$_GET['search'].'&page=' . $i . '" style="background-color:#ffb6c1;border-color: #ffb6c1;padding-left: 0px" >' . $i . '</a></li> ';
                                                                    }
                                                                }

                                                                // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
                                                                if ($current_page < $total_page && $total_page > 1) {
                                                                    echo '<li class="page-item" ><a class="page-link "<a href="USER.php?search='.$_GET['search'].'&page=' . ($current_page + 1) . '" style="background-color:#ffb6c1;border-color: #ffb6c1;padding-left: 0px">Next</a> </li> ';
                                                                }
                                                                ?>
                                                            </ul>
                                                        </nav>
                                                    </div>
                                                    <?php
                                                }
                                                else {
                                                    ?>
                                                    <h6 class="abc">We're sorry, there are no results for
                                                        your search</h6>
                                                    <?php
                                                    $query = "select COUNT (IDIV) as total 
                                                    from ORDERS 
                                                    where (USERNAME=? ) ";
                                                    $param = [$username];
                                                    $stmt = $dao->DMLParam($query, $param);
                                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                    $total_records = $row['total'];
                                                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                                                    $limit = 10;// số item hiển thị trên 1 trang
                                                    $total_page = ceil($total_records / $limit);
                                                    if ($current_page > $total_page) {
                                                        $current_page = $total_page;
                                                    } else if ($current_page < 1) {
                                                        $current_page = 1;
                                                    }
                                                    $start = (($current_page - 1) * $limit + 1);
                                                    $end = ($start + $limit - 1);
                                                    $query = "select *
                                                    from (select *, ROW_NUMBER() OVER (ORDER BY IDIV DESC) as rownum
                                                           from (select *
                                                        from (select * from ORDERS where USERNAME =? ) as t)  as t1)as tem 
                                                           where tem.rownum between $start and $end       
                                                            order by tem.STTO ASC ";
                                                    $param = [$username];
                                                    $stmt = $dao->DMLParam($query, $param);
                                                    ?>
                                                    <h4 class="account-title">My orders </h4>
                                                    <div class="header-top-search">
                                                        <form method="get" action="USER.php">
                                                            <input type="text" name="search"
                                                                   placeholder="Search here......">
                                                            <button type="submit" value="search"><i
                                                                        class="flaticon-search"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                        <?php
                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                                            $STTO = $row['STTO'];
                                                            $IDIV = $row['IDIV'];
                                                            ?>

                                                            <li class="account-table"><a href="#">Order No <?= $IDIV ?>
                                                                    <div class="category-toggle collapsed"
                                                                         data-bs-toggle="collapse"
                                                                         data-bs-target="#HD<?= $IDIV ?>"><span class="add"><i
                                                                                    class="fa fa-angle-down"></i></span>
                                                                        <span
                                                                                class="remove"><i
                                                                                    class="fa fa-angle-up"></i></span></div>
                                                                    <div class="collapse" id="HD<?= $IDIV ?>">
                                                                        <div class="product-anotherinfo-wrapper">
                                                                            <div class="row">
                                                                                <div class="col-md-3 ">
                                                                                    <div class="single-form">
                                                                                        <label class="form-label mt-0 test">Name</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-9">
                                                                                    <div class="single-form">
                                                                                        <label class="form-label mt-0"><?= $row['FULLNAME'] ?></label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-3 ">
                                                                                    <div class="single-form">
                                                                                        <label class="form-label mt-0 test">Phone</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-9">
                                                                                    <div class="single-form">
                                                                                        <label class="form-label mt-0"><?= $row['PHONE'] ?></label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    <div class="single-form">
                                                                                        <label class="form-label mt-0 test">Address</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-9">
                                                                                    <div class="single-form">
                                                                                        <label class="form-label mt-0"><?= $row['ADDDRESS'] ?></label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    <div class="single-form">
                                                                                        <label class="form-label mt-0 test">Create
                                                                                            time</label>

                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-9">
                                                                                    <div class="single-form">
                                                                                        <label class="form-label mt-0"><?= $row['CREATETIME'] ?></label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    <div class="single-form">
                                                                                        <label class="form-label mt-0 test">Sub
                                                                                            Total</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-9">
                                                                                    <div class="single-form">
                                                                                        <label class="form-label mt-0">VND <?= $row['SUBPAID'] ?></label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    <div class="single-form">
                                                                                        <label class="form-label mt-0 test">STATUS</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="single-form">
                                                                                        <label class="form-label mt-0" style="WIDTH: 9rem;">
                                                                                            <?php
                                                                                            if ($row['STTO'] == 1) {
                                                                                                echo '<i style="color: green;WIDTH: 9rem;">Confirm</i>';
                                                                                            }
                                                                                            if ($row['STTO'] == 0) {
                                                                                                echo '<i style="color: orange;WIDTH: 9rem;">Waiting Confirm</i>';
                                                                                            }
                                                                                            if ($row['STTO'] == 2) {
                                                                                                echo '<i style="color: red;WIDTH: 9rem;">Cancel by' . ' ' . $row['CFBY'] . '</i>';
                                                                                            }
                                                                                            ?></label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="single-form test" >
                                                                                        <label class="form-label mt-0 test" style="WIDTH: 9rem;"> <?php
                                                                                            if ($row['STTO'] == 0) {
                                                                                                ?>
                                                                                                <a href="./cancelorder.php?IDIV=<?= $IDIV ?>"
                                                                                                   style="color: red;WIDTH: 9rem;">Cancel
                                                                                                    Order</a>
                                                                                                <?php
                                                                                            }

                                                                                            ?></label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    <div class="single-form test">
                                                                                        <label class="form-label mt-0 test"><a
                                                                                                    href="./SHOWORDER.php?IDIV=<?= $IDIV ?>"
                                                                                                    style="color: green;padding: 0px"
                                                                                                    class="test">View
                                                                                                Order</a></label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                            </li>
                                                        <?php
                                                        endwhile;
                                                        ?>
                                                    <div class="pagination">
                                                        <nav aria-label="Page navigation example">
                                                            <ul class="pagination">
                                                                <?php
                                                                if (($current_page > 1) && ($total_page > 1)) {
                                                                    echo '<li class="page-item" style="margin-right: 5px;" ><a class="page-link " href="USER.php?page=' . ($current_page - 1) . '" style="background-color:#ffb6c1;border-color: #ffb6c1;padding-left: 0px">Prev</a></li> ';

                                                                }
                                                                // Lặp khoảng giữa
                                                                for ($i = 1; $i <= $total_page; $i++) {
                                                                    // Nếu là trang hiện tại thì hiển thị thẻ span
                                                                    // ngược lại hiển thị thẻ a
                                                                    if ($i == $current_page) {
                                                                        echo '<li class="page-item active" style="margin-right: 5px;">
                                              <span class="page-link" STYLE="background-color:#ffb6c1;border-color: #ffb6c1 ">' . $i . '<span class="sr-only">(current)</span>
                                              </span>
                                            </li>';
                                                                    } else {
                                                                        echo ' <li class="page-item " aria-current="page" style="margin-right: 5px;">
    <a class="page-link "<a href="USER.php?page=' . $i . '" style="background-color:#ffb6c1;border-color: #ffb6c1;padding-left: 0px" >' . $i . '</a></li> ';
                                                                    }
                                                                }

                                                                // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
                                                                if ($current_page < $total_page && $total_page > 1) {
                                                                    echo '<li class="page-item" ><a class="page-link "<a href="USER.php?page=' . ($current_page + 1) . '" style="background-color:#ffb6c1;border-color: #ffb6c1;padding-left: 0px">Next</a> </li> ';
                                                                }
                                                                ?>
                                                            </ul>
                                                        </nav>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            else {
                                                ?>
                                                <h4 class="account-title">My orders </h4>
                                                <div class="header-top-search">
                                                    <form method="get" action="USER.php">
                                                        <input type="text" name="search" placeholder="Search here......">
                                                        <button type="submit" value="search"><i
                                                                    class="flaticon-search"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                    <?php
                                                $query = "select COUNT (IDIV) as total 
                                                from ORDERS 
                                                where (USERNAME=? ) ";
                                                $param = [$username];
                                                $stmt = $dao->DMLParam($query, $param);
                                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                $total_records = $row['total'];
                                                $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                                                $limit = 10;// số item hiển thị trên 1 trang
                                                $total_page = ceil($total_records / $limit);
                                                if ($current_page > $total_page) {
                                                    $current_page = $total_page;
                                                } else if ($current_page < 1) {
                                                    $current_page = 1;
                                                }
                                                $start = (($current_page - 1) * $limit + 1);
                                                $end = ($start + $limit - 1);
                                                $query = "select *
                                                    from (select *, ROW_NUMBER() OVER (ORDER BY IDIV DESC) as rownum
                                                           from (select *
                                                        from (select * from ORDERS where USERNAME =? ) as t)  as t1)as tem 
                                                           where tem.rownum between $start and $end       
                                                            order by tem.STTO ASC ";
                                                $param = [$username];
                                                $stmt = $dao->DMLParam($query, $param);
                                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                                        $STTO = $row['STTO'];
                                                        $IDIV = $row['IDIV'];
                                                        ?>
                                                        <li class="account-table"><a href="#">Order No <?= $IDIV ?>
                                                                <div class="category-toggle collapsed"
                                                                     data-bs-toggle="collapse"
                                                                     data-bs-target="#HD<?= $IDIV ?>"><span class="add"><i
                                                                                class="fa fa-angle-down"></i></span> <span
                                                                            class="remove"><i
                                                                                class="fa fa-angle-up"></i></span></div>
                                                                <div class="collapse" id="HD<?= $IDIV ?>">
                                                                    <div class="product-anotherinfo-wrapper">
                                                                        <div class="row">
                                                                            <div class="col-md-3 ">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0 test">Name</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0"><?= $row['FULLNAME'] ?></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-3 ">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0 test">Phone</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0"><?= $row['PHONE'] ?></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-3">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0 test">Address</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0"><?= $row['ADDDRESS'] ?></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-3">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0 test">Create
                                                                                        time</label>

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0"><?= $row['CREATETIME'] ?></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-3">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0 test">Sub
                                                                                        Total</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0">VND <?= $row['SUBPAID'] ?></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-3">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0 test">STATUS</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="single-form">
                                                                                    <label class="form-label mt-0" style="WIDTH: 9rem;">
                                                                                        <?php
                                                                                        if ($row['STTO'] == 1) {
                                                                                            echo '<i style="color: green;WIDTH: 9rem;">Confirm</i>';
                                                                                        }
                                                                                        if ($row['STTO'] == 0) {
                                                                                            echo '<i style="color: orange;WIDTH: 9rem;">Waiting Confirm</i>';
                                                                                        }
                                                                                        if ($row['STTO'] == 2) {
                                                                                            echo '<i style="color: red;WIDTH: 9rem;">Cancel by' . ' ' . $row['CFBY'] . '</i>';
                                                                                        }
                                                                                        ?></label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <div class="single-form test">
                                                                                    <label class="form-label mt-0 test" style="WIDTH: 9rem;"> <?php
                                                                                        if ($row['STTO'] == 0) {
                                                                                            ?>
                                                                                            <a href="./cancelorder.php?IDIV=<?= $IDIV ?>"
                                                                                               style="color: red;WIDTH: 9rem;">Cancel
                                                                                                Order</a>
                                                                                            <?php
                                                                                        }

                                                                                        ?></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-3">
                                                                                <div class="single-form test">
                                                                                    <label class="form-label mt-0 test"><a
                                                                                                href="./SHOWORDER.php?IDIV=<?= $IDIV ?>"
                                                                                                style="color: green;padding: 0px"
                                                                                                class="test">View
                                                                                            Order</a></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                        </li>
                                                    <?php
                                                    endwhile;
                                                    ?>
                                                <div class="pagination">
                                                    <nav aria-label="Page navigation example">
                                                        <ul class="pagination">
                                                            <?php
                                                            if (($current_page > 1) && ($total_page > 1)) {
                                                                echo '<li class="page-item" style="margin-right: 5px;" ><a class="page-link " href="USER.php?page=' . ($current_page - 1) . '" style="background-color:#ffb6c1;border-color: #ffb6c1;padding-left: 0px">Prev</a></li> ';

                                                            }
                                                            // Lặp khoảng giữa
                                                            for ($i = 1; $i <= $total_page; $i++) {
                                                                // Nếu là trang hiện tại thì hiển thị thẻ span
                                                                // ngược lại hiển thị thẻ a
                                                                if ($i == $current_page) {
                                                                    echo '<li class="page-item active" style="margin-right: 5px;">
                                              <span class="page-link" STYLE="background-color:#ffb6c1;border-color: #ffb6c1 ">' . $i . '<span class="sr-only">(current)</span>
                                              </span>
                                            </li>';
                                                                } else {
                                                                    echo ' <li class="page-item " aria-current="page" style="margin-right: 5px;">
    <a class="page-link "<a href="USER.php?page=' . $i . '" style="background-color:#ffb6c1;border-color: #ffb6c1;padding-left: 0px" >' . $i . '</a></li> ';
                                                                }
                                                            }

                                                            // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
                                                            if ($current_page < $total_page && $total_page > 1) {
                                                                echo '<li class="page-item" ><a class="page-link "<a href="USER.php?page=' . ($current_page + 1) . '" style="background-color:#ffb6c1;border-color: #ffb6c1;padding-left: 0px">Next</a> </li> ';
                                                            }
                                                            ?>
                                                        </ul>
                                                    </nav>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-account">
                        <div class="my-account-address my-account-details account-wrapper mt-6">
                            <h4 class="account-title">Account Details</h4>
                            <?php
                            $query = "select * from USERS where USERNAME=?";
                            $param = [$username];
                            $stmt = $dao->DMLParam($query, $param);
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <div class="account-details">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="single-form">
                                            <label class="form-label mt-0">Username</label>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="single-form">
                                            <label class="form-label mt-0"><?= $username ?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="single-form">
                                            <label class="form-label mt-0">Pass</label>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="single-form">
                                            <label class="form-label mt-0">*********</label>
                                            <a href="#" class="action" data-bs-toggle="modal"
                                               data-bs-target="#changepass">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="single-form">
                                            <label class="form-label mt-0">Phone number</label>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="single-form">
                                            <label class="form-label mt-0"><?= $row['PHONE'] ?></label>
                                            <a href="#" class="action" data-bs-toggle="modal"
                                               data-bs-target="#changephone">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="single-form">
                                            <label class="form-label mt-0">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="single-form">
                                            <label class="form-label mt-0"><?= $row['EMAIL'] ?></label>
                                            <a href="#" class="action" data-bs-toggle="modal"
                                               data-bs-target="#changemail">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Tab content End -->
            </div>
        </div>
    </div>
</div>
<!-- My Account End -->

<div class="modal fade login" id="changepass" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="column-left">
                    <div class="login-wrpper">
                        <h4 class="title title-small no_after mb-0">Reset Password</h4>
                        <div class="comments-form">
                            <form name="signup" method="POST" action="" onsubmit="return CHECK();">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="single-form">
                                             <span class="required error"
                                                   id="PASS-info"></span>
                                            <input type="password" name="PASS" value="" placeholder="Current password?"
                                                   id="PASS">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form">
                                             <span class="required error"
                                                   id="NEWPASS-info"></span>
                                            <input type="password" name="NEWPASS" value="" placeholder="New password?"
                                                   id="NEWPASS">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form">
                                             <span class="required error"
                                                   id="CFPASS-info"></span>
                                            <input type="password" name="CFPASS" value=""
                                                   placeholder="Confirm new password?"
                                                   id="CFPASS">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="single-form d-flex justify-content-between submit_lost-password">
                                            <input type="submit" name="changepass" value="Reset Password"
                                                   STYLE="background-color: black;color: white">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="column-right">
                    <h4 class="title title-small no_after text_white mb-0">Care for your Skin, care for your beauty</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade login" id="changephone" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="column-left">
                    <div class="login-wrpper">
                        <h4 class="title title-small no_after mb-0">Reset Phone</h4>
                        <div class="comments-form">
                            <form name="signup" method="POST" action="" onsubmit="return CHECKPHONE();">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="single-form">
                                            <span class="required error"
                                                  id="PHONE-info"></span>
                                            <input type="text" name="PHONE" value=""
                                                   placeholder="What is your current phone number?"
                                                   id="PHONE">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form">
                                            <span class="required error"
                                                  id="NEWPHONE-info"></span>
                                            <input type="text" name="NEWPHONE" value=""
                                                   placeholder="What is your new phone number?"
                                                   id="NEWPHONE">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form d-flex justify-content-between submit_lost-password">
                                            <input type="submit" name="changephone" value="Reset Phone Number"
                                                   STYLE="background-color: black;color: white">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="column-right">
                    <h4 class="title title-small no_after text_white mb-0">Because your Skin deserves the best care</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade login" id="changemail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="height: 450px;">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="column-left">
                    <div class="login-wrpper">
                        <h4 class="title title-small no_after mb-0">Reset Email</h4>
                        <div class="comments-form">
                            <form name="signup" method="POST" action="" onsubmit="return CHECKEMAIL();">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="single-form">
                                             <span class="required error"
                                                   id="EMAIL-info"></span>
                                            <input type="text" name="EMAIL" value=""
                                                   placeholder="What is your current email?"
                                                   id="EMAIL">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form">
                                             <span class="required error"
                                                   id="NEWEMAIL-info"></span>
                                            <input type="text" name="NEWEMAIL" value=""
                                                   placeholder="What is your new email?"
                                                   id="NEWEMAIL">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="single-form d-flex justify-content-between submit_lost-password">
                                            <input type="submit" name="changeemail" value="Reset Email"
                                                   STYLE="background-color: black;color: white">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="column-right">
                    <h4 class="title title-small no_after text_white mb-0">Be yourself more, do care more</h4>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="../JS/XUAN_JS/USER.js"></script>
<script src="../JS/bootstrap.bundle.min.js"></script>
<script src="../JS/jquery-2.2.4.js"></script>
<script src="../CSS/vendors/owlcarousel/owl.carousel.min.js"></script>
<script src="../CSS/vendors/lightGallery/js/lightgallery.min.js"></script>
<script src="../CSS/vendors/lightGallery/js/lg-thumbnail.min.js"></script>
<script src="../CSS/vendors/lightGallery/js/lg-fullscreen.min.js"></script>
<script src="../CSS/vendors/slick/slick.min.js"></script>

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
</body>
</html>

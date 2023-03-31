<?php
session_start();
include("../DAO/DaoDatabase.php");
$dao = new DaoDatabase();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "update USERS set PASS =?, EMAIL =?, PHONE =?
                where USERNAME =?";
    $param = [
        $_POST['PASS'],
        $_POST['EMAIL'],
        $_POST['PHONE'],
        $_GET['USERNAME']
    ];
    $dao->DMLParam($query, $param);
    header("Location:ADMIN_UPDATE.php");
} else {
    if (isset($_GET['USERNAME'])) {
        $query = "select * from USERS where USERNAME=?";
        $param = [
            $_GET['USERNAME']
        ];
        $stmt = $dao->DMLParam($query, $param);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location:ADMIN_UPDATE.php");
    }
}
?>

<!doctype html>
<html lang="en">
<head>
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
    <title>Update Account</title>
</head>
<body>
<div class="page-banner blog-page-banner section">
    <div class="container">
        <div class="page-banner-wrapper text-center">
            <h2 class="page-title">Admin Page</h2>
            <ul class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="HOME.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active">Admin</li>
            </ul>
        </div>
    </div>
</div>
<!-- page-banner End -->
<div class="section section-padding-04 section-padding-03">
    <div class="container-admin">
        <div class="row">
            <div class="col-lg-2 col-md-3">
                <!-- My Account Menu Start -->
                <div class="my-account-menu mt-6">
                    <ul class="nav account-menu-list flex-column">
                        <li><a href="ADMIN.php"><i class="flaticon-shield"></i> Dashboard</a></li>
                        <li><a class="active" data-bs-toggle="pill" href="#pills-account"><i
                                        class="flaticon-account"></i> My Profile</a></li>
                        <li><a href="USER_MANAGE.php"><i class="flaticon-user-1"></i> User Management</a></li>
                        <li><a href="ORD_MANAGE.php"><i class="flaticon-shopping-bag-3"></i> Orders Management</a></li>
                        <li><a href="PRO_MANAGE.php"><i class="flaticon-package-1"></i> Products</a></li>
                        <li><a href="PRO_INSERT.php"><i class="flaticon-package"></i> Insert Products</a></li>
                        <li><a href="IMG_INSERT.php"><i class="flaticon-id-card"></i> Insert Image & Color</a></li>
                        <li><a href="CATE_INSERT.php"><i class="flaticon-shield-1"></i> Category Management</a></li>
                        <li><a href="BRAND_INSERT.php"><i class="flaticon-credit-card-1"></i> Brand Management</a></li>
                        <li><a href="logout.php"><i class="flaticon-power-button-1"></i> Logout</a></li>
                    </ul>
                </div>
                <!-- My Account Menu End -->
            </div>
            <div class="col-lg-10 col-md-9">
                <!-- Tab content start -->
                <div class="tab-pane fade show active" id="pills-account">
                    <div class="my-product product-wrapper mt-6">
                        <h4 class="account-title">Edit Profile</h4>
                        <br/>
                        <div class="account-details">
                            <div class="row">
                                <form name="account-details" method="post">
                                    <div class="account-details">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="single-form">
                                                    <label class="form-label mt-0">Username</label>
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="single-form">
                                                    <input type="text" value="<?= $row['USERNAME'] ?>"
                                                           style="width: 20vw" name="USERNAME" id="USERNAME">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="single-form">
                                                    <label class="form-label mt-0">Password</label>
                                                </div>
                                            </div>

                                            <div class="col-md-10">
                                                <div class="single-form">
                                                    <input type="text" value="<?= $row['PASS'] ?>"
                                                           style="width: 20vw" name="PASS" id="PASS">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="single-form">
                                                    <label class="form-label mt-0">Phone number</label>
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="single-form">
                                                    <input type="text" value="<?= $row['PHONE'] ?>"
                                                           style="width: 20vw" name="PHONE" id="PHONE">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="single-form">
                                                    <label class="form-label mt-0">Email</label>
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="single-form">
                                                    <input type="text" value="<?= $row['EMAIL'] ?>"
                                                           style="width: 20vw" name="EMAIL" id="EMAIL">
                                                </div>
                                            </div>
                                            <div class="col-md-">
                                                <button type="submit" class="btn btn-danger">Update</button>
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
</div>


<!-- My Account End -->

<script src="../JS/XUAN_JS/USER.js"></script>
<script src="../JS/LAN_JS/CONTACT.js"></script>
<script src="../JS/bootstrap.bundle.min.js"></script>
<script src="../JS/jquery-2.2.4.js"></script>
<script src="../CSS/vendors/owlcarousel/owl.carousel.min.js"></script>
<script src="../JS/custom.js"></script>

</body>
</html>

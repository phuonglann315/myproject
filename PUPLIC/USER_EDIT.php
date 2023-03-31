<?php
session_start();
include("../dao/daoDatabase.php");
$dao = new daoDatabase();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "update USERS set PASS=?, EMAIL=?, PHONE=?, locktime=?, STTUSER=?
                where USERNAME =?";
    $param = [
        $_POST['PASS'],
        $_POST['EMAIL'],
        $_POST['PHONE'],
        $_POST['locktime'],
        $_POST['STTUSER'] ? 1 : 0,
        $_GET['USERNAME']
    ];
    $dao->DMLParam($query, $param);
    header("Location:USER_MANAGE.php");
} else {
    if (isset($_GET['USERNAME'])) {
        $query = "select * from USERS where USERNAME=?";
        $param = [
            $_GET['USERNAME']
        ];
        $stmt = $dao->DMLParam($query, $param);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location:USER_MANAGE.php");
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
    <title>Update Product</title>
</head>
<body>

<div class="page-banner blog-page-banner section">
    <div class="container">
        <div class="page-banner-wrapper text-center">
            <h2 class="page-title">Admin Page</h2>
            <ul class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="HOME.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="ADMIN.php"><i class="fa fa-address-card"></i> Admin</a></li>
                <li class="breadcrumb-item"><a href="USER_MANAGE.php"><i class="fa fa-address-card"></i> User Management</a></li>
                <li class="breadcrumb-item active">User Action</li>
            </ul>
        </div>
    </div>
</div>

<div class="section section-padding-04 section-padding-03">
    <div class="container-admin">
        <div class="row">
            <div class="col-lg-2 col-md-3">
                <!-- My Account Menu Start -->
                <div class="my-account-menu mt-6">
                    <ul class="nav account-menu-list flex-column">
                        <li><a href="ADMIN.php"><i class="flaticon-shield"></i>
                                Dashboard</a></li>
                        <li><a href="ADMIN_UPDATE.php"><i class="flaticon-account"></i> My Profile</a></li>
                        <li><a class="active" href="USER_MANAGE.php"><i class="flaticon-user-1"></i> User Management</a>
                        </li>
                        <li><a href="ORD_MANAGE.php"><i class="flaticon-shopping-bag-3"></i> My Profile</a></li>
                        <li><a href="PRO_MANAGE.php"><i class="flaticon-package-1"></i>Products</a></li>
                        <li><a href="PRO_INSERT.php"><i class="flaticon-package"></i>Insert Products</a></li>
                        <li><a href="IMG_INSERT.php"><i class="flaticon-id-card"></i>Insert Image & Color</a></li>
                        <li><a href="CATE_INSERT.php"><i class="flaticon-shield-1"></i> Category Management</a></li>
                        <li><a href="BRAND_INSERT.php"><i class="flaticon-credit-card-1"></i> Brand Management</a></li>
                        <li><a href="logout.php"><i class="flaticon-power-button-1"></i> Logout</a></li>
                    </ul>
                </div>
                <!-- My Account Menu End -->
            </div>
            <div class="col-lg-10 col-md-9">
                <div class="tab-content my-product-tab" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-user">
                        <div class="my-account-address my-account-details account-wrapper mt-6">
                            <!--                            <nav class="navbar navbar-light bg-light">-->
                            <form method="post" enctype="multipart/form-data">
                                <h4 class="account-title">Edit user</h4>
                                <div class="account-details">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label for="USERNAME" class="form-label mt-0">USERNAME</label>
                                                <p><?= $row['USERNAME']; ?></p>

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label class="form-label mt-0" for="PHONE">Phone</label>
                                                <p><?= $row['PHONE']; ?></p>

                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label class="form-label" for="EMAIL">EMAIL</label>
                                                <p><?= $row['EMAIL']; ?></p>

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single-form">
                                                <label class="form-label" for="locktime">Lock time</label>
                                                <input type="datetime" value="<?= $row['locktime']; ?>" name="locktime"
                                                       id="locktime">
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <input class="form-check" type="checkbox" name="STTUSER" id="STTUSER"
                                                <?= $row['STTUSER'] ? "checked" : ""; ?>>
                                        </div>
                                        <div class="col-md-">
                                            <label for="STTUSER" class="form-check-label">
                                                Status pro (check = Active, no check = Block)
                                            </label>
                                        </div>

                                        <div class="col-md-">
                                            <button type="submit" class="btn btn-danger">Edit</button>
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
<script src="../JS/LAN_JS/CONTACT.js"
<script src="../JS/bootstrap.bundle.min.js"></script>
<script src="../JS/jquery-2.2.4.js"></script>
<script src="../CSS/vendors/owlcarousel/owl.carousel.min.js"></script>
<script src="../JS/custom.js"></script>
</body>
</html>

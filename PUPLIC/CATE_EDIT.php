<?php
session_start();
include("../DAO/DaoDatabase.php");
$dao = new DaoDatabase();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "UPDATE CATEGORY SET NAMECTGR = ?, STTCT = ? WHERE IDCTGR = ?";
    $param = [
        $_POST['NAMECTGR'],
        $_POST['STTCT'] ? 1:0,
        $_GET['IDCTGR']
    ];
    $dao->DMLParam($query, $param);
    header("Location:CATE_INSERT.php");
} else {
    if (isset($_GET['IDCTGR'])) {
        $query = "select * from CATEGORY where IDCTGR=?";
        $param = [
            $_GET['IDCTGR']
        ];
        $stmt = $dao->DMLParam($query, $param);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location:CATE_INSERT.php");
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
    <title>Insert</title>
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
                        <li><a href="ADMIN.php"><i class="flaticon-shield"></i>Dashboard</a></li>
                        <li><a href="ADMIN_UPDATE.php"><i class="flaticon-account"></i> My Profile</a></li>
                        <li><a href="USER_MANAGE.php"><i class="flaticon-user-1"></i> User Management</a></li>
                        <li><a href="ORD_MANAGE.php"><i class="flaticon-shopping-bag-3"></i> Orders Management</a></li>
                        <li><a href="PRO_MANAGE.php"><i class="flaticon-package-1"></i> Products</a></li>
                        <li><a href="PRO_INSERT.php"><i class="flaticon-package"></i> Insert Products</a></li>
                        <li><a href="IMG_INSERT.php"><i class="flaticon-id-card"></i> Insert Image & Color</a></li>
                        <li><a href="CATE_INSERT.php"><i class="flaticon-shield-1"></i> Category Management</a></li>
                        <li><a class="active" href="#pills-insert-brand"><i class="flaticon-credit-card-1">
                                </i> Brand Management</a></li>
                        <li><a href="logout.php"><i class="flaticon-power-button-1"></i> Logout</a></li>
                    </ul>
                </div>
                <!-- My Account Menu End -->
            </div>
            <div class="col-lg-10 col-md-9">
                <!-- Tab content start -->
                <div class="tab-content my-product-tab" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-insert-brand">
                        <div class="my-account-address my-account-details account-wrapper mt-6">
                            <form method="POST" enctype="multipart/form-data">
                                <h4 class="account-title">Edit category</h4>
                                <div class="account-details">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label for="IDCTGR" class="form-label mt-0">ID CATEGORY</label>
                                                <input type="text" name="IDCTGR" id="IDCTGR"
                                                       value="<?= $row['IDCTGR']; ?>" disabled><br/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label class="form-label mt-0" for="NAMECTGR">Category</label>
                                                <input type="text" value="<?= $row['NAMECTGR']; ?>" name="NAMECTGR"
                                                       id="NAMECTGR">
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <input class="form-check" type="checkbox" name="STTCT" id="STTCT"
                                                <?= $row['STTCT'] ? "checked" : ""; ?>>
                                        </div>
                                        <div class="col-md-">
                                            <label for="STTCT" class="form-check-label">
                                                Status pro (check = Active, no check = Blocked)
                                            </label>
                                        </div>
                                        <div class="col-md-">
                                            <button type="submit" class="btn btn-danger">Update</button>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script src="../JS/bootstrap.bundle.min.js"></script>
            <script src="../JS/jquery-2.2.4.js"></script>
            <script src="../CSS/vendors/owlcarousel/owl.carousel.min.js"></script>
            <script src="../JS/custom.js"></script>
</body>
</html>



<?php
session_start();
include("../DAO/DaoDatabase.php");
$dao = new DaoDatabase();

if (isset($_SESSION['USERNAME'])) {
    if ($_SESSION['USERNAME'] === 'admin') {

    } else {
        header("Location:ADMIN.php");
    }
} else {
    header("Location:HOME.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_FILES['NAMEIM']['name'] != '') {
        move_uploaded_file($_FILES['NAMEIM']['tmp_name'], "../IMAGES/IMG_PRO/" . $_FILES['NAMEIM']['name']);
        $photo = $_FILES['NAMEIM']['name'];
    } else {
        echo '<script language="javascript">';
        echo 'alert(" Kindly choose file photo")';
        echo '</script>';

    }
    $query = "insert into IMAGES(IDPR, NAMEIM, COLOR, DETAILQUANTITY)
                                        values (?,?,?,?)";
    $param = [
        $_POST['IDPR'],
        $photo,
        $_POST['COLOR'],
        $_POST['DETAILQUANTITY'],
    ];
    $dao->DMLParam($query, $param);
    header("location:PRO_MANAGE.php");
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
    <title>ADMIN</title>
</head>
<body>
<div class="page-banner blog-page-banner section">
    <div class="container">
        <div class="page-banner-wrapper text-center">
            <h2 class="page-title">Admin Page</h2>
            <ul class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="HOME.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="ADMIN.php"><i class="fa fa-address-card"></i> Admin</a></li>
                <li class="breadcrumb-item"><a href="PRO_MANAGE.php"><i class="fa fa-product-hunt">All Product</i></a></li>
                <li class="breadcrumb-item active">Insert Images</li>
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
                        <li><a href="ADMIN.php"><i class="flaticon-shield"></i>
                                Dashboard</a></li>
                        <li><a href="ADMIN_UPDATE.php"><i class="flaticon-account"></i> My Profile</a></li>
                        <li><a href="USER_MANAGE.php"><i class="flaticon-user-1"></i> User Management</a>
                        </li>
                        <li><a href="ORD_MANAGE.php"><i class="flaticon-shopping-bag-3"></i> Orders Management</a></li>
                        <li><a href="PRO_MANAGE.php"><i class="flaticon-package-1"></i> Products</a></li>
                        <li><a href="PRO_INSERT.php"><i class="flaticon-package"></i> Insert Products</a></li>
                        <li><a class="active" href="#pills-insert-img">
                                <i class="flaticon-id-card"></i> Insert Image & Color</a></li>
                        <li><a href="CATE_INSERT.php"><i class="flaticon-shield-1"></i> Category Management</a></li>
                        <li><a href="BRAND_INSERT.php"><i class="flaticon-credit-card-1"></i> Brand Management</a></li>
                        <li><a href="logout.php"><i class="flaticon-power-button-1"></i> Logout</a></li>
                    </ul>
                </div>
                <!-- My Account Menu End -->
            </div>
            <div class="col-lg-10 col-md-9">
                <!-- Tab content start -->
                    <div class="tab-pane fade show active" id="pills-insert-img">
                        <div class="my-account-address my-account-details account-wrapper mt-6">
                            <form method="POST" enctype="multipart/form-data">
                                <h4 class="account-title">Insert Images & Color</h4>

                                <div class="col-md-6">
                                    <div class="single-form">
                                        <label class="form-label" for="IDPR">Product ID<span
                                                    class="required">*</span></label>
                                        <input type="text" name="IDPR" id="IDPR">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="single-form">
                                        <label class="form-label" for="NAMEIM">Images<span
                                                    class="required">*</span></label>
                                        <input type="file" id="NAMEIM" name='NAMEIM'>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="single-form">
                                        <label class="form-label" for="COLOR">Select your color:</label> <br/>
                                        <input type="color" id="COLOR" name="COLOR" style="padding: 0px">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="single-form">
                                        <label class="form-label" for="DETAILQUANTITY" min="0">Detail Quantity<span
                                                    class="required">*</span></label>
                                        <input type="number" min="0" name="DETAILQUANTITY" id="DETAILQUANTITY">
                                    </div>
                                </div>
                                <div class="col-md-">
                                    <button type="submit" class="btn btn-danger">Insert</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Tab content End -->
                </div>
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

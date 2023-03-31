<?php
session_start();
include("../dao/daoDatabase.php");
$dao = new daoDatabase();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_FILES['NAMEIM']['name'] != '') {
        move_uploaded_file($_FILES['NAMEIM']['tmp_name'], "../IMAGES/IMG_PRO/" . $_FILES['NAMEIM']['name']);
        $photo = $_FILES['NAMEIM']['name'];
    } else {
        $photo = $_POST['oldphoto'];
        }
        $color = $_POST['COLOR'];
        $quantity = $_POST['DETAILQUANTITY'];
        $IDIM =  $_GET['IDIM'];
        $query1 = "update IMAGES set NAMEIM =?, COLOR=?, DETAILQUANTITY=?
                                WHERE IDIM=?";
        $param1 = [
            $photo,
            $color,
            $quantity,
            $IDIM
        ];
        $stmt1 = $dao->DMLParam($query1, $param1);
        header("Location:PRO_MANAGE.php");

}
if (isset($_GET['IDIM'])) {
    $query1 = "select * from IMAGES where IDIM=?";
    $param1 = [
        $_GET['IDIM']
    ];
    $stmt1 = $dao->DMLParam($query1, $param1);
    $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location:PRO_MANAGE.php");
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
                <li class="breadcrumb-item"><a href="PRO_MANAGE.php"><i class="fa fa-product-hunt">All Product</i></a></li>
                <li class="breadcrumb-item active">Update Images</li>
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
                        <li><a href="USER_MANAGE.php"><i class="flaticon-user-1"></i> User Management</a>
                        </li>
                        <li><a href="ORD_MANAGE.php"><i class="flaticon-shopping-bag-3"></i> Orders Management</a></li>
                        <li><a class="active" data-bs-toggle="pill" href="#pills-product"><i
                                        class="flaticon-package-1"></i>
                                Products</a></li>
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
                    <div class="tab-pane fade show active" id="pills-product">
                        <div class="my-account-address my-account-details account-wrapper mt-6">
                            <form class="row g-5" method="post" enctype="multipart/form-data">
                                <h4 class="account-title">Update image</h4>
                                <div class="col-md-5">
                                    <div class="single-form">
                                        <label for="IDPR" class="form-label mt-0">ID product</label>
                                        <input type="text" name="IDPR" id="IDPR"
                                               value="<?= $row1['IDPR']; ?>" disabled><br/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="single-form">
                                        <label class="form-label" for="DETAILQUANTITY" min="0">Detail Quantity<span
                                                    class="required">*</span></label>
                                        <input type="number" value="<?= $row1['DETAILQUANTITY']; ?>" min="0"
                                               name="DETAILQUANTITY" id="DETAILQUANTITY">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="single-form">
                                        <label class="form-label" for="COLOR">Select your color:</label> <br/>
                                        <input type="color" id="COLOR" name="COLOR" value="<?= $row1['COLOR']; ?>"
                                               style="padding: 0px">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <img src="../IMAGES/IMG_PRO/<?= $row1["NAMEIM"]; ?>" width="200vh" id="NAMEIM"><br/><br/>
                                    <input type="hidden" name="oldphoto" value="<?= $row1["NAMEIM"]; ?>"><br/>
                                    <input type="file" name="NAMEIM" onchange="changePic();"><br/><br/>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-danger">Update</button>
                                </div>

                            </form>
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
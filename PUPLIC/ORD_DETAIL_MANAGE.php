<?php
session_start();
include("../dao/daoDatabase.php");
$dao = new daoDatabase();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "update ORDERS set STTO = ?,CFBY='ADMIN' where IDIV = ?";
    $param = [
        $_POST['STTO'],
        $_GET['IDIV']
    ];
    $dao->DMLParam($query, $param);
    header("Location:ORD_MANAGE.php");
} else {
    if (isset($_GET['IDIV'])) {
        $query = "select * from ORDERS where IDIV = ?";
        $param = [
            $_GET['IDIV']
        ];
        $stmt = $dao->DMLParam($query, $param);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location:ORD_MANAGE.php");
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
                <li class="breadcrumb-item active">Admin</li>
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
                        <li><a class="active" href="#pills-order"><i class="flaticon-shopping-bag-3"></i> Order Management</a>
                        </li>
                        <li><a href="PRO_MANAGE.php"><i class="flaticon-package-1"></i>Products</a></li>
                        <li><a href="PRO_INSERT.php"><i class="flaticon-package"></i>Insert Products</a></li>
                        <li><a href="IMG_INSERT.php"><i class="flaticon-id-card"></i>Insert Image & Color</a></li>
                        <li><a href="CATE_INSERT.php"><i class="flaticon-add-button"></i> Category Management</a></li>
                        <li><a href="BRAND_INSERT.php"><i class="flaticon-add-button"></i> Brand Management</a></li>
                        <li><a href="logout.php"><i class="flaticon-power-button-1"></i> Logout</a></li>
                    </ul>
                </div>
                <!-- My Account Menu End -->
            </div>
            <div class="col-lg-10 col-md-9">
                <!-- Tab content start -->
                <div class="tab-pane fade show active" id="pills-order">
                    <div class="my-product product-wrapper mt-6">
                        <h4 class="account-title">Detail Order</h4>
                        <br/>
                        <form name="detail_order" method="post">
                            <div class="account-details">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="single-form">
                                            <label class="form-label mt-0">ID Invoice</label>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="single-form">
                                            <label class="form-label mt-0"><?= $row['IDIV'] ?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="single-form">
                                            <label class="form-label mt-0">Username</label>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="single-form">
                                            <label class="form-label mt-0"><?= $row['USERNAME'] ?></label>
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
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="single-form">
                                            <label class="form-label mt-0">Fullname</label>
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="single-form">
                                            <label class="form-label mt-0"><?= $row['FULLNAME'] ?></label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="single-form">
                                            <label class="form-label mt-0">Address</label>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="single-form">
                                            <label class="form-label mt-0"><?= $row['ADDDRESS'] ?></label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="single-form">
                                            <label class="form-label mt-0">Create time</label>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="single-form">
                                            <label class="form-label mt-0"><?= $row['CREATETIME'] ?></label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="single-form">
                                            <label class="form-label mt-0">Total</label>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="single-form">
                                            <label class="form-label mt-0"><?= $row['SUBPAID'] ?></label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="single-form">
                                            <label class="form-label mt-0">Status</label>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="single-form">
                                            <?php
                                            if ($row['STTO']==0){
                                              ?>
                                                <select class="form-select1 " name="STTO" >
                                                    <option VALUE="0" selected>Waitting Confirm</option>
                                                    <option value="1">Confirm</option>
                                                    <option value="2">Cancel</option>
                                                </select>
                                            <?PHP
                                            }
                                            if ($row['STTO']==1){
                                              ?>
                                                <select class="form-select1 " name="STTO"  style="width: 30%">
                                                    <option VALUE="1" selected> Confirm</option>
                                                    <option value="0">Waitting Confirm</option>
                                                    <option value="2">Cancel</option>
                                                </select>
                                            <?PHP
                                            }
                                            if ($row['STTO']==2){
                                              ?>
                                                <select class="form-select1 " name="STTO" >
                                                    <option VALUE="2" selected> Cancel</option>
                                                    <option value="0">Waitting Confirm</option>
                                                    <option value="1"> Confirm</option>
                                                </select>
                                            <?PHP
                                            }
                                            ?>
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


<script src="../JS/bootstrap.bundle.min.js"></script>
<script src="../JS/jquery-2.2.4.js"></script>
<script src="../CSS/vendors/owlcarousel/owl.carousel.min.js"></script>
<script src="../JS/custom.js"></script>
</body>
</html>
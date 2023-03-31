<?php
session_start();
include("../dao/daoDatabase.php");
$dao = new daoDatabase();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "update PRODUCT set NAMEPR=?, IDBR =?, IDCTGR =?, PRICE =?, BRIEFSUM =?,
                DESCRIPTION =?, CREATEDATE =? , STATUSPRO =?
                where IDPR =?";
    $param = [
        $_POST['NAMEPR'],
        $_POST['IDBR'],
        $_POST['IDCTGR'],
        $_POST['PRICE'],
        $_POST['BRIEFSUM'],
        $_POST['DESCRIPTION'],
        $_POST['CREATEDATE'],
        $_POST['STATUSPRO'],
        $_GET['IDPR']
    ];
    $dao->DMLParam($query, $param);
    header("Location:PRO_MANAGE.php");
} else {
    if (isset($_GET['IDPR'])) {
        $query = "select * from PRODUCT where IDPR=?";
        $param = [
            $_GET['IDPR']
        ];
        $stmt = $dao->DMLParam($query, $param);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location:PRO_MANAGE.php");
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
                <li class="breadcrumb-item"><a href="PRO_MANAGE.php"><i class="fa fa-product-hunt">All Product</i><a></a></li>
                <li class="breadcrumb-item active">Product Update</li>
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
                            <!--                            <nav class="navbar navbar-light bg-light">-->
                            <form method="post" enctype="multipart/form-data">
                                <h4 class="account-title">Update item</h4>
                                <div class="account-details">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label for="IDPR" class="form-label mt-0">ID product</label>
                                                <input type="text" name="IDPR" id="IDPR"
                                                       value="<?= $row['IDPR']; ?>" disabled><br/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label class="form-label mt-0" for="NAMEPR">Product Name</label>
                                                <input type="text" value="<?= $row['NAMEPR']; ?>" name="NAMEPR"
                                                       id="NAMEPR">
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label class="form-label mt-0" for="IDBR">Brand<span
                                                            class="required">*</label>
                                                <select class="form-select" name="IDBR" id="IDBR">
                                                    <option selected
                                                            value="<?= $row['IDBR']; ?>"><?= $row['IDBR']; ?></option>
                                                    <?PHP
                                                    $query1 = "select * from BRAND";
                                                    $stmt1 = $dao->DML($query1);
                                                    while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)):
                                                        $IDBR = $row1['IDBR'];
                                                        $NAMEBR = $row1['NAMEBR'];
                                                        ?>
                                                        <option value="<?= $IDBR ?>"><?= $IDBR ?></option>
                                                    <?php
                                                    endwhile;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label class="form-label mt-0" for="IDCTGR">Category<span
                                                            class="required">*</label>
                                                <select class="form-select" name="IDCTGR" id="IDCTGR">
                                                    <option selected
                                                            value="<?= $row['IDCTGR']; ?>"><?= $row['IDCTGR']; ?></option>
                                                    <?PHP
                                                    $query2 = "select * from CATEGORY";
                                                    $stmt2 = $dao->DML($query2);
                                                    while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)):
                                                        $IDCTGR = $row2['IDCTGR'];
                                                        $NAMECTGR = $row2['NAMECTGR'];
                                                        ?>
                                                        <option value="<?= $IDCTGR ?>"><?= $IDCTGR ?></option>
                                                    <?php
                                                    endwhile;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label class="form-label" for="PRICE">Price<span
                                                            class="required">*</span></label>
                                                <input type="number" value="<?= $row['PRICE']; ?>" min="0" name="PRICE"
                                                       id="PRICE">
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <label class="form-label" for="description_pro">Brief Summary</label>
                                            <textarea class="form-control"
                                                      name="BRIEFSUM" id="BRIEFSUM"
                                                      style="width: 60vw; height: 10vh"><?= $row['BRIEFSUM']; ?></textarea>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label" for="description_pro">Description</label>
                                            <textarea class="form-control"
                                                      name="DESCRIPTION" id="DESCRIPTION"
                                                      style="width: 60vw; height: 40vh"><?= $row['DESCRIPTION']; ?></textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label class="form-label" for="CREATEDATE">Create Date<span
                                                            class="required">*</span></label>
                                                <input type="date" value="<?= $row['CREATEDATE']; ?>" name="CREATEDATE"
                                                       id="CREATEDATE">
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="col-md-12"></div>

                                        <div class="col-sm-1">
                                            <input class="form-check" type="checkbox" name="STATUSPRO" id="STATUSPRO"
                                                <?= $row['STATUSPRO'] ? "checked" : ""; ?>>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="STATUSPRO" class="form-check-label">
                                                Status pro (check = In stock, no check = Out of stock)
                                            </label>
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

        <script src="../JS/LAN_JS/CONTACT.js"
        <script src="../JS/bootstrap.bundle.min.js"></script>
        <script src="../JS/jquery-2.2.4.js"></script>
        <script src="../CSS/vendors/owlcarousel/owl.carousel.min.js"></script>
        <script src="../JS/custom.js"></script>
</body>
</html>
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
    $query = "INSERT INTO CATEGORY (IDCTGR,NAMECTGR) VALUES ('str',?)";
    $param = [
            $_POST['NAMECTGR']
    ];
    $dao->DMLParam($query, $param);
    header("location:CATE_INSERT.php");
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
                        <li><a href="ADMIN.php"><i class="flaticon-shield"></i>
                                Dashboard</a></li>
                        <li><a href="ADMIN_UPDATE.php"><i class="flaticon-account"></i> My Profile</a></li>
                        <li><a href="USER_MANAGE.php"><i class="flaticon-user-1"></i> User Management</a>
                        </li>
                        <li><a href="ORD_MANAGE.php"><i class="flaticon-shopping-bag-3"></i> Orders Management</a></li>
                        <li><a href="PRO_MANAGE.php"><i class="flaticon-package-1"></i> Products</a></li>
                        <li><a href="PRO_INSERT.php"><i class="flaticon-package"></i> Insert Products</a></li>
                        <li><a href="IMG_INSERT.php"><i class="flaticon-id-card"></i> Insert Image & Color</a></li>
                        <li><a class="active" href="#pills-insert-cate"><i class="flaticon-shield-1">
                                </i> Category Management</a></li>
                        <li><a href="BRAND_INSERT.php"><i class="flaticon-credit-card-1"></i> Brand Management</a></li>
                        <li><a href="logout.php"><i class="flaticon-power-button-1"></i> Logout</a></li>
                    </ul>
                </div>
                <!-- My Account Menu End -->
            </div>
            <div class="col-lg-10 col-md-9">
                <!-- Tab content start -->
                <div class="tab-content my-product-tab" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-insert-cate">
                        <div class="my-account-address my-account-details account-wrapper mt-6">
                            <form method="POST" enctype="multipart/form-data">
                                <h4 class="account-title">Insert new category</h4>
                                <div class="account-details">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label class="form-label mt-0" for="NAMECTGR">Category Name<span
                                                            class="required">*</span></label>
                                                <input type="text" value="" name="NAMECTGR" id="NAMECTGR">
                                            </div>
                                        </div>
                                        <div class="col-md-">
                                            <button type="submit" class="btn btn-danger">Insert</button>
                                        </div>
                                        <br/><br/>
                                        <hr/>
                                        <div style="overflow-x: auto">
                                            <table class="table table-bordered table-hover">
                                                <h5>Present Categories</h5>
                                                <tr>
                                                    <th>IDCTGR</th>
                                                    <th>Category Name</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                <?php
                                                $query = "select * from CATEGORY";
                                                $stmt = $dao->DML($query);
                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                                    ?>
                                                    <tr>
                                                        <td><?= $row["IDCTGR"]; ?></td>
                                                        <td><?= $row["NAMECTGR"]; ?></td>
                                                        <td><?= $row["STTCT"] ? "Active" : "Blocked"; ?></td>
                                                    <td>
                                                        <a href=CATE_EDIT.php?IDCTGR=<?= $row["IDCTGR"] ?>>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                 fill="currentColor" class="bi bi-pencil-square"
                                                                 viewBox="0 0 16 16">
                                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                                <path fill-rule="evenodd"
                                                                      d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                            </svg>
                                                        </a>
                                                    </td>
                                                    </tr>
                                                <?php
                                                endwhile;
                                                ?>
                                            </table>
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


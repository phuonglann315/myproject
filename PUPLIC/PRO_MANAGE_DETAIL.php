<?php
session_start();
include("../DAO/DaoDatabase.php");
$dao = new DaoDatabase();

if (isset($_SESSION['USERNAME'])) {
    if ($_SESSION['USERNAME'] === 'admin') {
            $query = "select P.IDPR, NAMEPR, NAMEBR, NAMECTGR, PRICE, BRIEFSUM, DESCRIPTION, IDIM, NAMEIM ,COLOR, DETAILQUANTITY,CREATEDATE, STATUSPRO
                                      from PRODUCT P
                                      INNER JOIN BRAND B ON P.IDBR = B.IDBR
                                       INNER JOIN CATEGORY C ON P.IDCTGR = C.IDCTGR
                                       INNER JOIN IMAGES I ON P.IDPR = I.IDPR WHERE P.IDPR=?";
            $param = [
                $_GET['IDPR']
            ];
            $stmt = $dao->DMLParam($query, $param);

    } else {
        header("Location:USER.php");
    }
} else {
    header("Location:HOME.php");
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
    <title>Product Management</title>
</head>
<body>
<div class="page-banner blog-page-banner section">
    <div class="container">
        <div class="page-banner-wrapper text-center">
            <h2 class="page-title">Admin Page</h2>
            <ul class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="HOME.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="ADMIN.php"><i class="fa fa-address-card"></i> Admin</a></li>
                <li class="breadcrumb-item"><a href="PRO_MANAGE.php"><i class="fa fa-product-hunt"></i> All Product</a></li>
                <li class="breadcrumb-item active">Product details</li>
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
                        <li><a href="ADMIN_UPDATE.php"><i class="flaticon-account"></i> My Profile</a></li>
                        <li><a href="USER_MANAGE.php"><i class="flaticon-user-1"></i> User Management</a>
                        </li>
                        <li><a href="ORD_MANAGE.php"><i class="flaticon-shopping-bag-3"></i> Orders Management</a></li>
                        <li><a class="active" data-bs-toggle="pill" href="#pills-product"><i
                                    class="flaticon-package-1"></i> Products</a></li>
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
                <div class="tab-pane fade show active" id="pills-product">
                    <div class="my-product product-wrapper mt-6">
                        <h4 class="account-title">My Products</h4>

                        <div style="overflow-x: auto">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th>IDPR</th>
                                    <th>Product Name</th>
                                    <th>Brand</th>
                                    <th>Categories</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Images</th>
                                    <th>Color</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Create date</th>
                                    <th>Action</th>
                                </tr>
                                    <tr>
                                        <?php
                                        if ($stmt->rowCount() == 0) {
                                            $query1="select P.IDPR, NAMEPR, NAMEBR, NAMECTGR, PRICE, BRIEFSUM, DESCRIPTION,CREATEDATE, STATUSPRO
                                      from PRODUCT P
                                      INNER JOIN BRAND B ON P.IDBR = B.IDBR
                                       INNER JOIN CATEGORY C ON P.IDCTGR = C.IDCTGR                                
									   WHERE P.IDPR=?";
                                        $param1 = [
                                            $_GET['IDPR']
                                        ];
                                        $stmt1=$dao->DMLParam($query1,$param1);
                                        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                        <td><?= $row1["IDPR"]; ?></td>
                                        <td><?= $row1["NAMEPR"]; ?></td>
                                        <td><?= $row1["NAMEBR"]; ?></td>
                                        <td><?= $row1["NAMECTGR"]; ?></td>
                                        <td><?= $row1["PRICE"]; ?></td>
                                        <td><?= $row1["DESCRIPTION"]; ?></td>
                                        <td><a href="IMG_INSERT.php">Update Image</a></td>
                                        <td>
                                            <div class="widget-color">
                                                <ul class="color-list ps-0">
                                                    <li class="active ms-0" data-tooltip="tooltip"
                                                        data-placement="top"
                                                        data-color=""></li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>waiting update</td>
                                        <td><?= $row1["STATUSPRO"] ? "In stock" : "Out of stock"; ?></td>
                                        <td><?= $row1["CREATEDATE"]; ?></td>
                                        <td><a href=PRO_UPDATE.php?IDPR=<?= $row1["IDPR"] ?>>Update Info</a><br/>

                                    </tr>
                                        <?php
                                        }
                                        if ($stmt->rowCount() != 0)
                                        {
                                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                        ?>
                                        <td><?= $row["IDPR"]; ?></td>
                                        <td><?= $row["NAMEPR"]; ?></td>
                                        <td><?= $row["NAMEBR"]; ?></td>
                                        <td><?= $row["NAMECTGR"]; ?></td>
                                        <td><?= $row["PRICE"]; ?></td>
                                        <td><?= $row["DESCRIPTION"]; ?></td>
                                        <td><img src="../IMAGES/IMG_PRO/<?= $row["NAMEIM"]; ?>" width="100px"</td>
                                        <td>
                                            <div class="widget-color">
                                                <ul class="color-list ps-0">
                                                    <li class="active ms-0" data-tooltip="tooltip"
                                                        data-placement="top"
                                                        data-color="<?= $row["COLOR"]; ?>"></li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td><?= $row["DETAILQUANTITY"]; ?></td>
                                        <td><?= $row["STATUSPRO"] ? "In stock" : "Out of stock"; ?></td>
                                        <td><?= $row["CREATEDATE"]; ?></td>
                                        <td><a href=PRO_UPDATE.php?IDPR=<?= $row["IDPR"] ?>>Update Info</a><br/>
                                            <a href=IMG_UPDATE.php?IDIM=<?= $row["IDIM"] ?>>Update Image</a><br/></td>
                                    </tr>
                               <?php
                               endwhile;
                                        }
                               ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<button class="flaticon-up-arrow" onclick="topFunction()" id="myBtn" title="Go to top"></button>

<!-- My Account End -->


<script src ="../JS/LAN_JS/CONTACT.js"></script>
<script src="../JS/bootstrap.bundle.min.js"></script>
<script src="../JS/jquery-2.2.4.js"></script>
<script src="../CSS/vendors/owlcarousel/owl.carousel.min.js"></script>
<script src="../JS/custom.js"></script>
</body>
</html>


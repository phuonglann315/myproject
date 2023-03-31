<?php
session_start();
include("../DAO/DaoDatabase.php");
$dao = new DaoDatabase();

if (isset($_SESSION['USERNAME'])) {
    if ($_SESSION['USERNAME'] === 'admin') {
        if (isset($_GET['search'])) {
            $query = "select count (P.IDPR) as total from PRODUCT P
                                                inner join details_ORDERS d on P.IDPR = d.IDPR
                                                inner join ORDERS O on d.IDIV = O.IDIV
                                                inner join IMAGES I on P.IDPR = I.IDPR 
                                                inner join BRAND B on B.IDBR = P.IDBR
                                                inner join CATEGORY C on C.IDCTGR = P.IDCTGR
                                                where  concat(d.IDPR,NAMEPR,NAMEBR,NAMECTGR,FULLNAME,ADDDRESS,PHONE)LIKE ? collate SQL_Latin1_General_CP1_CI_AI
                                                ";
            $param = [ "%{$_GET['search']}%"];
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
                $query = "select *
                                                            from (select *, ROW_NUMBER() OVER (ORDER BY IDPR DESC) as rownum
                                                             from (select *
                                                            from (select  P.IDPR AS IDPR,NAMEBR,NAMECTGR,FULLNAME,ADDDRESS,PHONE,O.IDIV AS IDIV,STTO,CREATETIME,SUBPAID,USERNAME
                                                            from PRODUCT P
                                                            inner join details_ORDERS d on P.IDPR = d.IDPR                                                
                                                             inner join ORDERS O on d.IDIV = O.IDIV                                               
                                                            inner join IMAGES I on P.IDPR = I.IDPR                                                 
                                                            inner join BRAND B on B.IDBR = P.IDBR                                                
                                                            inner join CATEGORY C on C.IDCTGR = P.IDCTGR                                                
                                                            where  concat(d.IDPR,NAMEPR,NAMEBR,NAMECTGR,FULLNAME,ADDDRESS,PHONE ) collate SQL_Latin1_General_CP1_CI_AI LIKE ? 
                                                            collate SQL_Latin1_General_CP1_CI_AI  
                                                            group by P.IDPR,NAMEBR,NAMECTGR,FULLNAME,ADDDRESS,PHONE,O.IDIV ,STTO,CREATETIME,SUBPAID,USERNAME) 
                                                            as t)  as t1)as tem
                                                            where tem.rownum between $start and $end                              
                                                            order by tem.STTO ASC  ";
                $param = [ "%{$_GET['search']}%"];
                $stmt = $dao->DMLParam($query, $param);

            }
            else {
                echo '<script language="javascript">';
                echo 'alert("No information as your request")';
                echo '</script>';
                $query = "select COUNT (IDIV) as total 
                                                    from ORDERS 
                                                     ";

                $stmt = $dao->DML($query);
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
                                                        from (select * from ORDERS  ) as t)  as t1)as tem 
                                                           where tem.rownum between $start and $end       
                                                            order by tem.STTO ASC ";

                $stmt = $dao->DML($query);
            }
        }
        else {
            $query = "select COUNT (IDIV) as total 
                                                    from ORDERS 
                                                    ";

            $stmt = $dao->DML($query);
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
                                                        from (select * from ORDERS  ) as t)  as t1)as tem 
                                                           where tem.rownum between $start and $end       
                                                            order by tem.STTO ASC ";

            $stmt = $dao->DML($query);
        }
    } else {
        header("Location:ADMIN.php");
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
    <title>Order Management</title>
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
                        <li><a href="ADMIN_UPDATE.php"><i class="flaticon-account"></i> My Profile</a></li>
                        <li><a href="USER_MANAGE.php"><i class="flaticon-user-1"></i> User Management</a>
                        </li>
                        <li><a class="active" href="#pills-order"><i class="flaticon-shopping-bag-3"></i> Order Management</a>
                        </li>
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
                <div class="tab-pane fade show active" id="pills-order">
                    <div class="my-product product-wrapper mt-6">
                        <h4 class="account-title">All Orders</h4>
                        <nav class="navbar navbar-light bg-light">
                            <div class="container-fluid">
                                <form method="get" class="d-flex">
                                    <input class="form-control me-2" name="search" id="search" type="search"
                                           placeholder="Search"
                                           aria-label="Search">
                                    <button class="btn btn-outline-success" type="submit" value="search">Search
                                    </button>
                                </form>
                            </div>
                        </nav>

                        <br/>

                        <div style="overflow-x: auto">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th>IDIV</th>
                                    <th>Username</th>
                                    <th>Subpaid</th>
                                    <th>Fullname</th>
                                    <th>Phone</th>
                                    <th>Create time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                    ?>
                                    <tr>
                                        <td><?= $row["IDIV"]; ?></td>
                                        <td><?= $row["USERNAME"]; ?></td>
                                        <td><?= $row["SUBPAID"]; ?></td>
                                        <td><?= $row["FULLNAME"]; ?></td>
                                        <td><?= $row["PHONE"]; ?></td>
                                        <td><?= $row["CREATETIME"]; ?></td>
                                        <td><?= $row["STTO"]?></td>
                                        <td><a href=ORD_DETAIL_MANAGE.php?IDIV=<?= $row["IDIV"] ?>>Edit</a><br/></td>
                                    </tr>
                                <?php
                                endwhile;
                                ?>
                                <div class="pagination">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                            <?php
                                            if (($current_page > 1) && ($total_page > 1)) {
                                                echo '<li class="page-item"><a class="page-link" href="USER_MANAGE.php?' . '&page=' . ($current_page - 1) . '">Prev</a></li> ';
                                            }
                                            // Lặp khoảng giữa
                                            for ($i = 1; $i <= $total_page; $i++) {
                                                // Nếu là trang hiện tại thì hiển thị thẻ span
                                                // ngược lại hiển thị thẻ a
                                                if ($i == $current_page) {
                                                    echo '<li class="page-item active">
                                                  <span class="page-link">' . $i . '<span class="sr-only">(current)</span>
                                                  </span>
                                                </li>';
                                                } else {
                                                    echo ' <li class="page-item " aria-current="page"><a class="page-link"<a href="USER_MANAGE.php?' . '&page=' . $i . '">' . $i . '</a></li> ';
                                                }
                                            }
                                            // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
                                            if ($current_page < $total_page && $total_page > 1) {
                                                echo '<li class="page-item"><a class="page-link"<a href="USER_MANAGE.php?' . '&page=' . ($current_page + 1) . '">Next</a> </li> ';
                                            }
                                            ?>
                                        </ul>
                                    </nav>
                                </div>
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




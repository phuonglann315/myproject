<?php
session_start();
include("../DAO/DaoDatabase.php");
$dao = new DaoDatabase();

if (isset($_SESSION['USERNAME'])) {
    if ($_SESSION['USERNAME'] === 'admin') {
        $query = "select USERNAME, PASS, EMAIL, PHONE from USERS
                        WHERE USERNAME = 'ADMIN'";
        $stmt = $dao->DML($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
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
                        <h4 class="account-title">Edit Account</h4>
                        <br/>
                        <div class="account-details">
                            <div class="row">
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
                                        <label class="form-label mt-0">Pass</label>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="single-form">
                                        <label class="form-label mt-0">*********</label>
                                        <a href="#" class="action" data-bs-toggle="modal"
                                           data-bs-target="#changepass">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-pencil-square"
                                                 viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd"
                                                      d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg>
                                        </a>
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
                                        <a href="#" class="action" data-bs-toggle="modal"
                                           data-bs-target="#changephone">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-pencil-square"
                                                 viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd"
                                                      d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="single-form">
                                        <label class="form-label mt-0">Email</label>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="single-form">
                                        <label class="form-label mt-0"><?= $row['EMAIL'] ?></label>
                                        <a href="#" class="action" data-bs-toggle="modal"
                                           data-bs-target="#changemail">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-pencil-square"
                                                 viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd"
                                                      d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade login" id="changepass" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="column-left">
                    <div class="login-wrpper">
                        <h4 class="title title-small no_after mb-0">Change Password</h4>
                        <div class="comments-form">
                            <form name="signup" method="POST" action="" onsubmit="return CHECK();">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="single-form">
                                             <span class="required error"
                                                   id="PASS-info"></span>
                                            <input type="password" name="PASS" value="" placeholder="Current password?"
                                                   id="PASS">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form">
                                             <span class="required error"
                                                   id="NEWPASS-info"></span>
                                            <input type="password" name="NEWPASS" value="" placeholder="New password?"
                                                   id="NEWPASS">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form">
                                             <span class="required error"
                                                   id="CFPASS-info"></span>
                                            <input type="password" name="CFPASS" value=""
                                                   placeholder="Confirm new password?"
                                                   id="CFPASS">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="single-form d-flex justify-content-between submit_lost-password">
                                            <input type="submit" name ="changepass" value="CHANGE PASSWORD"
                                                   STYLE="background-color: black;color: white">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="column-right">
                    <h4 class="title title-small no_after text_white mb-0">Care for your Skin, care for your beauty</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade login" id="changephone" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="column-left">
                    <div class="login-wrpper">
                        <h4 class="title title-small no_after mb-0">Change Phone</h4>
                        <div class="comments-form">
                            <form name="signup" method="POST" action="" onsubmit="return CHECKPHONE();">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="single-form">
                                            <span class="required error"
                                                  id="PHONE-info"></span>
                                            <input type="text" name="PHONE" value=""
                                                   placeholder="What is your current phone number?"
                                                   id="PHONE">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form">
                                            <span class="required error"
                                                  id="NEWPHONE-info"></span>
                                            <input type="text" name="NEWPHONE" value=""
                                                   placeholder="What is your new phone number?"
                                                   id="NEWPHONE">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form d-flex justify-content-between submit_lost-password">
                                            <input type="submit" name ="changephone"value="CHANGE PHONE NUMBER"
                                                   STYLE="background-color: black;color: white">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="column-right">
                    <h4 class="title title-small no_after text_white mb-0">Because your Skin deserves the best care</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade login" id="changemail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="height: 450px;">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="column-left">
                    <div class="login-wrpper">
                        <h4 class="title title-small no_after mb-0">Change Email</h4>
                        <div class="comments-form">
                            <form name="signup" method="POST" action="" onsubmit="return CHECKEMAIL();">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="single-form">
                                             <span class="required error"
                                                   id="EMAIL-info"></span>
                                            <input type="text" name="EMAIL" value=""
                                                   placeholder="What is your current email?"
                                                   id="EMAIL">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="single-form">
                                             <span class="required error"
                                                   id="NEWEMAIL-info"></span>
                                            <input type="text" name="NEWEMAIL" value=""
                                                   placeholder="What is your new email?"
                                                   id="NEWEMAIL">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="single-form d-flex justify-content-between submit_lost-password">
                                            <input type="submit" name ="changeemail" value="CHANGE EMAIL"
                                                   STYLE="background-color: black;color: white">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="column-right">
                    <h4 class="title title-small no_after text_white mb-0">Be yourself more, do care more</h4>
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
<script>
    /*----------------------------------------*/
    /*  Lightgallery Active
    /*----------------------------------------*/

    $(".popup-gallery").lightGallery({
        pager: false, // Enable/Disable pager
        thumbnail: false, // Enable thumbnails for the gallery
        fullScreen: true, // Enable/Disable fullscreen mode
        zoom: true, // Enable/Disable zoom option
        rotateLeft: true, // Enable/Disable Rotate Left
        rotateRight: true, // Enable/Disable Rotate Right
    });

    $(".zoom").on("click", function (e) {
        $(".popup-gallery .slick-active").trigger("click");
    });
</script>
<script src="../JS/custom.js"></script>
<script>
    $('.slider-five').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        navText: [
            "<i class='flaticon-next'></i>",
            "<i class='flaticon-back'></i>"
        ],
        asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.slider-five',
        dots: true,
        centerMode: true,
        focusOnSelect: true,
        arrows: true,
    });
</script>
</body>
</html>



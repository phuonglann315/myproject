<?php
include("../DAO/DaoDatabase.php");
$dao = new DaoDatabase();
$cart = (isset($_SESSION['cart'])) ? $_SESSION['cart'] : [];
$subtotal=0;
$total=0;
foreach ($cart as $IDPR => $value):
    $subtotal+=($value['NEWPRICE']*$value['QUANTITY']);
    $total+=1;
endforeach;
// nếu get code
if(isset($_GET['code'])) {
    $verificationCode = $_GET['code'];
    // nếu tồn tại cookie bằng get code
    $query = "SELECT count(USERNAME) as num FROM verified_action WHERE verification_code=?";
        $param = [$verificationCode];
        $stmt = $dao->DMLParam($query, $param);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $num = $row['num'];
        // nếu mã này chỉ có 1 user name có mã
        if ($num == 1) {
            $query1 = "SELECT USERNAME,NEWINFO  FROM verified_action WHERE verification_code=?";
            $param1 = [$verificationCode];
            $stmt1 = $dao->DMLParam($query1, $param1);
            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
            $USERNAME = $row1['USERNAME'];
            $NEWMAIL=$row1['NEWINFO'];
            $query2 = "UPDATE USERS set EMAIL=? where USERNAME=? ";
            $param2 = [$NEWMAIL,$USERNAME];
            $stmt2 = $dao->DMLParam($query2, $param2);
            $query = "delete verified_action WHERE USERNAME=?";
            $param = [$USERNAME];
            $stmt = $dao->DMLParam($query, $param);
            $error="Change Email successfully";
        }
       else{
            $error="Error ! Time UP!! Kindly re-submit request";
        }

}
else{
    header('location:HOME.php');
}
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
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

    <title>¨°o.O ROSIE STORE O.o°¨</title>
</head>
<body>

<!-- My Account Start -->
<div class="error maintenance">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 text-center"></div>
            <div class="col-lg-7 col-md-7 text-center">
                <div class="center_fix">
                    <div class="error_form">
                        <h1 class="title no_after"><?=$error?></h1>
                        <div class="col-lg-6 col-md-6"> </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- My Account End -->

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="../JS/bootstrap.bundle.min.js"></script>
<script src="../JS/jquery-2.2.4.js"></script>
<script src="../CSS/vendors/owlcarousel/owl.carousel.min.js"></script>
<script src="../JS/custom.js"></script>


</body>
</html>


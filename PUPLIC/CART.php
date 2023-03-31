<?php
session_start();
include("../DAO/DaoDatabase.php");
$dao = new DaoDatabase();
if (isset($_GET['IDPR'])) {
    $IDPR = $_GET['IDPR'];
}


$action=(isset($_GET['action'])?$_GET['action']:'add');
$QUANTITY=(isset($_GET['QUANTITY'])?$_GET['QUANTITY']:1);
if($QUANTITY<=0){
    $QUANTITY=1;
}
$query = "select IDPR,NAMEPR,PRICE,BRIEFSUM,CREATEDATE,
					
					      [NEWPRICE]=  CASE 
						  when DATEDIFF(MONTH,CREATEDATE,getdate())<=1 then PRODUCT.PRICE
						  when (DATEDIFF(MONTH,CREATEDATE,getdate())>1 and DATEDIFF(MONTH,CREATEDATE,getdate())<3 )then PRODUCT.PRICE
						  when DATEDIFF(MONTH,CREATEDATE,getdate()) =3 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.2) AS decimal(7,0))
					      when DATEDIFF(MONTH,CREATEDATE,getdate())=4 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.25) AS decimal(7,0))
					      when DATEDIFF(MONTH,CREATEDATE,getdate())>=5 then CAST(PRODUCT.PRICE-(PRODUCT.PRICE*0.3) AS decimal(7,0))
					      
                             end 
                             from PRODUCT 
                    where PRODUCT.IDPR=?";
$param = [$IDPR];
$stmt = $dao->DMLParam($query, $param);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$item = [
    'IDPR' => $row['IDPR'],
    'NAMEPR' => $row['NAMEPR'],
    'NEWPRICE' => $row['NEWPRICE'],
    'QUANTITY' => $QUANTITY
];
if($action=='add'){
    if (isset($_SESSION['cart'][$IDPR])) {
        $_SESSION['cart'][$IDPR]['QUANTITY'] += $QUANTITY;
    } else {
        $_SESSION['cart'][$IDPR] = $item;
    }
}
if($action=='update'){
    $_SESSION['cart'][$IDPR]['QUANTITY'] = $QUANTITY;
}
if($action=='delete'){
    unset($_SESSION['cart'][$IDPR]);
}
header('location:VIEWCART.php');
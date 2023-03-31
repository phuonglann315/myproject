<?php
session_start();
include("../DAO/DaoDatabase.php");
$dao = new DaoDatabase();
if (isset($_GET['IDPR'])) {
    $IDPR = $_GET['IDPR'];
}

$QUANTITY=1;

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

        $_SESSION['cart'][$IDPR] = $item;

header('location:PLACEORDER.php');
<?php
session_start();
include("../DAO/DaoDatabase.php");
$dao = new DaoDatabase();
if (isset($_SESSION['USERNAME'])) {
    if ($_SESSION['USERNAME'] != 'admin') {
        $username = $_SESSION['USERNAME'];
        if(isset($_GET['IDIV'])){
            $IDIV=$_GET['IDIV'];
            $query='select * from details_ORDERS where IDIV=?';
            $param=[$IDIV];
            $stmt=$dao->DMLParam($query,$param);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                $IDPR=$row['IDPR'];
                $QTT=$row['QUANTITY_order'];
                $query1='select * from PRODUCT where IDPR=?';
                $param1=[$IDPR];
                $stmt1=$dao->DMLParam($query1,$param1);
                $row = $stmt1->fetch(PDO::FETCH_ASSOC);
                $OLDQTT=$row['QUANTITY'];
                $newQTT=$OLDQTT+$QTT;
                $query2='update PRODUCT set QUANTITY =? where IDPR=?';
                $param2=[$newQTT,$IDPR];
                $stmt2=$dao->DMLParam($query2,$param2);
            endwhile;
            $query1='update ORDERS set STTO = 2,CFBY=? where IDIV=?';
            $param1=[$username,$IDIV];
            $stmt1=$dao->DMLParam($query1,$param1);
            header("Location:USER.php");
        }
        else {
            header("Location:HOME.php");
        }
    } else {
        header("Location:HOME.php");
    }

} else {
    header("Location:HOME.php");
}

<?php
session_start();
include("../DAO/DaoDatabase.php");
$dao = new DaoDatabase();

if (isset($_SESSION['USERNAME'])) {
    if ($_SESSION['USERNAME'] === 'admin') {
        if (isset($_GET['IDCTGR'])) {
            $query = "DELETE FROM CATEGORY WHERE IDCTGR = ?";
            $param = [
                $_GET['IDCTGR']
            ];
            $dao->DMLParam($query, $param);
            header("location:CATE_INSERT.php");
        }
        if (isset($_GET['IDBR'])) {
            $query = "DELETE FROM BRAND WHERE IDBR = ?";
            $param = [
                $_GET['IDBR']
            ];
            $dao->DMLParam($query, $param);
            header("location:BRAND_INSERT.php");
        }
        if (isset($_GET['IDIM'])) {
            $query = "DELETE FROM IMAGES WHERE IDIM = ?";
            $param = [
                $_GET['IDIM']
            ];
            $dao->DMLParam($query, $param);
            header("location:PRO_MANAGE.php");
        }
    } else {
        header("Location:ADMIN.php");
    }
} else {
    header("Location:HOME.php");
}
?>
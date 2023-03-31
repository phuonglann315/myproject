<?php

//Nếu chưa thì hiện trang cho phép đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //dau tien vo bang USERS xoa het tat ca nhung lock ở user có thời gian lock từ 15p
    $query10="EXEC del_locktime ";
    $stmt10=$dao->DML($query10);

    //kiểm tra xem có TỒN TẠI DÒNG DỮ LIỆU NÀO KHỚP ko
    if (empty($_POST['EMAIL'])){
        $pass = $_POST['PASS'];
        $user = $_POST['USERNAME'];
        $user=strtolower($user);
        $query = "select lower(USERNAME),PASS,locktime from USERS
                where ( USERNAME = ? and  PASS = ? and locktime is null and STTUSER !=0 )";
        $param = [
            $user, $pass
        ];
        $stmt = $dao->DMLParam($query, $param);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //nếu ko có dòng nào thì bắt đầu check tại sao
        if ($stmt->rowCount() == 0) {
            // đầu tiên check user có tồn tại hay ko
            $query = "select USERNAME from USERS 
                where ( USERNAME = ?)";
            $param = [
                $user
            ];
            $stmt = $dao->DMLParam($query, $param);
            //nếu ko có usẻ nào như này tức là user ko tồn tại
            if ($stmt->rowCount() == 0) {
                echo '<script language="javascript">';
                echo 'alert(" USERNAME NOT EXIST")';
                echo '</script>';
            }//nếu có user này tồn tại thì kiểm tra xem user bị khóa hay ko
            else {
                $query = "select USERNAME from USERS 
                where ( USERNAME = ?  and (locktime is not null or STTUSER=0) )";
                $param = [
                    $user
                ];
                $stmt = $dao->DMLParam($query, $param);
                //nếu ko có dòng nào tức là user này ko bị lock, kiểm tra sang pass
                if ($stmt->rowCount() == 0) {
                    $query = "select USERNAME,PASS from USERS
                    where (USERNAME  = ? and  PASS = ?)";
                    $param = [
                        $user, $pass
                    ];
                    $stmt = $dao->DMLParam($query, $param);
                    //nếu ko có dòng pass và user nào khớp tức pass sai
                    if ($stmt->rowCount() == 0) {
                        // đầu tiên check coi đã sai pass bao nhiu lần
                        $query = "select * from LOCKUSERS where (USERNAME=?)";
                        $param = [$user];
                        $stmt = $dao->DMLParam($query, $param);
                        // nếu trong bảng  ghi nhận lần log in sai dưới 5 lần
                        if (($stmt->rowCount() <=4)) {
                            $query1 = "select max(COUNTS) as tem from LOCKUSERS WHERE USERNAME=?";
                            $param1 = [$user];
                            $stmt1 = $dao->DMLParam($query1, $param1);
                            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                            $max = $row1['tem'];
                            $max1 = $max + 1;
                            // nếu pass sai thì insert vào bảng lock
                            $query2 = "insert into LOCKUSERS(USERNAME) values(?)";
                            $param2 = [$user];
                            $stmt2 = $dao->DMLParam($query2, $param2);
                            echo "<script language='JavaScript'>alert(\" WRONG PASS $max1 TIME, YOUR USER WILL LOCK WHEN WRONG PASS 5 TIME\");</script>";
                        }
                        if (($stmt->rowCount() == 5)) {
                            echo '<script language="javascript">';
                            echo 'alert(" YOUR ACCOUNT LOCKED,KINDLY RE-LOGIN AFTER 15 MINUTE")';
                            echo '</script>';
                        }
                    }
                }//nếu có dòng tức là user đang bị lock
                else {
                    echo '<script language="javascript">';
                    echo 'alert(" YOUR ACCOUNT LOCKED,KINDLY RE-LOGIN AFTER 15 MINUTE")';
                    echo '</script>';
                }

            }
        } //Nếu có thì cho đăng nhập, gán session cho user
        else {
            $query="delete FROM LOCKUSERS where USERNAME =?";
            $param=[$user];
            $stmt=$dao->DMLParam($query,$param);
            $_SESSION['USERNAME'] = $user;
            header("Location: HOME.php");

        }//nếu có dữ liệu khớp thì vô index
    }
    if(isset($_POST['EMAIL'])){
        $pass = $_POST['PASS'];
        $user = $_POST['USERNAME'];
        $user=strtolower($user);
        $phone = $_POST['PHONE'];
        $email = $_POST['EMAIL'];
        $query = "select lower (USERNAME) from USERS
                where ( USERNAME = ? )";
        $param = [
            $user
        ];
        $stmt = $dao->DMLParam($query, $param);
        //nếu ko có USERNAME thì
        if ($stmt->rowCount() == 0) {
            //check tiếp xem có email ko
            $query = "select upper(EMAIL) from USERS
                    where (EMAIL = ? )";
            $param = [
                $email
            ];
            $stmt = $dao->DMLParam($query, $param);
            if ($stmt->rowCount() == 0) {
                //check tiếp xem có PHONE ko
                $query = "select PHONE from USERS
                        where ( PHONE = ? )";
                $param = [
                    $_POST['PHONE']
                ];
                $stmt = $dao->DMLParam($query, $param);
                if ($stmt->rowCount() == 0) {//NẾU KO CÓ PHONE THÌ INSERT VÀO
                    $query1 = "insert into USERS(USERNAME,PASS, EMAIL, PHONE,STTUSER)
                             values (?,?,?,?,1)";
                    $param1 = [
                        $user,
                        $pass,
                        $email,
                        $phone
                    ];
                    $dao->DMLParam($query1, $param1);
                    $_SESSION['USERNAME'] = $user;

                    header("Location: HOME.php");

                }
                else {
                    echo '<script language="javascript">';
                    echo 'alert(" PHONE HAS AVAILABLE")';
                    echo '</script>';
                }//nếu có PHONE thì báo lỗi
            }
            else {
                echo '<script language="javascript">';
                echo 'alert("EMAIL HAS AVAILABLE")';
                echo '</script>';

            }//nếu có EMAIL thì báo lỗi
        }
        else {
            echo '<script language="javascript">';
            echo 'alert("USERNAME HAS AVAILABLE")';
            echo '</script>';

        }//nếu có USERNAME thì báo lỗi
    }
}



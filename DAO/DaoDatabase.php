<?php
//dao=data acces object => dảm nhận công việc kết nối, insert, dalete, update, select
//sử dụng PDO
include "../Validation/Message.php";

class DaoDatabase
{
//    private $dns = "mysql:host=localhost;dbname=rosiestore;charset=utf8";
//    private $username = "ThanhXuan";
//    private $password = "555abc";
    private $pdo;
    private $stmt;

//    $serverName="DESKTOP-TOQ9U0B";
//     $connectionInfo = array( "Database"=>"ROSIESTORE", "UID"=>"sa", "PWD"=>"123456");
//     $conn = sqlsrv_connect( $serverName, $connectionInfo);

    public function __construct()
    {

        try {
            $this->pdo  = new PDO("sqlsrv:Server=localhost;Database=ROSIESTORE", "sa", "123456");
        } catch (Exception $e) {
            // Nếu Try thất bại thì nhảy vào đây, dùng để xử lý gì đó xong thì tiếp tục nhảy đến mục ** làm tiếp
            Message::ShowMessage($e->getMessage());

        }
    }

    public function closeConn()
    {
        $this->pdo = null;
    }

//DML data manipulation langyage =>insert delete update select trong hàm này
    public function DML($query)
    {
        try {
            $this->stmt = $this->pdo->prepare($query);
            $this->stmt->execute();
            return $this->stmt;
        } catch (Exception $e) {
            Message::ShowMessage($e->getMessage());
        }
    }
    //DML data manipulation langyage =>insert delete update select trong hàm này CÓ CÁC PARAMETER
    //ái param chính là dấu ? trong câu query
    // có nghĩa là select * from TABLE where cot1=? and/or cot2=?
    public function DMLParam($query, $param)
    {
        try {
            $this->stmt = $this->pdo->prepare($query);
            $this->stmt->execute($param);
            return $this->stmt;
        } catch (Exception $e) {
            Message::ShowMessage($e->getMessage());
        }
    }

}

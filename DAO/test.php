<?php
//phpinfo();
//$serverName = "DESKTOP-TOQ9U0B";
//$connectionInfo = array( "Database"=>"ROSIESTORE", "UID"=>"sa", "PWD"=>"123456");
//$conn = sqlsrv_connect( $serverName, $connectionInfo);
//if( $conn ) {
//    echo "Connection established.<br />";
//}else{
//    echo "Connection could not be established.<br />";
//    die( print_r( sqlsrv_errors(), true));
//}

try
{
    $conn = new PDO("sqlsrv:Server=DESKTOP-TOQ9U0B;Database=ROSIESTORE", "sa", "123456");
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch(Exception $e)
{
    die( print_r( $e->getMessage() ) );
}

try
{

    $query = "SELECT * FROM [ROSIESTORE].[dbo].[USERS]";

    $getUsers = $conn->prepare($tsql);
    $getUsers->execute();
    $users = $getUsers->fetchAll(PDO::FETCH_ASSOC);
    $productCount = count($users);
    echo $productCount;
//    if($productCount > 0)
//    {
//        BeginProductsTable($productCount);
//        foreach( $products as $row )
//        {
//            PopulateProductsTable( $row );
//        }
//        EndProductsTable();
//    }
//    else
//    {
//        DisplayNoProdutsMsg();
//    }
}
catch(Exception $e)
{
    die( print_r( $e->getMessage() ) );
}


?>

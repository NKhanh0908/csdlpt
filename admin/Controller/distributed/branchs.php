<?php

include_once("connector.php");

function getBranch()
    {
        try
        {
            $conn = getConnection();
            $tsql = "select * from chdidong.dbo.chinhanh;";
            $getProducts = sqlsrv_query($conn, $tsql);
            while($row = sqlsrv_fetch_array($getProducts, SQLSRV_FETCH_ASSOC))
            {
                echo($row['ten'] . $row['diachi']);
                echo("<br/>");
            }
            sqlsrv_free_stmt($getProducts);
            sqlsrv_close($conn);
        }
        catch(Exception $e)
        {
            echo("Error!");
        }
}

function getBranchInfoServer1()
    {
        try
        {
            $conn = getConnectionServer1();
            $tsql = "select * from chdidong.dbo.chinhanh;";
            $getProducts = sqlsrv_query($conn, $tsql);
            $productCount = 0;
            while($row = sqlsrv_fetch_array($getProducts, SQLSRV_FETCH_ASSOC))
            {
                echo($row['ten'] . $row['diachi']);
                echo("<br/>");
                $productCount++;
            }
            sqlsrv_free_stmt($getProducts);
            sqlsrv_close($conn);
        }
        catch(Exception $e)
        {
            echo("Error!");
        }
}

getBranch();
echo "<hr>";
getBranchInfoServer1();

?>

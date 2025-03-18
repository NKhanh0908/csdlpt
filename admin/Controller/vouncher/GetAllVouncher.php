<?php

include('../Controller/connector.php');
function getAllVouncher(){
    global $conn;
    $conn = getConnection('branch2');
    $sql = "SELECT * FROM khuyenmai";

    $result = sqlsrv_query($conn, $sql);
    return $result;
}


?>
<?php

include('../Controller/connector.php');

function getAllProvider(){
    global $conn;
    $conn = getConnection('branch2');
    $sql = "SELECT n.* FROM nhacungcap n ";
    $result = sqlsrv_query($conn, $sql);
    return $result;
}


?>
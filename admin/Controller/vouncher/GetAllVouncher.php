<?php


function getAllVouncher(){
    global $conn;
    $conn = getConnection();
    $sql = "SELECT * FROM khuyenmai";

    $result = mysqli_query($conn, $sql);
    return $result;
}


?>
<?php

//include '.\connectDB.php';

function getAllProvider(){
    global $conn;
    $conn = getConnection();
    $sql = "SELECT n.* FROM nhacungcap n ";

    $result = mysqli_query($conn, $sql);
    return $result;
}


?>
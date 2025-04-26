<?php

function getConnection(){
    $conn=mysqli_connect("localhost:3306", "root", "13524679", "chdidong");
    if($conn->connect_error)
    {
        die("connect error: " . $conn->connect_error);
    }
    return $conn;
}

?>
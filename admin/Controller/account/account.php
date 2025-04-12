<?php
include('../Controller/connectDB.php');

function getAllAccounts() {
    $connect = getConnection();
    if ($connect->connect_error) {
        die("Kết nối thất bại: " . $connect->connect_error);
    }

    $sql = "SELECT tk.idTK, tk.USERNAME, tk.HOTEN, tk.EMAIL, q.TENQUYEN, tk.TRANGTHAI 
            FROM taikhoan tk
            LEFT JOIN quyen q ON tk.idQUYEN = q.idQUYEN";

    $result = $connect->query($sql);

    $accounts = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $accounts[] = $row;
        }
    }

    $connect->close();
    return $accounts;
}

?>
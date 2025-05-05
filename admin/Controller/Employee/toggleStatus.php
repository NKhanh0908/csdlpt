<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('../connector.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idTK'])) {
    $idTK = intval($_POST['idTK']);
    $idCN = intval($_POST['idCN']);
    error_log("idCN: " .$idCN ."idTK:" .$idTK );

    $connect = getConnection("branch2");
    // Kết nối theo chi nhánh
    if ($idCN == 1) {
        $connect = getConnection("branch2");
    } elseif ($idCN == 2) {
        $connect = getConnection("branch3");
    } elseif ($idCN == 3) {
        $connect = getConnection("branch4");
    }
    if ($connect) {
        error_log("Connect 1");
    }else{
        error_log("0");
    }

    // Lấy trạng thái hiện tại
    $query = "SELECT TRANGTHAI FROM taikhoan WHERE idTK = ?";
    $params = array($idTK);
    $stmt = sqlsrv_query($connect, $query, $params);

    if ($stmt && $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $newStatus = ($row['TRANGTHAI'] == 1) ? 0 : 1;

        // Cập nhật trạng thái mới
        $updateQuery = "UPDATE taikhoan SET TRANGTHAI = ? WHERE idTK = ?";
        $updateParams = array($newStatus, $idTK);
        $updateStmt = sqlsrv_query($connect, $updateQuery, $updateParams);

        if ($updateStmt) {
            echo "success";
        } else {
            echo "Lỗi cập nhật trạng thái!";
        }
    } else {
        echo "Không tìm thấy nhân viên!";
    }
}
?>

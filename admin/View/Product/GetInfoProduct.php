<?php
header('Content-Type: application/json');

include '../../Controller/connector.php';

if (isset($_GET["branch"])) {
    global $conn;
    $branch = $_GET["branch"];
    $conn = getConnection($branch);
    
    // Lấy dữ liệu hãng
    $sql_hang = sqlsrv_query($conn, "SELECT * FROM hang ORDER BY idHANG DESC", array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));
    if ($sql_hang === false) {
        die(json_encode(["error" => sqlsrv_errors()]));
    }
    $hang_data = [];
    while ($row = sqlsrv_fetch_array($sql_hang, SQLSRV_FETCH_ASSOC)) {
        $hang_data[] = $row;
    }
    
    // Lấy dữ liệu danh mục
    $sql_danhmuc = sqlsrv_query($conn, "SELECT * FROM danhmuc ORDER BY idDM DESC", array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));
    if ($sql_danhmuc === false) {
        die(json_encode(["error" => sqlsrv_errors()]));
    }
    $danhmuc_data = [];
    while ($row = sqlsrv_fetch_array($sql_danhmuc, SQLSRV_FETCH_ASSOC)) {
        $danhmuc_data[] = $row;
    }
    
    // Kết hợp dữ liệu vào một mảng và trả về dưới dạng JSON
    $result = [
        "success" => true,
        "hang" => $hang_data,
        "danhmuc" => $danhmuc_data
    ];
    
    echo json_encode($result);
    exit();
} else {
    echo json_encode([
        "success" => false,
        "error" => "Thiếu tham số branch"]);
    exit();
}
?>

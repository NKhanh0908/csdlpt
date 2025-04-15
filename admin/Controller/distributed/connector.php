<?php
function getConnection($branch) {
    $servers = [
        'branch1' => 'DESKTOP-VTHQS62\MSSQLSERVER3',          // Server chính
        'branch2' => 'DESKTOP-VTHQS62\MSSQLSERVER1',  
        'branch3' => 'DESKTOP-VTHQS62\MSSQLSERVER2',  
        'branch4' => 'DESKTOP-VTHQS62\MSSQLSERVER4'
    ];

    $database = "chdidong";
    $uid = "sa";
    $password = "vuem1705";

    if (!isset($servers[$branch])) {
        die("Chi nhánh không tồn tại!");
    }

    $connectionInfo = [
        "Database" => $database,
        "Uid" => $uid,
        "PWD" => $password,
        "CharacterSet" => "UTF-8"
    ];

    $conn = sqlsrv_connect($servers[$branch], $connectionInfo);

    if (!$conn) {
        die(print_r(sqlsrv_errors(), true));
    }
    return $conn;
}

// Kiểm tra xem chi nhánh có tồn tại không
function isBranchValid($conn, $branchId) {
    $sql = "SELECT COUNT(*) FROM dbo.chinhanh WHERE idCN = ?";
    $params = array($branchId);
    $stmt = sqlsrv_query($conn, $sql, $params);
    
    if ($stmt === false) {
        throw new Exception("Lỗi khi kiểm tra chi nhánh: " . print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    return $row[''] > 0;
}

// Khi thay đổi chi nhánh
if (!isBranchValid($conn, $newBranch)) {
    throw new Exception("Chi nhánh không hợp lệ");
}




?>
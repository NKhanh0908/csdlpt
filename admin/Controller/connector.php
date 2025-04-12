<?php
function getConnection($branch = "branch2") {
    $servers = [
        'branch1' => 'DESKTOP-VTHQS62\MSSQLSERVER3',
        'branch2' => 'DESKTOP-VTHQS62\MSSQLSERVER1',  
        'branch3' => 'DESKTOP-VTHQS62\MSSQLSERVER2',  
        'branch4' => 'DESKTOP-VTHQS62\MSSQLSERVER4'
    ];

    $database = "chdidong";
    $uid = "sa";
    $password = "vuem1705";

    if (!isset($servers[$branch])) {
        die(json_encode(["error" => "Chi nhánh không tồn tại!"]));
    }

    $connectionInfo = [
        "Database" => $database,
        "Uid" => $uid,
        "PWD" => $password,
        "CharacterSet" => "UTF-8",
        "ReturnDatesAsStrings" => true // Trả về ngày tháng dưới dạng chuỗi
    ];

    try {
        $conn = sqlsrv_connect($servers[$branch], $connectionInfo);
        
        if (!$conn) {
            $errors = sqlsrv_errors();
            error_log("SQL Server Connection Error: " . print_r($errors, true));
            die(json_encode(["error" => "Không thể kết nối đến cơ sở dữ liệu", "details" => $errors]));
        }
        
        return $conn;
    } catch (Exception $e) {
        die(json_encode(["error" => "Lỗi kết nối: " . $e->getMessage()]));
    }
}

// Kiểm tra SQLSRV extension
if (!function_exists('sqlsrv_connect')) {
    die(json_encode(["error" => "SQLSRV extension không khả dụng. Vui lòng cài đặt driver SQL Server cho PHP."]));
}
?>
<?php
function getConnection($branch = "branch2") {
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
// if (function_exists('sqlsrv_connect')) {
//     echo "SQLSRV is available!";
// } else {
//     echo "SQLSRV is NOT available.";
// }
?>
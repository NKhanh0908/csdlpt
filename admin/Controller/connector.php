<?php
function getConnection($branch = "branch2") {
    $servers = [
        'branch1' => 'LAPTOP-O2NQEJ35',          // Server chính
        'branch2' => 'LAPTOP-O2NQEJ35\MSSQLSERVER2',  
        'branch3' => 'LAPTOP-O2NQEJ35\MSSQLSERVER3',  
        'branch4' => 'LAPTOP-O2NQEJ35\MSSQLSERVER4'
    ];

    $database = "chdidong";
    $uid = "sa";
    $password = "13524679";

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

?>
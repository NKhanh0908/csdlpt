<?php

function getConnection(){

    $serverName = "LAPTOP-O2NQEJ35";
    $database = "chdidong";
    $uid = "sa";
    $password = "13524679";
    
    $connection = [
        "Database" => $database,
        "Uid" => $uid,
        "PWD" => $password,
        "CharacterSet" => "UTF-8"
    ];
    
    $conn = sqlsrv_connect($serverName, $connection);
    if(!$conn){
        die(print_r(sqlsrv_errors(), true));
    }
    return $conn;  
}

function getConnectionServer1(){
    $serverName = "LAPTOP-O2NQEJ35\MSSQLSERVER2";
    $database = "chdidong";
    $uid = "sa";
    $password = "13524679";
    
    $connection = [
        "Database" => $database,
        "Uid" => $uid,
        "PWD" => $password,
        "CharacterSet" => "UTF-8"
    ];
    
    $conn = sqlsrv_connect($serverName, $connection);
    if(!$conn){
        die(print_r(sqlsrv_errors(), true));
    }
    return $conn;
}

function getConnectionServer2(){
    $serverName = "LAPTOP-O2NQEJ35\MSSQLSERVER3";
    $database = "chdidong";
    $uid = "sa";
    $password = "13524679";
    
    $connection = [
        "Database" => $database,
        "Uid" => $uid,
        "PWD" => $password,
        "CharacterSet" => "UTF-8"
    ];
    
    $conn = sqlsrv_connect($serverName, $connection);
    if(!$conn){
        die(print_r(sqlsrv_errors(), true));
    }
    return $conn;
}

function getConnectionServer3(){
    $serverName = "LAPTOP-O2NQEJ35\MSSQLSERVER4";
    $database = "chdidong";
    $uid = "sa";
    $password = "13524679";
    
    $connection = [
        "Database" => $database,
        "Uid" => $uid,
        "PWD" => $password,
        "CharacterSet" => "UTF-8"
    ];
    
    $conn = sqlsrv_connect($serverName, $connection);
    if(!$conn){
        die(print_r(sqlsrv_errors(), true));
    }
    return $conn;
}


?>
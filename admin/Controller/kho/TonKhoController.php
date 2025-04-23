<?php
include_once("../connector.php");

class TonKhoController {
    private $conn;
    
    public function __construct($branch) {
        $this->conn = getConnection($branch);
        if ($this->conn === false) {
            die("Không thể kết nối đến cơ sở dữ liệu!");
        }
    }
    
    public function getTonKhoByIdKho($idKho) {
        $sql = "SELECT vt.TENVT, tk.SOLUONG, vt.idVT
                FROM tonkho tk 
                JOIN vattu vt ON tk.idVT = vt.idVT 
                WHERE tk.idKHO = ? AND tk.TRANGTHAI = 1";
                
        $params = array($idKho);
        $stmt = sqlsrv_query($this->conn, $sql, $params);
        
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        
        $result = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $result[] = $row;
        }
        
        return $result;
    }
    
    public function getKhoInfo($idKho) {
        $sql = "SELECT k.*, cn.ten as TEN_CHI_NHANH 
                FROM kho k 
                JOIN chinhanh cn ON k.idCN = cn.idCN 
                WHERE k.idKho = ?";
                
        $params = array($idKho);
        $stmt = sqlsrv_query($this->conn, $sql, $params);
        
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        
        return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    }
    
    public function updateSoLuong($idKho, $idVT, $soLuong) {
        $sql = "UPDATE tonkho 
                SET SOLUONG = ? 
                WHERE idKHO = ? AND idVT = ? AND TRANGTHAI = 1";
                
        $params = array($soLuong, $idKho, $idVT);
        $stmt = sqlsrv_query($this->conn, $sql, $params);
        
        if ($stmt === false) {
            return false;
        }
        
        return true;
    }
    
    public function __destruct() {
        if ($this->conn) {
            sqlsrv_close($this->conn);
        }
    }
}
?> 
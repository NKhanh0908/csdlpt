<?php
include_once("../Controller/connector.php");

class KhoController {
    private $conn;
    private $branch;

    public function __construct($branch = 'branch2') {
        $this->branch = $branch;
        $this->conn = getConnection($branch);
    }

    public function getAllKho() {
        $sql = "SELECT k.*, cn.ten as TEN_CHI_NHANH 
                FROM kho k 
                JOIN chinhanh cn ON k.idCN = cn.idCN";
        
        $stmt = sqlsrv_query($this->conn, $sql);
        if($stmt === false) {
            return false;
        }

        $khoList = array();
        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $khoList[] = $row;
        }
        return $khoList;
    }

    public function getTonKhoByKhoId($idKho) {
        $sql = "SELECT tk.*, sp.TENSP, sp.GIABAN 
                FROM tonkho tk 
                JOIN sanpham sp ON tk.idSP = sp.idSP 
                WHERE tk.idKHO = ?";
        
        $params = array($idKho);
        $stmt = sqlsrv_query($this->conn, $sql, $params);
        if($stmt === false) {
            return false;
        }

        $tonkhoList = array();
        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $tonkhoList[] = $row;
        }
        return $tonkhoList;
    }

    public function getKhoById($idKho) {
        $sql = "SELECT k.*, cn.ten as TEN_CHI_NHANH 
                FROM kho k 
                JOIN chinhanh cn ON k.idCN = cn.idCN 
                WHERE k.idKHO = ?";
        
        $params = array($idKho);
        $stmt = sqlsrv_query($this->conn, $sql, $params);
        if($stmt === false) {
            return false;
        }

        return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    }

    public function updateTonKho($idKho, $idSP, $soLuong) {
        $sql = "UPDATE tonkho SET SOLUONG = ? WHERE idKHO = ? AND idSP = ?";
        $params = array($soLuong, $idKho, $idSP);
        
        return sqlsrv_query($this->conn, $sql, $params);
    }

    public function getBranch() {
        return $this->branch;
    }

    public function changeBranch($newBranch) {
        $this->branch = $newBranch;
        $this->conn = getConnection($newBranch);
    }
}
?> 
<?php
include('../connector.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $type = isset($_GET['type'])? $_GET['type'] : '';
    $connect = getConnection("branch2");

    if($type=='NCC'){
        $sql = "SELECT idNCC, TENNCC from nhacungcap ";

        $result = sqlsrv_query($connect, $sql);
        $list_ncc = array();

        while($type = sqlsrv_fetch_array($result)){
            $id = $type['idNCC'];
            $name = $type['TENNCC'];
    
            $arr = array(
                'id' => $id,
                'name' => $name
            );
    
            array_push($list_ncc, $arr);
        }
        //Trả về list ncc
        $json = json_encode($list_ncc);
        echo $json;

    }else if($type=='HANG'){
        $sql = "SELECT idHANG, TENHANG from hang";

        $result = sqlsrv_query($connect, $sql);
        $list_hang = array();

        while($type = sqlsrv_fetch_array($result)){
            $id = $type['idHANG'];
            $name = $type['TENHANG'];
    
            $arr = array(
                'id' => $id,
                'name' => $name
            );
    
            array_push($list_hang, $arr);
        }
        //Trả về list hãng
        $json = json_encode($list_hang);
        echo $json;
    }else if($type=='DANHMUC'){
        $sql = "SELECT idDM, LOAISP from danhmuc";

        $result = sqlsrv_query($connect, $sql);
        $list_danhmuc = array();

        while($type = sqlsrv_fetch_array($result)){
            $id = $type['idDM'];
            $name = $type['LOAISP'];
    
            $arr = array(
                'id' => $id,
                'name' => $name
            );
    
            array_push($list_danhmuc, $arr);
        }
        //Trả về list danh mục
        $json = json_encode($list_danhmuc);
        echo $json;
    }
    else {
        $sql = "SELECT sp.idSP, sp.TENSP 
        FROM sanpham sp";

        $result = sqlsrv_query($connect, $sql);
        $list_sp = array();

        while($type = sqlsrv_fetch_array($result)){
            $id = $type['idSP'];
            $name = $type['TENSP'];
    
            $arr = array(
                'id' => $id,
                'name' => $name
            );
    
            array_push($list_sp, $arr);
        }
        //Trả về list sp
        $json = json_encode($list_sp);
        echo $json;
    }

}
?>
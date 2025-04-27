<?php
include('../connector.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $idPN = isset($data['idPN'])? $data['idPN'] : '';
    $branch = isset($data['branch'])? $data['branch'] : '';
    $connect = getConnection($branch);
    //Móc ra sản phẩm trong phiếu nhập
    $sql = 'SELECT sp.TENSP, ct.SOLUONG FROM sanpham sp INNER JOIN chitietphieunhap ct ON sp.idSP = ct.idSP
    WHERE ct.idPN = ' . intval($idPN);

    $result = sqlsrv_query($connect, $sql);
    $list_details= array();
    
    //Chạy truy vấn lưu từng sp vào mảng
    while($details = sqlsrv_fetch_array($result)){
        $tensp = $details['TENSP'];
        $soluong = $details['SOLUONG'];

        $arr = array(
            'tensp' => $tensp,
            'soluong' => $soluong
        );

        array_push($list_details, $arr);
    }

    $json = json_encode($list_details);
    echo $json;
}
?>
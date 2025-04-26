<?php
include('../connector.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $branch = isset($data['branch'])? $data['branch'] : '';
    $keyword = isset($data['keyword'])? $data['keyword'] : '';
    $order = isset($data['order'])? $data['order'] : '';
    $dateSearch = isset($data['dateSearch'])? $data['dateSearch'] : '';

    $connect = getConnection($branch);

    //Khỏi tạo biến cho câu truy vấn
    $sql = '';
    $sql_order = '';
    $sql_date = '';
    //check từ khóa nhập vào
    if($keyword==''){
        $sql = "SELECT pn.idPN, cc.TENNCC, cc.DIACHI, pn.NGAYNHAP, pn.THANHTIEN, pn.LOINHUAN 
        from phieunhap pn JOIN nhacungcap cc ON pn.idNCC=cc.idNCC";
    }else{
        $sql = "SELECT pn.idPN, cc.TENNCC, cc.DIACHI, pn.NGAYNHAP, pn.THANHTIEN, pn.LOINHUAN 
        from phieunhap pn JOIN nhacungcap cc ON pn.idNCC=cc.idNCC 
        WHERE (cc.TENNCC LIKE '%$keyword%' 
        OR cc.DIACHI LIKE '%$keyword%') ";
    }
    //check có chọn ngày nhập hàng không
    if($dateSearch != '')  $sql_date = $keyword==''? " WHERE pn.NGAYNHAP='$dateSearch'" : " AND pn.NGAYNHAP='$dateSearch'";
    //Tùy chọn sắp xếp
    switch ($order){
        case 1: $sql_order = ' ORDER BY pn.THANHTIEN ASC'; break;
        case 2: $sql_order = ' ORDER BY pn.THANHTIEN DESC'; break;
        default: break;
    }
    //Chạy truy vấn
    $result = sqlsrv_query($connect, $sql . $sql_date . $sql_order);
    $list_receipt = array();
    
    //Khúc dưới này chắc hiểu mà hen
    while($receipts = sqlsrv_fetch_array($result)){
        $id = $receipts['idPN'];
        $ncc = $receipts['TENNCC'];
        $diachi = $receipts['DIACHI'];
        $ngaynhap = $receipts['NGAYNHAP'];
        $thanhtien = $receipts['THANHTIEN'];
        $loinhuan = $receipts['LOINHUAN'];

        $arr = array(
            'id'=> $id,
            'ncc' => $ncc,
            'diachi' => $diachi,
            'ngaynhap' => $ngaynhap,
            'thanhtien' => $thanhtien,
            'loinhuan' => $loinhuan,
        );

        array_push($list_receipt, $arr);
    }

    $json = json_encode($list_receipt);
    echo $json;
}
?>
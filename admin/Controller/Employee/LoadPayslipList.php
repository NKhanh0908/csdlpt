<?php
include('../../Controller/connectDB.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $id = isset($_GET['idNV']) ? $_GET['idNV'] : null;
    $get_payslip = mysqli_query($conn, 'SELECT idLUONG, THOIGIAN, TONGTIEN from bangluong WHERE idNV=' . intval($id));
    //Khỏi tạo mảng pây lịp
    $listpayslip = array();
    
    while($slips = mysqli_fetch_array($get_payslip)){
        $idPL = $slips['idLUONG'];
        $time = $slips['THOIGIAN'];
        $total = $slips['TONGTIEN'];

        $arr = array(
            'idPL' => $idPL,
            'time' => $time,
            'total' => $total
        );

        array_push($listpayslip, $arr);
    }

    $json = json_encode($listpayslip);
    echo $json;
}  
?>
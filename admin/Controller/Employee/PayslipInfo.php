<?php
include('../../Controller/connectDB.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $id = isset($_GET['idPL']) ? $_GET['idPL'] : null;
    $get_payslip = mysqli_query($conn, 'SELECT THOIGIAN, TONGTIEN from bangluong WHERE idLUONG=' . intval($id));
    
    while($slips = mysqli_fetch_array($get_payslip)){
        $time = $slips['THOIGIAN'];
        $total = $slips['TONGTIEN'];
    }

    $rsponse = [
        'time' => $time,
        'total' => $total
    ];

    $json = json_encode($rsponse);
    echo $json;
}  
?>
<?php
include('../../Controller/connectDB.php');
$conn = getConnection();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $idPN = isset($data['idPN'])? $data['idPN'] : '';
    $idSP = isset($data['idSP'])? $data['idSP'] : '';
    $soluong = isset($data['soluong'])? $data['soluong'] : '';
    $gianhap = isset($data['gianhap'])? $data['gianhap'] : '';
    $loinhuan = isset($data['loinhuan'])? $data['loinhuan'] : '';

    $giaban = intval($gianhap) * (1 + intval($loinhuan)/100);

    //Insert vào chitietphieunnhap
    $sql = "INSERT INTO chitietphieunhap (idPN, idSP, SOLUONG)
    VALUES($idPN, $idSP, $soluong)";

    mysqli_query($conn, $sql);

    //Update số lượng và giá vào bảng sản phửm
    mysqli_query($conn, "UPDATE sanpham SET SOLUONG = SOLUONG + " . intval($soluong) . " WHERE idSP=" . intval($idSP));

    $response = [
        'message' => 'Đã thêm sản phẩm ' . intval($idSP) . ' vào ' . intval($idPN)
    ];

    $json = json_encode($response);
    echo $json;
}
?>
<?php
$path = $_SERVER["DOCUMENT_ROOT"] . '/admin/Controller/connectDB.php';
include($path);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $idSP = isset($_GET['idSP'])? $_GET['idSP'] : '';

    //Móc ra sản phẩm trong phiếu nhập
    $sql = 'SELECT idSP, TENSP, IMG, GIANHAP from sanpham WHERE idSP=' . intval($idSP);

    $result = mysqli_query($conn, $sql);
    //Chạy truy vấn lưu từng sp vào mảng
    while($sp = mysqli_fetch_array($result)){
        $idsp = $sp['idSP'];
        $tensp = $sp['TENSP'];
        $img = $sp['IMG'];
        $gianhap = $sp['GIANHAP'];

        $response = ['id' => $idSP,
            'name' => $tensp,
            'img' => $img,
            'gianhap' => $gianhap
        ];
    }

    $json = json_encode($response);
    echo $json;
}
?>
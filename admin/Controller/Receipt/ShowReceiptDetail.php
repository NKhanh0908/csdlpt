<?php
$path = $_SERVER["DOCUMENT_ROOT"] . '/admin/Controller/connectDB.php';
include($path);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $idPN = isset($_GET['idPN'])? $_GET['idPN'] : '';

    //Móc ra sản phẩm trong phiếu nhập
    $sql = 'SELECT sp.TENSP, sp.IMG, ct.GIANHAP, sp.GIA, ct.SOLUONG 
    FROM `chitietphieunhap` ct JOIN phieunhap pn ON 
    ct.idPN = pn.idPN JOIN sanpham sp ON ct.idSP = sp.idSP WHERE pn.idPN=' . intval($idPN);

    $result = mysqli_query($conn, $sql);
    $list_details= array();
    //Chạy truy vấn lưu từng sp vào mảng
    while($details = mysqli_fetch_array($result)){
        $tensp = $details['TENSP'];
        $soluong = $details['SOLUONG'];
        $gianhap = $details['GIANHAP'];
        $giaban = $details['GIA'];
        $img = $details['IMG'];

        $arr = array(
            'tensp' => $tensp,
            'soluong' => $soluong,
            'gianhap' => $gianhap,
            'giaban' => $giaban,
            'img' => $img
        );

        array_push($list_details, $arr);
    }

    $json = json_encode($list_details);
    echo $json;
}
?>
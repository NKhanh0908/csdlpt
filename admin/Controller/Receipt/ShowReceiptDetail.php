<?php
//include('../../Controller/connectDB.php');
include '..\connector.php';

$conn = getConnection('branch1');
header('Content-Type: application/json');

// if ($_SERVER['REQUEST_METHOD'] === 'GET') {

//     $idPN = isset($_GET['idPN'])? $_GET['idPN'] : '';

//     //Móc ra sản phẩm trong phiếu nhập
//     $sql = 'SELECT sp.TENSP, sp.IMG, ct.GIANHAP, sp.GIA, ct.SOLUONG 
//     FROM `chitietphieunhap` ct JOIN phieunhap pn ON 
//     ct.idPN = pn.idPN JOIN sanpham sp ON ct.idSP = sp.idSP WHERE pn.idPN=' . intval($idPN);

//     $result = mysqli_query($conn, $sql);
//     $list_details= array();
//     //Chạy truy vấn lưu từng sp vào mảng
//     while($details = mysqli_fetch_array($result)){
//         $tensp = $details['TENSP'];
//         $soluong = $details['SOLUONG'];
//         $gianhap = $details['GIANHAP'];
//         $giaban = $details['GIA'];
//         $img = $details['IMG'];

//         $arr = array(
//             'tensp' => $tensp,
//             'soluong' => $soluong,
//             'gianhap' => $gianhap,
//             'giaban' => $giaban,
//             'img' => $img
//         );

//         array_push($list_details, $arr);
//     }

//     $json = json_encode($list_details);
//     echo $json;
// }

getAllReceipt();

function getAllReceipt(){
    $tsql = "SELECT * FROM [chdidong].[dbo].[donhang]";
    $conn = getConnection('branch2');
    $getProducts = sqlsrv_query($conn, $tsql);
            while($row = sqlsrv_fetch_array($getProducts, SQLSRV_FETCH_ASSOC))
            {
                echo($row['idTK'] . $row['THANHTIEN'] . $row['DIACHI']);
                echo("<br/>");
            }
}
?>
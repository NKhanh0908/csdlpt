<?php
require_once ('../Controller/connector.php');

$idHD = isset($_GET['idHD']) ? intval($_GET['idHD']) : 0;
$idCN = isset($_GET['idCN']) ? intval($_GET['idCN']) : 2;
if ($idHD <= 0) {
    die("ID đơn hàng không hợp lệ.");
}

$branch = '';


if ($idCN == 1) {
    $branch = 'branch2';
    $connect = getConnection("branch2");
} elseif ($idCN == 2) {
    $branch = 'branch3';
    $connect = getConnection("branch3");
} elseif ($idCN == 3) {
    $branch = 'branch4';
    $connect = getConnection("branch4");
// } elseif ($idCN == 1) {
//     $branch = 'branch1';
//     $connect = getConnection("branch1");
}
 else {
    die("Chi nhánh không hợp lệ.");
}


if (!$connect) {
    die("Kết nối đến database thất bại: " . print_r(sqlsrv_errors(), true));
}

$sql = "SELECT d.idHD, tk.USERNAME AS khachhang, d.NGAYMUA, d.THANHTIEN, d.DIACHI, t.idSTATUS, t.STATUS 
        FROM [chdidong].[dbo].[donhang] d 
        JOIN [chdidong].[dbo].[taikhoan] tk ON d.idTK = tk.idTK
        JOIN [chdidong].[dbo].[trangthaidonhang] t ON d.TRANGTHAI = t.idSTATUS
        WHERE d.idHD = ?";

$params = array($idHD);
$order = sqlsrv_query($connect, $sql, $params);

// Kiểm tra lỗi truy vấn
if (!$order) {
    die("Lỗi truy vấn đơn hàng: " . print_r(sqlsrv_errors(), true));
}

$order = sqlsrv_fetch_array($order, SQLSRV_FETCH_ASSOC);
$order['NGAYMUA'] = $order['NGAYMUA']->format('Y-m-d');

$sql_products = "SELECT sp.TENSP, cthd.SOLUONG, sp.GIA, sp.IMG
                 FROM [chdidong].[dbo].[chitiethoadon] cthd
                 JOIN [chdidong].[dbo].[sanpham] sp ON cthd.idSP = sp.idSP
                 WHERE cthd.idHD = ?";

$products_connect = sqlsrv_query($connect, $sql_products, $params);

if (!$products_connect) {
    die("Lỗi truy vấn sản phẩm: " . print_r(sqlsrv_errors(), true));
}

$products = [];
while ($row = sqlsrv_fetch_array($products_connect, SQLSRV_FETCH_ASSOC)) {
    $products[] = $row;
}


// Xử lý cập nhật trạng thái đơn hàng
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $status = intval($_POST['status']);
    $sql_update = "UPDATE [chdidong].[dbo].[donhang] SET TRANGTHAI = ? WHERE idHD = ?";
    $params = array($status, $idHD);
    $stmt_update = sqlsrv_query($connect, $sql_update, $params);


    if ($stmt_update) {
        echo "<script>alert('Cập nhật trạng thái thành công!'); window.location.href='?page=orderdetail&idHD=$idHD&idCN=$idCN';</script>";
    } else {
        die("Lỗi caap nhat: " . print_r(sqlsrv_errors(), true));

    }
}

?>

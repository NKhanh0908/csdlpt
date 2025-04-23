<?php
include_once("../connector.php");
include_once("TonKhoController.php");

// Kiểm tra xem có action được gửi lên không
if (!isset($_GET['action'])) {
    die("Không có hành động được chỉ định!");
}

$action = $_GET['action'];
$branch = isset($_GET['branch']) ? $_GET['branch'] : 'branch2'; // Mặc định branch2

// Xử lý các hành động khác nhau
switch ($action) {
    case 'viewTonKho':
        // Kiểm tra thông tin cần thiết
        if (!isset($_GET['idKho'])) {
            die("Không nhận được thông tin kho!");
        }
        
        $idKho = $_GET['idKho'];
        
        // Chuyển hướng đến trang chi tiết tồn kho
        header("Location: ../../View/kho/tonkho_detail.php?idKho=" . $idKho . "&branch=" . $branch);
        exit;
        break;
        
    case 'updateTonKho':
        // Kiểm tra thông tin cần thiết
        if (!isset($_POST['idKho']) || !isset($_POST['idVT']) || !isset($_POST['soLuong'])) {
            die(json_encode(['success' => false, 'message' => 'Thiếu thông tin cần thiết']));
        }
        
        $idKho = $_POST['idKho'];
        $idVT = $_POST['idVT'];
        $soLuong = $_POST['soLuong'];
        
        $controller = new TonKhoController($branch);
        $result = $controller->updateSoLuong($idKho, $idVT, $soLuong);
        
        echo json_encode(['success' => $result]);
        break;
        
    default:
        die("Hành động không hợp lệ!");
        break;
}
?> 
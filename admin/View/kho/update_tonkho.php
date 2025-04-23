<?php
include_once("../../Controller/kho/khoController.php");

header('Content-Type: application/json');

if(!isset($_POST['idKho']) || !isset($_POST['idSP']) || !isset($_POST['soLuong'])) {
    echo json_encode(['success' => false, 'message' => 'Thiếu thông tin cập nhật!']);
    exit;
}

$khoController = new KhoController();
$result = $khoController->updateTonKho($_POST['idKho'], $_POST['idSP'], $_POST['soLuong']);

if($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra khi cập nhật!']);
}
?> 
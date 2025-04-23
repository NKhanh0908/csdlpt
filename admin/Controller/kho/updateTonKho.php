<?php
include_once("TonKhoController.php");

if (!isset($_POST['idKho']) || !isset($_POST['idVT']) || !isset($_POST['soLuong']) || !isset($_POST['branch'])) {
    die(json_encode(['success' => false, 'message' => 'Thiếu thông tin cần thiết']));
}

$idKho = $_POST['idKho'];
$idVT = $_POST['idVT'];
$soLuong = $_POST['soLuong'];
$branch = $_POST['branch'];

$controller = new TonKhoController($branch);
$result = $controller->updateSoLuong($idKho, $idVT, $soLuong);

echo json_encode(['success' => $result]);
?> 
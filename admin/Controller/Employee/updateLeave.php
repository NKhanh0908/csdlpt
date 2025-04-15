<?php
$conn = mysqli_connect("localhost", "root", "", "chdidong", 3306);
header('Content-Type: application/json');

$json = file_get_contents("php://input");
$data = json_decode($json, true);

$id = $data['id'] ?? null;
$ngay = $data['ngay'] ?? '';
$ten = $data['ten'] ?? '';

if (!$id || !$ngay || !$ten) {
    echo json_encode(["success" => false, "message" => "Thiếu thông tin."]);
    exit;
}

$query = "UPDATE ngayle SET NGAY = ?, TENNGAYLE = ? WHERE idNGAYLE = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ssi", $ngay, $ten, $id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(["success" => true, "message" => "Cập nhật thành công!"]);
} else {
    echo json_encode(["success" => false, "message" => "Cập nhật thất bại!"]);
}
?>

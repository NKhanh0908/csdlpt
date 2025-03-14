<?php
session_start();
header('Content-Type: application/json');

// Kết nối DB
$path = $_SERVER["DOCUMENT_ROOT"] . '/admin/Controller/connectDB.php';
include($path);
$conn->set_charset("utf8");

$idNV = isset($_SESSION['idNV']) ? $_SESSION['idNV'] : (isset($_GET['idNV']) ? $_GET['idNV'] : null);

// Kiểm tra nếu không có idNV thì trả về lỗi
if (!$idNV) {
    echo json_encode(['status' => false, 'message' => 'Không xác định được nhân viên']);
    exit;
}

// Truy vấn dữ liệu chấm công của nhân viên đang đăng nhập
$sql = "
    SELECT 
        DATE(NGAYLAM) AS NGAY, 
        TIME(CHECKIN) AS CHECKIN, 
        TIME(CHECKOUT) AS CHECKOUT, 
        HESO, 
        idNGAYLE 
    FROM bangchamcong 
    WHERE idNV = $idNV
";

$result = $conn->query($sql);

$events = [];
while ($row = $result->fetch_assoc()) {
    $start = $row['NGAY'];
    $checkin = $row['CHECKIN'] ?? 'Chưa checkin';
    $checkout = $row['CHECKOUT'] ?? 'Chưa checkout';

    // Tạo sự kiện cho checkin
    if ($row['CHECKIN']) {
        $events[] = [
            'title' => "Checkin: $checkin",
            'start' => $start . 'T' . $checkin,
            'color' => $row['idNGAYLE'] ? '#FF5733' : '#33FF57'
        ];
    }

    // Tạo sự kiện cho checkout
    if ($row['CHECKOUT']) {
        $events[] = [
            'title' => "Checkout: $checkout",
            'start' => $start . 'T' . $checkout,
            'color' => $row['idNGAYLE'] ? '#FF5733' : '#33FF57'
        ];
    }
}

// Trả về JSON
echo json_encode($events);
$conn->close();

<?php
// session_start(); // Bắt buộc để lấy session

header('Content-Type: application/json');
include('../../Controller/connectDB.php');
$conn = getConnection();

// Thiết lập múi giờ Việt Nam (UTC+7)
date_default_timezone_set('Asia/Ho_Chi_Minh');
$conn->set_charset("utf8");

$today = date('Y-m-d'); // Ngày hiện tại
$now = date('H:i:s');   // Giờ hiện tại


// Đọc dữ liệu gửi từ frontend
$input = json_decode(file_get_contents('php://input'), true);
$action = isset($input['action']) ? $input['action'] : ''; // lấy action (checkin/checkout)
$idNV = isset($input['id']) ? $input['id'] : null;

// Kiểm tra hợp lệ action
if (!in_array($action, ['checkin', 'checkout'])) {
    echo json_encode(['status' => false, 'message' => 'Hành động không hợp lệ']);
    exit;
}

if ($action == 'checkin') {
    // Kiểm tra đã checkin chưa
    $sqlCheck = "SELECT * FROM bangchamcong WHERE DATE(NGAYLAM) = '$today' AND idNV = $idNV";
    $resultCheck = $conn->query($sqlCheck);

    if ($resultCheck->num_rows > 0) {
        echo json_encode(['status' => true, 'message' => 'Hôm nay bạn đã checkin rồi']);
        exit;
    } else {
        // Thực hiện checkin
        $sqlInsert = "INSERT INTO bangchamcong (idNV, NGAYLAM, CHECKIN, HESO, idNGAYLE) 
                      VALUES ($idNV, '$today', '$now', 1, NULL)";
        $conn->query($sqlInsert);

        // Kiểm tra nếu là ngày lễ thì cập nhật HESO và idNGAYLE
        $sqlHoliday = "SELECT idNGAYLE FROM ngayle WHERE NGAY = '$today'";
        $resultHoliday = $conn->query($sqlHoliday);

        if ($row = $resultHoliday->fetch_assoc()) {
            $idNgayLe = $row['idNGAYLE'];
            $conn->query("UPDATE bangchamcong SET HESO = 2, idNGAYLE = $idNgayLe WHERE idNV = $idNV AND NGAYLAM = '$today'");
        }

        echo json_encode(['status' => true, 'message' => 'Checkin thành công']);
    }
} elseif ($action === 'checkout') {
    // Kiểm tra đã checkin chưa
    $sqlCheck = "SELECT * FROM bangchamcong WHERE DATE(NGAYLAM) = '$today' AND idNV = $idNV";
    $resultCheck = $conn->query($sqlCheck);

    if ($resultCheck->num_rows === 0) {
        echo json_encode(['status' => false, 'message' => 'Bạn chưa checkin nên không thể checkout']);
        exit;
    }

    $row = $resultCheck->fetch_assoc();
    if ($row['CHECKOUT']) {
        echo json_encode(['status' => true, 'message' => 'Hôm nay bạn đã checkout rồi']);
        exit;
    }

    // Thực hiện checkout
    $sqlUpdate = "UPDATE bangchamcong SET CHECKOUT = '$now' WHERE idNV = $idNV AND NGAYLAM = '$today'";
    $conn->query($sqlUpdate);

    echo json_encode(['status' => true, 'message' => 'Checkout thành công']);
}

$conn->close();

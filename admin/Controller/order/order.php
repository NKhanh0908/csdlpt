<?php
include('../connectDB.php');
$conn = getConnection();

// Lấy trạng thái từ request
$status = isset($_GET["status"]) ? $_GET["status"] : "all";

// Truy vấn SQL
$sql = "SELECT d.idHD, tk.USERNAME AS khachhang, d.NGAYMUA, d.THANHTIEN, t.STATUS 
        FROM donhang d 
        JOIN taikhoan tk ON d.idTK = tk.idTK
        JOIN trangthaidonhang t ON d.TRANGTHAI = t.idSTATUS";

if ($status !== "all") {
    $sql .= " WHERE d.TRANGTHAI = " . intval($status);
}

// Thêm ORDER BY để sắp xếp theo idHD tăng dần
$sql .= " ORDER BY d.idHD ASC";

$result = $conn->query($sql); // Sửa $connect thành $conn
$orders = [];

while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

// Trả về JSON
header('Content-Type: application/json');
echo json_encode($orders);

$conn->close(); // Sửa $connect thành $conn
?>
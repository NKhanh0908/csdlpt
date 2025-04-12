<?php
$conn = mysqli_connect("localhost", "root", "", "chdidong", 3306);
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Xử lý khi gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenNgayLe = mysqli_real_escape_string($conn, $_POST['tenNgayLe']);
    $ngay = mysqli_real_escape_string($conn, $_POST['ngay']);

    // Kiểm tra ngày nhập vào
    $today = date("Y-m-d"); // Lấy ngày hiện tại ở dạng YYYY-MM-DD
    if ($ngay <= $today) {
        $message = "Ngày nghỉ lễ phải lớn hơn ngày hôm nay.";
    } else {
        // Tiến hành lưu vào cơ sở dữ liệu nếu ngày hợp lệ
        $sql = "INSERT INTO ngayle (TENNGAYLE, NGAY) VALUES ('$tenNgayLe', '$ngay')";
        if (mysqli_query($conn, $sql)) {
            $message = "Thêm ngày nghỉ lễ thành công!";
        } else {
            $message = "Lỗi: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉ Định Nghỉ Phép</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        .container {
            width: 40%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: orange;
        }
        input, button {
            width: 90%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background: green;
            color: white;
            cursor: pointer;
        }
        .back-btn {
            background: gray;
        }
    </style>
</head>
<body>

<div class="container" id="assignLeave">
    <h2>Chỉ Định Nghỉ</h2>
    
    <?php if (!empty($message)): ?>
        <p style="color: green;"><?= $message ?></p>
    <?php endif; ?>

    <form method="POST" onsubmit="return validateForm();">
        <label>Tên ngày lễ:</label>
        <input type="text" id="tenNgayLe" name="tenNgayLe" required>

        <label>Ngày nghỉ:</label>
        <input type="date" id="ngayBatDau" name="ngay" required>

        <button type="submit">Lưu</button>
        <a href="../employee/TakeLeave.php"><button type="button" class="back-btn">Quay lại</button></a>
    </form>
</div>

<script>
    function validateForm() {
        let tenNgayLe = document.getElementById("tenNgayLe").value.trim();
        let ngay = document.getElementById("ngay").value;

        if (tenNgayLe === "") {
            alert("Vui lòng nhập tên ngày lễ.");
            return false;
        }

        if (ngay === "") {
            alert("Vui lòng chọn ngày.");
            return false;
        }

        // Kiểm tra ngày phải lớn hơn hôm nay
        let today = new Date();
        today.setHours(0, 0, 0, 0); // bỏ giờ để so sánh chỉ theo ngày

        let selectedDate = new Date(ngay);
        if (selectedDate <= today) {
            alert("Đi làm rồi mà còn đòi nghỉ má");
            return false;
        }

        return true;
    }

    document.getElementById("assignLeave").addEventListener("submit", function(event) {
            // Gọi hàm kiểm tra khi người dùng gửi form
            if (!validateForm()) {
                // Nếu validate trả về false, ngừng gửi form
                event.preventDefault();
            } 
        });
</script>

</body>
</html>

<?php mysqli_close($conn); ?>

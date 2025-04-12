<?php
include("../../Controller/employee/updateEmployee.php");

$conn = mysqli_connect("localhost:3306", "root", "", "chdidong");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['idTK'])) {
        $idTK = $_POST['idTK'];

        // Lấy thông tin nhân viên từ database
        $sql = "SELECT * FROM taikhoan tk, nhanvien nv WHERE nv.idTK = ? and tk.idTK = nv.idTK";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idTK);
        $stmt->execute();
        $result = $stmt->get_result();
        $employee = $result->fetch_assoc();

        if (!$employee) {
            echo "Không tìm thấy nhân viên!";
            exit;
        }
    } else {
        echo "Không tìm thấy ID nhân viên!";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Cập nhật nhân viên</title>
    <style>
        form {
            width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        label {
            font-weight: bold;
        }

        .error {
            color: red;
            font-size: 14px;
            display: block;
        }

        #img {
            height: 100px;
            width: 100px;
        }
    </style>
</head>

<body>
    <h2 style="text-align:center;">Cập nhật thông tin nhân viên</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="idTK" value="<?= htmlspecialchars($idTK) ?>">
        <input type="hidden" name="img-name" value="<?= $employee['IMG'] ?>">
        <input type="hidden" name="vtrilviec" value="<?= $employee['idQUYEN'] ?>">

        <label for="Img">Hình ảnh</label><br>
        <img id="img" src="../../../images/employee/<?= $employee['IMG'] ?>" alt="">
        <input type="file" name="Img" accept="image/*" onchange="hienThiAnh(event)">

        <label>Họ tên:</label>
        <input type="text" name="hoten" value="<?= htmlspecialchars($employee['HOTEN']) ?>">
        <span class="error" id="hotenError"></span>

        <label>Ngày sinh:</label>
        <input type="date" name="date" value="<?= htmlspecialchars($employee['NGAYSINH']) ?>">
        <span class="error" id="dateError"></span>

        <label>Giới tính:</label>
        <input type="radio" name="gender" value="1" <?= ($employee['GIOITINH'] == 1) ? 'checked' : '' ?>> Nam
        <input type="radio" name="gender" value="0" <?= ($employee['GIOITINH'] == 0) ? 'checked' : '' ?>> Nữ

        <br>
        <label>Địa chỉ:</label>
        <input type="text" name="address" value="<?= htmlspecialchars($employee['DIACHI']) ?>">
        <span class="error" id="addressError"></span>

        <label>Số điện thoại:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($employee['SDT']) ?>">
        <span class="error" id="phoneError"></span>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($employee['EMAIL']) ?>">
        <span class="error" id="emailError"></span>

        <label>Ngày vào làm:</label>
        <input type="date" name="ngaylam" value="<?= htmlspecialchars($employee['NGAYVAOLAM']) ?>" readonly>
        <span class="error" id="ngaylamError"></span>

        <label>Vị trí làm việc:</label>
        <select name="QUYEN" id="quyenSelect" onchange="toggleNgayNhanChuc()">
            <?php
            $result = mysqli_query($conn, "SELECT idQUYEN, TENQUYEN FROM quyen WHERE idQUYEN <> 1 AND idQUYEN <> 0");
            while ($row = mysqli_fetch_assoc($result)) {
                $selected = ($employee['idQUYEN'] == $row['idQUYEN']) ? "selected" : "";
                if($_SESSION["role"] == 4) {
                    continue;
                }
                echo "<option value='{$row['idQUYEN']}' $selected>{$row['TENQUYEN']}</option>";
            }
            ?>
        </select>

        <div id="ngayNhanChucDiv" style="display:none;">
            <label>Ngày nhận chức:</label>
            <input type="date" name="ngay_nhan_chuc">
        </div>
        <span class="error" id="ngayncError"></span>

        <input type="submit" value="Cập nhật nhân viên" name="updateEmployee">
    </form>
</body>

</html>
<script>
    function hienThiAnh(event) {
        var reader = new FileReader();
        reader.onload = function () {
            document.getElementById("img").src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function toggleNgayNhanChuc() {
        let vitrilv = document.querySelector("select[name='QUYEN']").value;
        let currentRole = "<?= $employee['idQUYEN'] ?>"; // Chuyển thành chuỗi

        console.log("Chức vụ hiện tại:", currentRole);
        console.log("Chức vụ đã chọn:", vitrilv);

        let ngayNhanChucDiv = document.getElementById("ngayNhanChucDiv");

        if (currentRole !== vitrilv) {
            ngayNhanChucDiv.style.display = "block";
        } else {
            ngayNhanChucDiv.style.display = "none";
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("form").addEventListener("submit", function (event) {
            var img = document.querySelector('input[name="txtImg"]');
            let hoten = document.querySelector("[name='hoten']").value.trim();
            let ngaySinhInput = document.querySelector("[name='date']").value;
            let gioitinh = document.querySelector("[name='gender']:checked").value;
            let diachi = document.querySelector("[name='address']").value;
            let phone = document.querySelector("[name='phone']").value.trim();
            let email = document.querySelector("[name='email']").value.trim();
            let idQUYEN = document.querySelector("select[name='QUYEN']").value;
            let ngayNhanChucDiv = document.getElementById("ngayNhanChucDiv");

            console.log("quyen " + idQUYEN);


            // Chặn form submit mặc định
            let isValid = true;

            // Xóa thông báo lỗi cũ
            document.querySelectorAll(".error").forEach(e => e.textContent = "");

            if (hoten === "") {
                document.getElementById("hotenError").textContent = "Họ tên không được để trống.";
                isValid = false;
            }

            if (diachi === "") {
                document.getElementById("addressError").textContent = "Địa chỉ không được để trống.";
                isValid = false;
            }


            let today = new Date();
            // Đặt giờ, phút, giây về 0 để tránh lỗi so sánh
            today.setHours(0, 0, 0, 0);
            if (ngaySinhInput === "") {
                document.getElementById("dateError").textContent = "Vui lòng nhập ngày sinh.";
                isValid = false;
            } else {
                var ngaySinh = new Date(ngaySinhInput);
                ngaySinh.setHours(0, 0, 0, 0);

                if (ngaySinh >= today) {
                    document.getElementById("dateError").textContent = "Ngày sinh phải nhỏ hơn ngày hiện tại.";
                    isValid = false;
                } else {
                    let age = today.getFullYear() - ngaySinh.getFullYear();
                    let monthDiff = today.getMonth() - ngaySinh.getMonth();
                    let dayDiff = today.getDate() - ngaySinh.getDate();

                    // Kiểm tra nếu sinh nhật chưa đến trong năm nay thì giảm tuổi đi 1
                    if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                        age--;
                    }

                    if (age < 18) {
                        document.getElementById("dateError").textContent = "Nhân viên phải đủ 18 tuổi.";
                        isValid = false;
                    }
                }
            }



            let phoneRegex = /^0[0-9]{9}$/;
            if (!phoneRegex.test(phone)) {
                document.getElementById("phoneError").textContent = "Số điện thoại phải có 10 chữ số.";
                isValid = false;
            }


            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                document.getElementById("emailError").textContent = "Email không hợp lệ.";
                isValid = false;
            }

            if (ngayNhanChucDiv <= today) {
                document.getElementById("ngaylamError").textContent = "Ngày nhận chức không được bé hơn ngày hiện tại.";
                isValid = false;
            }

            // Nếu có lỗi thì dừng lại
            if (!isValid) {
                event.preventDefault();
                console.log("Form validation failed!");
                return;
            }
        });
    });

</script>
<?php
include("../Controller/Employee/updateEmployee.php");

if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    if (isset($_GET['idTK']) && isset($_GET['idCN'])) {
        $idTK = intval($_GET['idTK']);
        $idCN = intval($_GET['idCN']);  // chuyển sang số nguyên để so sánh

        if ($idCN == 1) {
            $branch = 'branch2';
            $connect = getConnection("branch2");
        } elseif ($idCN == 2) {
            $branch = 'branch3';
            $connect = getConnection("branch3");
        } elseif ($idCN == 3) {
            $branch = 'branch4';
            $connect = getConnection("branch4");
        } else {
            die("Chi nhánh không hợp lệ.");
        }

        if (!$connect) {
            die("Kết nối đến database thất bại: " . print_r(sqlsrv_errors(), true));
        }

        $sql = "SELECT nv.idTK as idTK, tk.PASSWORD as PASSWORD, tk.EMAIL as EMAIL, nv.idCV as idCV, nv.idCN as idCN, nv.DIACHI as DIACHI, tk.SDT as SDT, tk.TRANGTHAI as TRANGTHAI  FROM chdidong.dbo.taikhoan tk
          JOIN chdidong.dbo.nhanvien nv ON tk.idTK = nv.idTK WHERE nv.idTK = ?";
        $params = array($idTK);
        $emp = sqlsrv_query($connect, $sql, $params);

        if (!$emp) {
            die("Lỗi truy vấn nhân viên: " . print_r(sqlsrv_errors(), true));
        }

        $emp = sqlsrv_fetch_array($emp, SQLSRV_FETCH_ASSOC);
    }
}


?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật nhân viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-container {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="date"],
        input[type="tel"],
        input[type="email"],
        input[type="file"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .employee-photo {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        .success {
            color: green;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="text-align:center;">Cập nhật thông tin nhân viên</h2>
        
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        
        <div class="form-container">
        <form method="POST" enctype="multipart/form-data">
    <!-- Đảm bảo có trường idTK -->
    <input type="hidden" name="idTK" value="<?= htmlspecialchars($emp['idTK'] ?? ($_GET['id'] ?? '')) ?>">

    
    <!-- Đảm bảo có trường updateEmployee -->
    <input type="hidden" name="updateEmployee" value="1">
    

    <div class="form-group">
                <label>Mã nhân viên (idTK):</label>
                <input type="text" name="idTK" value="<?= htmlspecialchars($emp['idTK'] ?? '') ?>" required>
            </div>


                
                <!-- <div class="form-group">
                    <label for="hoten">Họ và tên:</label>
                    <input type="text" name="hoten" value="<?= htmlspecialchars($emp['HOTEN'] ?? '') ?>" required>
                </div> -->
                
                <!-- <div class="form-group">
                    <label for="gender">Giới tính:</label>
                    <select name="gender" required>
                        <option value="Male" <?= ($employee['GIOITINH'] ?? '') == 'Nam' ? 'selected' : '' ?>>Nam</option>
                        <option value="Female" <?= ($employee['GIOITINH'] ?? '') == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                    </select>
                </div> -->
                
                <!-- <div class="form-group">
                    <label for="dateOfBirth">Ngày sinh:</label>
                    <input type="date" name="dateOfBirth" 
                           value="<?= !empty($employee['NGAYSINH']) ? date('Y-m-d', strtotime($employee['NGAYSINH'])) : '' ?>" 
                           required>
                </div>
                 -->
                <div class="form-group">
                    <label for="address">Địa chỉ:</label>
                    <input type="text" name="address" value="<?= htmlspecialchars($emp['DIACHI'] ?? '') ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Số điện thoại:</label>
                    <input type="tel" name="phone" value="<?= htmlspecialchars($emp['SDT'] ?? '') ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($emp['EMAIL'] ?? '') ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="status">Trạng thái:</label>
                    <select name="status" required>
                        <option value="active" <?= ($emp['TINHTRANG'] ?? '') == 'active' ? 'selected' : '' ?>>Hoạt động</option>
                        <option value="inactive" <?= ($emp['TINHTRANG'] ?? '') == 'inactive' ? 'selected' : '' ?>>Không hoạt động</option>
                    </select>
                </div>
                
                <div class="form-group">
    <label for="branch">Chi nhánh:</label>
    <select name="branch" required>
    <?php
    // Kết nối cơ sở dữ liệu để lấy danh sách chi nhánh
    $conn = getConnection('branch1');
    $result = sqlsrv_query($conn, "SELECT idCN, ten FROM chdidong.dbo.chinhanh");
    if ($result) {
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            // Kiểm tra chi nhánh hiện tại của nhân viên và đánh dấu lựa chọn
            $selected = ($emp['idCN'] ?? '') == $row['idCN'] ? 'selected' : '';
            echo "<option value='{$row['idCN']}' $selected>{$row['ten']}</option>";  // Sửa dòng này để hiển thị tên chi nhánh thay vì chỉ idCN
        }
    }
    ?>
</select>

</div>
                
                <div class="form-group">
                    <label for="jobTitle">Chức vụ:</label>
                    <select name="jobTitle" required>
                        <?php
                        $result = sqlsrv_query($conn, "SELECT idCV, TENCHUCVU FROM chdidong.dbo.chucvu");
                        if ($result) {
                            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                $selected = ($emp['idCV'] ?? '') == $row['idCV'] ? 'selected' : '';
                                echo "<option value='{$row['idCV']}' $selected>{$row['TENCHUCVU']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="img">Ảnh đại diện:</label>
                    <?php if (!empty($employee['IMG'])): ?>
                        <img class="employee-photo" src="../../images/employee/<?= htmlspecialchars($employee['IMG']) ?>" alt="Ảnh đại diện">
                    <?php else: ?>
                        <img class="employee-photo" src="../../images/employee/default.jpg" alt="Ảnh đại diện">
                    <?php endif; ?>
                    <input type="file" name="img" accept="image/*" onchange="previewImage(this)">
                </div>
                
                <button type="submit" name="updateEmployee" class="btn">Cập nhật</button>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.employee-photo').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
<script>
    // function hienThiAnh(event) {
    //     var reader = new FileReader();
    //     reader.onload = function () {
    //         document.getElementById("img").src = reader.result;
    //     };
    //     reader.readAsDataURL(event.target.files[0]);
    // }

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
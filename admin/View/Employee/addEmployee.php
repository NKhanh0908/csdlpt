<?php
include("../Controller/Employee/addEmployee.php");  // Chỉnh lại đường dẫn đúng


?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm tài khoản</title>
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
    </style>
</head>

<body>

    <h2 style="text-align:center;">Thêm Nhân viên</h2>

    <form method="post" enctype="multipart/form-data">

        <label for="txtImg">Hình ảnh</label><br>
        <input type="file" name="txtImg" accept="image/png, image/gif, image/jpeg" onchange="hienThiAnh(event)">
        <div>
            <img id="img" src="" alt="" style="width: 100px; height: 100px;">
        </div>
        <span class="error" id="imgError"></span>

        <label>Họ tên:</label>
        <input type="text" name="hoten">
        <span class="error" id="hotenError"></span>

        <label>Ngày sinh:</label>
        <input type="date" name="date">
        <span class="error" id="dateError"></span>

        <label>Giới tính:</label>
        <input type="radio" name="gender" value="1" checked> Nam
        <input type="radio" name="gender" value="0"> Nữ
        <br><br>

        <label>Địa chỉ:</label>
        <input type="text" name="address">
        <span class="error" id="addressError"></span>

        <label>Số điện thoại:</label>
        <input type="text" name="phone">
        <span class="error"><?= $errors['sdt'] ?? '' ?></span>
        <span class="error" id="phoneError"></span>

        <label>Email:</label>
        <input type="email" name="email">
        <span class="error" id="emailError"></span>

        <label>Ngày vào làm: </label>
        <input type="date" name="ngaylam" value="<?= date('Y-m-d') ?>">
        <span class="error" id="ngaylamError"></span>


        <!-- <label>Lương cơ bản: </label>
        <input type="number" name="luongCB">
        <span class="error" id="luongCBError"></span> -->

       
    
    <label for="branch">Chi nhánh:</label>
    <select name="idCN" required>
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

                    <label for="jobTitle">Chức vụ:</label>
                    <select name="idCV" required>
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
                
                

        <input type="submit" value="Thêm nhân viên" name="addEmployee">
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

    document.addEventListener("DOMContentLoaded", function () {
        let today = new Date().toISOString().split("T")[0];
        document.querySelector("[name='ngaylam']").value = today;
    });

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("form").addEventListener("submit", function (event) {
            var img = document.querySelector('input[name="txtImg"]');
            let hoten = document.querySelector("[name='hoten']").value.trim();
            let ngaySinhInput = document.querySelector("[name='date']").value;
            let gioitinh = document.querySelector("[name='gender']:checked").value;
            let diachi = document.querySelector("[name='address']").value;
            let phone = document.querySelector("[name='phone']").value.trim();
            let email = document.querySelector("[name='email']").value.trim();
            let ngayLam = new Date(document.querySelector("[name='ngaylam']").value);
            let idQUYEN = document.querySelector("select[name='QUYEN']").value;

            console.log("quyen " + idQUYEN);


            // Chặn form submit mặc định
            let isValid = true;

            // Xóa thông báo lỗi cũ
            document.querySelectorAll(".error").forEach(e => e.textContent = "");


            if (img.files.length == 0) {
                document.getElementById("imgError").textContent = "Vui lòng chọn ảnh.";
                isValid = false;
            }

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


            if (ngayLam < today) {
                document.getElementById("ngaylamError").textContent = "Ngày vào làm không được bé hơn ngày hiện tại.";
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
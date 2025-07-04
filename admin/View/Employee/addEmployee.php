<?php
include("../Controller/Employee/addEmployee.php");  // Chỉnh lại đường dẫn đúng
?>

<!-- CSS chung -->
<link rel="stylesheet" href="../../css/admin/OneForAll.css">
<link rel="stylesheet" href="../../css/admin/Employee_add.css">

<body>
    <div class="header">    
        <div class="first-header">
            <p>Thêm nhân viên</p>
        </div>
        <div class="second-header">
            <div class="second-header-main">
                <button class="home">
                    <a href="?page=employeeinfo"> 
                        <i class="fa-solid fa-house home-outline"></i>
                    </a>
                </button>
                <div class="line"></div>
            </div>
        </div>
    </div>  

    <?php
    // Debug section to display any PHP errors
    if (isset($error_message)) {
        echo '<div style="color: red; margin: 10px; padding: 10px; border: 1px solid red;">';
        echo '<strong>Lỗi:</strong> ' . htmlspecialchars($error_message);
        echo '</div>';
    }
    ?>

    <main class="main">
        <div class="container">
            <div class="head-add">
                <a href="?page=employee"><i class="fa-solid fa-arrow-left"></i></a>
                <h3>Thông tin nhân viên</h3>
            </div>

            <form method="post" enctype="multipart/form-data">
                <div class="add-info">
                    <div class="add-img">
                        <img id="img" src="" alt="">
                        <button type="button" onclick="document.getElementById('upload-img').click()">Chọn ảnh</button>
                        <input type="file" id="upload-img" name="txtImg" accept="image/png, image/gif, image/jpeg" onchange="hienThiAnh(event)">
                        <span class="error" id="imgError"></span>
                    </div>

                    <div class="add-info-detail">
                        <div class="add-info-detail-content">
                            <div class="item-info">
                                <div class="item-info-title">
                                    <label>Họ tên:</label>
                                    <input type="text" name="hoten">
                                </div>
                                <span class="error" id="hotenError"></span>
                            </div>

                            <div class="item-info">
                                <div class="item-info-title">
                                    <label>Ngày sinh:</label>
                                    <input type="date" name="date">
                                </div>
                                <span class="error" id="dateError"></span>
                            </div>

                            <div class="item-info">
                                <div class="item-info-title">
                                    <label>Giới tính:</label>
                                    <div class="radio-group">
                                        <div class="radio-item">
                                            <input type="radio" name="gender" value="1" checked> Nam
                                        </div>
                                        <div class="radio-item"> 
                                            <input type="radio" name="gender" value="0"> Nữ
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="item-info">
                                <div class="item-info-title">
                                    <label>Địa chỉ:</label>
                                    <input type="text" name="address">  
                                </div>
                                <span class="error" id="addressError"></span>
                            </div>
                        </div>

                        <div class="add-line"></div>

                        <div class="add-info-detail-content">
                            <div class="item-info">
                                <div class="item-info-title">
                                    <label>Số điện thoại:</label>
                                    <input type="text" name="phone">
                                </div>
                                <span class="error"><?= $errors['sdt'] ?? '' ?></span>
                                <span class="error" id="phoneError"></span>
                            </div>

                            <div class="item-info">
                                <div class="item-info-title">
                                    <label>Email:</label>
                                    <input type="email" name="email">
                                </div>
                                <span class="error" id="emailError"></span>
                            </div>

                            <div class="item-info">
                                <div class="item-info-title">
                                    <label>Ngày vào làm: </label>
                                    <input type="date" name="ngaylam" value="<?= date('Y-m-d') ?>">
                                </div>
                                <span class="error" id="ngaylamError"></span>
                            </div>

                            <div class="item-info">
                                <div class="item-info-title">
                                    <label for="branch">Chi nhánh:</label>
                                    <select name="idCN" required>
                                    <?php
                                        // Kết nối tạm tới 1 chi nhánh (ví dụ: branch1) chỉ để hiển thị danh sách chi nhánh
                                        $conn = getConnection('branch1');  // Không dùng getValidBranch ở đây

                                        $result = sqlsrv_query($conn, "SELECT idCN, ten FROM chdidong.dbo.chinhanh");
                                        if ($result) {
                                        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                            // Nếu có giá trị cũ (khi submit lỗi), giữ lại lựa chọn
                                            $selected = (isset($_POST['idCN']) && $_POST['idCN'] == $row['idCN']) ? 'selected' : '';
                                            echo "<option value='{$row['idCN']}' $selected>{$row['ten']}</option>";
                                        }
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>

                            <div class="item-info">
                                <div class="item-info-title">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="add-button">
                    <input type="submit" value="Thêm nhân viên" name="addEmployee">
                </div>
            </form>
        </div>
    </main>    
</body>

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
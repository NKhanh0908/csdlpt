<?php
include("../View/employee/employeeFilter.php");

// while ($row = mysqli_fetch_array($result)) {
//     $path = "../../images/products/" . $row['IMG'];
//     $row_sp = mysqli_query($conn, "SELECT * from sanpham
//     where idSP={$row['idSP']}");
//     $result_sp = mysqli_fetch_array($row_sp);
// }

$sqll = "SELECT COUNT(*) AS songay FROM ngaynghi WHERE TRANGTHAI = 'Chưa duyệt'";
$result_nn = mysqli_query($conn, $sqll);
$row_nn = mysqli_fetch_assoc($result_nn);
$pendingRequests = $row_nn['songay'];

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách nhân viên</title>
    <!-- CSS chung -->
    <link rel="stylesheet" href="../../css/admin/OneForAll.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            text-align: left;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        table th,
        table td {
            border: 1px solid #e0e0e0;
            padding: 14px 16px;
        }

        table th {
            background-color: #4CAF50;
            color: white;
            /* text-transform: uppercase; */
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .active {
            color: #28a745;
            font-weight: bold;
        }

        .inactive {
            color: #dc3545;
            font-weight: bold;
        }

        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .name-img {
            width: 70px;
            /* Điều chỉnh kích thước theo mong muốn */
            height: 70px;
            object-fit: cover;
            /* Đảm bảo ảnh không bị méo */
            margin-right: 8px;
            vertical-align: middle;
        }

        .action_butt {
            width: 10%;
        }

        .locked td {
            opacity: 0.5;
            /* Làm mờ nội dung hàng */
        }

        /* Giữ nút "Mở khóa" không bị mờ */
        .locked .btn-toggle-status {
            opacity: 1 !important;
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body>
    <div class="header">    
        <div class="first-header">
            <p>Quản lý nhân viên</p>
        </div>
        <div class="second-header">
            <div class="second-header-main">
                <button class="home">
                    <a href="?page=employeeinfo"> 
                        <i class="fa-solid fa-house home-outline"></i>
                    </a>
                </button>
                <div class="line"></div>
                <a href="?page=add_employee" class="add-btn">
                    <button>Thêm nhân viên</button>
                </a>

                <!-- Nút nè viết đi -->
                <a href="../View/employee/TakeLeave.php">
                    <button>Nghỉ lễ</button>
                </a>
                <a href="../View/employee/requestLeave.php">
                <button>
                    Nghỉ phép
                    <?php if ($pendingRequests > 0): ?>
                        <span style="color: red; font-weight: bold; margin-left: 5px;">
                            (<?= $pendingRequests ?>)
                        </span>
                    <?php endif; ?>
                </button>
                <a href="#">
                    <button>Lịch tăng ca</button>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Nội dung chính -->
    <main class="main">
        <div class="container">
            <h2>Danh sách nhân viên</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <!-- <th>Username</th> -->
                <th>Họ Tên</th>
                <th>Ngày sinh</th>
                <th>Giới tính</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Ngày vào làm</th>
                <th>Lương cơ bản</th>
                <th>Vị trí làm việc</th>
                <th class='action_butt'>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php $employees = mysqli_fetch_all($result, MYSQLI_ASSOC); ?>
            <?php if (count($employees) > 0): ?>
                <?php foreach ($employees as $row):
                    $path = "../../images/employee/" . $row['IMG'];
                    ?>
                    <tr>
                        <td><?= $row['idTK'] ?></td>
                        <td>
                            <img class='name-img' src="<?= $path ?>">
                            <?= htmlspecialchars($row['HOTEN']) ?>
                        </td>
                        <td><?= htmlspecialchars($row['NGAYSINH']) ?></td>
                        <td><?= htmlspecialchars($row['GIOITINH']) == 0 ? "Nữ" : "Nam" ?></td>
                        <td><?= htmlspecialchars($row['SDT']) ?></td>
                        <td><?= htmlspecialchars($row['EMAIL']) ?></td>
                        <td><?= htmlspecialchars($row['DIACHI']) ?></td>
                        <td><?= htmlspecialchars($row['NGAYVAOLAM']) ?></td>
                        <td><?= htmlspecialchars($row['LUONGCB']) ?></td>
                        <td><?= $row['TENQUYEN'] ?></td>
                        <td class='btn-action'>
                            <?php if ($row['TRANGTHAI'] == 1): ?>
                                <form action='../View/employee/updateEmployee.php' method='POST'>
                                    <input type='hidden' name='idTK' value='<?= $row['idTK'] ?>'>
                                    <button type='submit' class='btn-update' name="update">Cập nhật</button>
                                </form>
                            <?php endif; ?>

                            <button type='button' class='btn-toggle-status' data-id='<?= $row['idTK'] ?>'
                                style="background-color: <?= $row['TRANGTHAI'] == 1 ? 'red' : 'green' ?>;">
                                <?= $row['TRANGTHAI'] == 1 ? "Khóa" : "Mở khóa" ?>
                            </button>

                        </td>
                    </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" style="text-align:center;">Hiện tại cửa hàng chưa có nhân viên nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".btn-toggle-status").forEach(button => {
            button.addEventListener("click", function () {
                let idTK = this.getAttribute("data-id");
                let row = this.closest("tr");
                let currentStatus = this.innerText.trim();
                let updateButton = row.querySelector(".btn-update");

                // Gửi yêu cầu AJAX để cập nhật trạng thái
                fetch("../Controller/employee/toggleStatus.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `idTK=${idTK}`
                })
                    .then(response => response.text())
                    .then(data => {
                        if (data.trim() === "success") {
                            if (currentStatus === "Khóa") {
                                this.innerText = "Mở khóa";
                                this.style.backgroundColor = "green";
                                row.classList.add("locked"); // Thêm class làm mờ nội dung
                                if (updateButton) updateButton.style.display = "none"; // Ẩn nút cập nhật
                            } else {
                                this.innerText = "Khóa";
                                this.style.backgroundColor = "red";
                                row.classList.remove("locked"); // Bỏ làm mờ
                                if (updateButton) updateButton.style.display = "inline-block"; // Hiện lại nút cập nhật
                            }
                        } else {
                            alert("Lỗi: " + data);
                        }
                    })
                    .catch(error => console.error("Lỗi:", error));
            });
        });
    });
</script>
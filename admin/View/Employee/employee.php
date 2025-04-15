<?php
include_once './../Controller/connector.php';

// $sqll = "SELECT COUNT(*) AS songay FROM ngaynghi WHERE TRANGTHAI = 'Chưa duyệt'";
// $result_nn = mysqli_query($conn, $sqll);
// $row_nn = mysqli_fetch_assoc($result_nn);
// $pendingRequests = $row_nn['songay'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách nhân viên</title>
    <link rel="stylesheet" href="../../css/admin/OneForAll.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        table th, table td {
            border: 1px solid #e0e0e0;
            padding: 14px 16px;
        }

        table th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .name-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            margin-right: 8px;
            vertical-align: middle;
            border-radius: 50%;
        }

        .action_butt {
            width: 10%;
        }

        .locked td {
            opacity: 0.5;
        }

        .locked .btn-toggle-status {
            opacity: 1 !important;
            position: relative;
            z-index: 1;
        }

        /* Style cho bộ lọc */
        .filter-container {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .filter-container label {
            font-weight: 500;
            margin-right: 5px;
        }

        .filter-container select {
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .btn-update {
            background-color: #007bff;
            color: white;
            margin-right: 5px;
        }

        .btn-update:hover {
            background-color: #0069d9;
        }

        .btn-toggle-status {
            color: white;
        }

        .btn-add {
            background-color: #28a745;
            color: white;
        }

        .btn-add:hover {
            background-color: #218838;
        }

        .statistics {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            flex: 1;
            padding: 15px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .stat-card h3 {
            margin-top: 0;
            color: #6c757d;
        }

        .stat-card p {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 0;
            color: #343a40;
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


                
                <div class="filter-container">
                    <label for="filterBranch">Lọc theo chi nhánh:</label>
                    <select id="filterBranch">
                        <option value="all">Tất cả chi nhánh</option>
                        <option value="branch1">Chi nhánh 1</option>
                        <option value="branch2">Chi nhánh 2</option>
                        <option value="branch3">Chi nhánh 3</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Nội dung chính -->
    <main class="main">
        <div class="container">
            <h2>Danh sách nhân viên</h2>
            
            <!-- Thống kê -->
            <div class="statistics">
                <div class="stat-card">
                    <h3>Tổng số nhân viên</h3>
                    <p id="totalEmployees">0</p>
                </div>
                <div class="stat-card">
                    <h3>Đang hoạt động</h3>
                    <p id="activeEmployees">0</p>
                </div>
                <div class="stat-card">
                    <h3>Đã khóa</h3>
                    <p id="inactiveEmployees">0</p>
                </div>
            </div>
            
            <!-- Bảng nhân viên sẽ được load bằng JS -->
            <div id="employeeTableContainer"></div>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Load dữ liệu ban đầu
            loadEmployees();
            
            // Sự kiện thay đổi bộ lọc
            document.getElementById("filterBranch").addEventListener("change", function() {
                loadEmployees();
            });
        });

        // Hàm load nhân viên theo bộ lọc
        function loadEmployees() {
            let branchValue = document.getElementById("filterBranch").value;
            
            fetch(`../Controller/Employee/EmployeeInfoController.php?branch=${branchValue}`)
                .then(response => response.json())
                .then(employees => {
                    renderEmployeeTable(employees);
                    updateStatistics(employees);
                })
                .catch(error => {
                    console.error("Lỗi tải nhân viên:", error);
                    document.getElementById("employeeTableContainer").innerHTML = 
                        `<div class="alert alert-danger">Đã xảy ra lỗi khi tải dữ liệu nhân viên</div>`;
                });
        }

        // Hàm render bảng nhân viên
        function renderEmployeeTable(employees) {
            let html = `<table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Họ Tên</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Chi nhánh</th>
                        <th>Ngày vào làm</th>
                     
                        <th>Vị trí làm việc</th>
                        <th class='action_butt'>Hành động</th>
                    </tr>
                </thead>
                <tbody>`;

            if (employees.length > 0) {
                employees.forEach(employee => {
                    console.log(employee);
                    let path = "../../images/employee/" + (employee.IMG || 'default.jpg');
                    let gender = employee.GIOITINH == 0 ? "Nữ" : "Nam";
                    
                    html += `<tr ${employee.TRANGTHAI == 0 ? 'class="locked"' : ''}>
                        <td>${employee.idTK}</td>
                        <td>
                            <img class='name-img' src="${path}" alt="${employee.HOTEN}">
                            ${employee.HOTEN}
                        </td>
                        <td>${employee.NGAYSINH}</td>
                        <td>${gender}</td>
                        <td>${employee.SDT}</td>
                        <td>${employee.EMAIL}</td>
                        <td>${employee.TEN_CHI_NHANH || 'Chưa xác định'}</td>
                        <td>${employee.NGAYVAOLAM}</td>
                         <td>${employee.tenCV}</td>
    
                        <td class='btn-action'>
                            ${employee.TRANGTHAI == 1 ? 
                                `
                                    <a href="../View/employee/updateEmployee.php?idTK=${employee.idTK}&idCN=${employee.idCN}" class='btn btn-update' name="update">Cập nhật</a>
                                ` : ''}
                            <button type='button' class='btn btn-toggle-status' data-id='${employee.idTK}'
                                style="background-color: ${employee.TRANGTHAI == 1 ? '#dc3545' : '#28a745'}">
                                ${employee.TRANGTHAI == 1 ? "Khóa" : "Mở khóa"}
                            </button>
                        </td>
                    </tr>`;
                });
            } else {
                html += `<tr>
                    <td colspan="11" style="text-align:center;">Không tìm thấy nhân viên nào.</td>
                </tr>`;
            }

            html += `</tbody></table>`;
            
            document.getElementById("employeeTableContainer").innerHTML = html;
            
            // Gắn lại sự kiện cho các nút toggle status
            attachToggleStatusEvents();
        }

        // Hàm cập nhật thống kê
        function updateStatistics(employees) {
            const total = employees.length;
            const active = employees.filter(e => e.TRANGTHAI == 1).length;
            const inactive = total - active;
            
            document.getElementById("totalEmployees").textContent = total;
            document.getElementById("activeEmployees").textContent = active;
            document.getElementById("inactiveEmployees").textContent = inactive;
        }

        // Hàm định dạng tiền tệ
        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', { 
                style: 'currency', 
                currency: 'VND' 
            }).format(amount);
        }

        // Hàm gắn lại sự kiện cho các nút toggle status
        function attachToggleStatusEvents() {
            document.querySelectorAll(".btn-toggle-status").forEach(button => {
                button.addEventListener("click", function() {
                    const idTK = this.getAttribute("data-id");
                    const row = this.closest("tr");
                    const currentStatus = this.innerText.trim();
                    const updateButton = row.querySelector(".btn-update");
                    const isLocking = currentStatus === "Khóa";

                    if (isLocking && !confirm('Bạn có chắc chắn muốn khóa tài khoản này?')) {
                        return;
                    }

                    fetch("../Controller/employee/toggleStatus.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: `idTK=${idTK}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data.trim() === "success") {
                            // Reload lại dữ liệu để cập nhật giao diện
                            loadEmployees();
                        } else {
                            alert("Lỗi: " + data);
                        }
                    })
                    .catch(error => console.error("Lỗi:", error));
                });
            });
        }
    </script>
</body>
</html>
<?php
include_once './../Controller/connector.php';

// $sqll = "SELECT COUNT(*) AS songay FROM ngaynghi WHERE TRANGTHAI = 'Chưa duyệt'";
// $result_nn = mysqli_query($conn, $sqll);
// $row_nn = mysqli_fetch_assoc($result_nn);
// $pendingRequests = $row_nn['songay'];
?>

<link rel="stylesheet" href="../../css/admin/OneForAll.css">
<link rel="stylesheet" href="../../css/admin/Employee_Page.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                    <select id="filterBranch" class="filter-select-branch-employee">
                        <option value="all">Tất cả chi nhánh</option>
                        <option value="branch2">Chi nhánh 1</option>
                        <option value="branch3">Chi nhánh 2</option>
                        <option value="branch4">Chi nhánh 3</option>
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
                    console.log(employees);
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
                        <th>Email</th>
                        <th>Chi nhánh</th>
                     
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

                            ${employee.HOTEN}
                        </td>
                        <td>${employee.NGAYSINH}</td>
                        <td>${gender}</td>
                        <td>${employee.EMAIL}</td>
                        <td>${employee.TEN_CHI_NHANH || 'Chưa xác định'}</td>
                         <td>${employee.tenCV}</td>
    
                        <td class='btn-action'>
                            ${employee.TRANGTHAI == 1 ? 
                                `
                                    <a href="?page=updateEmployee&idTK=${employee.idTK}&idCN=${employee.idCN}" class='btn btn-update' name="update">Cập nhật</a>
                                ` : ''}
                            <button type='button' class='btn btn-toggle-status' data-id='${employee.idTK}' data-idCN='${employee.idCN}'
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
                    const idCN = this.getAttribute("data-idCN");
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
                        body: `idTK=${idTK}&idCN=${idCN}`
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
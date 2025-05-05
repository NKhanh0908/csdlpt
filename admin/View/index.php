<?php
include "checkLogin.php";  // Đúng - cùng thư mục

$avt_img="";
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $idNV = $_SESSION['idNV'] ?? null;
    error_log("ID NV: " . $idNV);

    include '../Controller/connector.php';
    $connector = getConnection("branch2");

    $sql = "SELECT [idTK], [GIOITINH], [NGAYSINH], [DIACHI], [IMG], [NGAYVAOLAM], [TINHTRANG], [idCN], [idCV], [rowguid]
            FROM [chdidong].[dbo].[nhanvien] WHERE idTK = ?";
    $params = [$idNV];

    $result = sqlsrv_query($connector, $sql, $params);

    if ($result === false) {
        error_log("SQL error: " . print_r(sqlsrv_errors(), true));
    } else {
        $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

        if ($row) {
            $avt_img = $row['IMG'];
            error_log("IMG path: " . $avt_img);
        } else {
            error_log("Không tìm thấy nhân viên với idTK = $idNV");
        }
    }
    $sql = "SELECT [idTK]
            ,[GIOITINH]
            ,[NGAYSINH]
            ,[DIACHI]
            ,[IMG]
            ,[NGAYVAOLAM]
            ,[TINHTRANG]
            ,[idCN]
            ,[idCV]
            ,[rowguid]
        FROM [chdidong].[dbo].[nhanvien] WHERE idTK = . $idNV";
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
<title>Admin Control Panel</title>
<link rel="stylesheet" href="../../css/admin/index.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-logo">
            <img src="../../images/system/logo copy.png" alt="" class="logo">
            <div class="logo-name">MyPow Store</div>
            <i class="fa-solid fa-angle-left" id="btn-menu"></i>
        </div>
        <div class="avt">
            <img id="img-avt" src="<?=$avt_img?>" alt="Ảnh đại diện">
            <p id="name-menu"></p>
            <p id="position-menu"></p>
        </div>
        <ul class="nav-list">
        <li>
                <?php if (checkPermission('Thống kê')): ?>
                    <a href="?page=statics" data-page="statics">
                        <i class="fa-solid fa-chart-line"></i>
                        <span class="links-name">Thống kê</span>
                    </a>
                    <span class="tooltip">Thống kê</span>
                <?php endif; ?>
            </li>
            <li class="detail-order-effect">
                <?php if (checkPermission('Đơn hàng')): ?>
                    <a href="?page=order" data-page="order">
                        <i class="fa-solid fa-receipt"></i>
                        <span class="links-name">Đơn hàng</span>
                    </a>
                    <span class="tooltip">Đơn hàng</span>
                <?php endif; ?>
            </li>
            <li>
                <?php if (checkPermission('Nhà cung cấp')): ?>
                    <a href="?page=provider" data-page="provider">
                        <i class="fa-solid fa-truck-field"></i>
                        <span class="links-name">Nhà cung cấp</span>
                    </a>
                    <span class="tooltip">Nhà cung cấp</span>
                <?php endif; ?>
            </li>
            <li>
                <?php if (checkPermission('Phiếu nhập')): ?>
                    <a href="?page=phieunhap" data-page="phieunhap">
                        <i class="fa-solid fa-file-invoice"></i>
                        <span class="links-name">Phiếu nhập</span>
                    </a>
                    <span class="tooltip">Phiếu nhập</span>
                <?php endif; ?>
            </li>
            <li>
                    <a href="?page=kho" data-page="kho">
                        <i class="fa-solid fa-warehouse"></i>
                        <span class="links-name">Kho</span>
                    </a>
                    <span class="tooltip">Kho</span>
            </li>
            <li>
                <?php if (checkPermission('Nhân viên')): ?>
                    <a href="?page=employee" data-page="employee">
                        <i class="fa-solid fa-users"></i>
                        <span class="links-name">Nhân viên</span>
                    </a>
                    <span class="tooltip">Nhân viên</span>
                <?php endif; ?>
            </li>
            <li>
                <?php if (checkPermission('Tài khoản')): ?>
                    <a href="?page=account" data-page="account">
                        <i class="fa-solid fa-user-gear"></i>
                        <span class="links-name">Tài khoản</span>
                    </a>
                    <span class="tooltip">Tài khoản</span>
                <?php endif; ?>
            </li>
        </ul>
        
    </div>
    <a href="logout.php" class="log-out hidden-log-out">
        <i class="fa-solid fa-right-from-bracket"></i>
        <span>Đăng xuất</span>
    </a>
    <div class="content">
    <?php
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 'employee';
            }

            switch ($page) {
                case 'statics':
                    include(__DIR__ . "/thongke.php");
                    break;
                case 'product':
                    include(__DIR__ . "/Product/ProductView.php");
                    break;
                case 'order':
                    include(__DIR__ . "/order/order.php");
                    break;
                case 'orderdetail':
                    if (isset($_GET['idHD'])) {
                        include "order/orderdetail.php";
                    } else {
                        echo "<p style='color:red;'>Không tìm thấy đơn hàng</p>";
                    }
                    break;
                case 'tonkhodetail':
                    if (!isset($_GET['idKho']) || !isset($_GET['branch'])) {
                        die("Không nhận được thông tin kho hoặc chi nhánh!");
                    } else {
                        include("kho/tonkho_detail.php");
                    }
                        break;
                case 'provider':
                    include(__DIR__ . "/Provider/ProviderView.php");
                    break;
                case 'calendar':
                    include "calendar.php";
                    break;
                case 'kho':
                    include(__DIR__ . "/kho/index.php");
                    break;
                case 'voucher':
                    include "voucher/voucher.php";
                    break;
                case 'edit_voucher':
                    break;
                case 'add_voucher':
                    include "voucher/add_voucher.php";
                    break;
                case 'employeeinfo':
                    include(__DIR__ . "/Employee/EmployeeInfo.php");
                    break;
                case 'role':
                    include "role/role.php";
                    break;
                case 'account':
                    include "account/account.php";
                    break;
                case 'employee':
                    include "employee/employee.php";
                    break;
                case 'updateEmployee':
                    if (isset($_GET['idTK'])) {
                        include "employee/updateEmployee.php";
                    } else {
                        echo "<p style='color:red;'>Không tìm thấy ID nhân viên</p>";
                    }
                    break;
                case 'add_account':
                    include "account/add_account.php";
                    break;
                case 'phieunhap':
                    include(__DIR__ . "/Receipt/ReceiptView.php");
                    break;
                case 'refund_requests':
                    include(__DIR__ . "/refund/refund_requests.php");
                    break;
                case 'add_employee':
                    include "Employee/addEmployee.php";
                    break;
                default:
                    echo "<h2>Không tìm thấy trang!</h2>";
                    break;
            }
        ?>
    </div>
</body>
<script src="../../js/admin/index.js"></script>
</html>
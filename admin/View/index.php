<?php
include "checkLogin.php";  // Đúng - cùng thư mục

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/admin/showProduct_admin.css">
    <link rel="stylesheet" href="/css/admin/order.css">
    <link rel="stylesheet" href="/css/admin/index.css">
    <title>Admin Control Panel</title>
    
</head>
<body>

    <div class="sidebar">

        <h4>Menu</h4>
        <?php if (checkPermission('Thong ke')): ?>
            <a href="?page=statics">Thống kê</a>
        <?php endif; ?>
        <?php if (checkPermission('Sản phẩm')): ?>
          
        <?php endif; ?>
        <?php if (checkPermission('Đơn hàng')): ?>
            <a href="?page=order">Đơn hàng</a>
        <?php endif; ?>
        <?php if (checkPermission('Nhà cung cấp')): ?>
            <a href="?page=provider">Nhà cung cấp</a>
        <?php endif; ?>
        <!-- ======================== -->
                <?php if (checkPermission('Khuyen mai')): ?>
                    <a href="?page=voucher">Khuyến mãi</a>
                <?php endif; ?>
                <?php if (checkPermission('Thông tin nhân viên')): ?>
                    <a href="?page=employeeinfo">Thông tin nhân viên</a>
                <?php endif; ?>   

                <!-- <?php if (checkPermission('Phân quyền')): ?>
                    <a href="?page=role">Phân quyền</a>
                <?php endif; ?> -->
        <!-- ======================== -->
        <!-- <?php if (checkPermission('Tài khoản')): ?>
            <a href="?page=account">tài khoản</a> -->
        <?php endif; ?>
        <?php if (checkPermission('Phiếu nhập')): ?>
            
        <?php endif; ?>
        <a href="?page=product">Sản phẩm</a>
        <a href="?page=phieunhap">Phiếu nhập</a>
        <!-- ======================== -->

               <!--  <a href="?page=employeeinfo">Thông tin nhân viên</a>

                <a href="?page=calendar">Lịch làm việc</a> -->
        <!-- ======================== -->

        <a href="logout.php" style="color: white; background: crimson; text-align: center; margin-top: 20px;">Đăng xuất</a>

    </div>

    <div class="content">
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];

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
                    include"order/orderdetail.php";
                    } else {
                        echo "<p style='color:red;'>Không tìm thấy đơn hàng</p>";
                        }
                    break;
                case 'provider':
                    include(__DIR__ . "/Provider/ProviderView.php");
                    break;
                case 'calendar':
                    include "calendar.php";
                    break;
                case 'voucher':
                    include "voucher/voucher.php";
                    break;
                case 'employeeinfo':
                    include (__DIR__ . "/Employee/EmployeeInfo.php");
                    break;
                case 'role':
                    include "role/role.php";
                    break;
                case 'account':
                    include "account/account.php";
                    break;
                case 'add_account':
                    include "account/add_account.php";
                    break;
                case 'phieunhap':
                    include (__DIR__ . "/Receipt/ReceiptView.php");
                    break;
                default:
                    echo "<h2>Không tìm thấy trang!</h2>";
                    break;
            }
        } else {
            echo "<h2>Chào mừng đến trang quản trị!</h2>";
        }
        ?>

    </div>
</body>
</html>

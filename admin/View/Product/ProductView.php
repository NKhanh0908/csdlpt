<link rel="stylesheet" href="/css/admin/Product.css">
<?php
include_once(__DIR__ . "/../../../Model/db_connect.php");
include_once(__DIR__ . "/../../Controller/role/role.php");

$db = new Database();
$conn = $db->connect();

if (!isset($_SESSION['role'])) {
    die("Bạn chưa đăng nhập hoặc không có quyền truy cập.");
}

$coQuyenThem = kiemTraQuyen($conn, $_SESSION['role'], 1, 'THEM');  // Đã truyền đúng thứ tự

?>

<h1>Quản lý sản phẩm</h1><br>
<?php 
include('../Controller/connectDB.php'); 
?>

<div class='containers'>
    <?php
        if(isset($_GET['chon'])){
            $select = $_GET['chon'];
            switch ($select) {
                case 'list': include('ProductList.php'); break;
                case 'Add': include('../Controller/Product/AddProductController.php'); break;
                case 'Remove':
                case 'Restore': include('../Controller/Product/RemoveProductController.php'); break;
                case 'Update': include('../Controller/Product/UpdateProductController.php'); break;
                default: include('ProductList.php'); break;
            }
        }else{
            include('ProductList.php'); 
        }
    ?>
</div>

<?php
include('../../Controller/connectDB.php');
$conn = getConnection();
include_once(__DIR__ . "/../../Controller/role/role.php");
 

if (!isset($_SESSION['role'])) {
    die("Bạn chưa đăng nhập hoặc không có quyền truy cập.");
}

$coQuyenThem = kiemTraQuyen($conn, $_SESSION['role'], 1, 'THEM');  // Đã truyền đúng thứ tự

?>

<script src="/js/admin/addProduct.js"></script>
<link rel="stylesheet" href="/css/admin/add_product.css">

<form action="" method="POST" enctype="multipart/form-data" class="addsp">
<?php if ($coQuyenThem): ?>
<h1>Thêm sản phẩm</h1>
<?php endif; ?>
    <div class="container">
        <label for="">Tên sản phẩm</label><br>
        <input type="text" name="txtTensp" 
        placeholder="Nhập tên sản phẩm."><br>
        <p name="varTen" style="visibility: hidden;">Vui lòng nhập tên sản phẩm</p>

        <label for="txtHang">Hãng</label><br>
        <!-- Lấy ra Hãng -->
        <?php
            $sql_hang=mysqli_query($conn,"SELECT * FROM hang ORDER BY idHANG DESC");
        ?>
        <select name="txtHang">
            <option value="0">--Chọn Hãng--</option>
            <?php 
                while($row_hang=mysqli_fetch_array($sql_hang))
                {     
            ?>
            <option value="<?php echo $row_hang["idHANG"]?>">
                <?php echo $row_hang["TENHANG"]?></option>
                <?php ;} ?>
        <!-- Lấy ra Hãng -->
        </select><br>
        <p name="varHang" style="visibility: hidden;">Vui lòng chọn Hãng</p>

        <label for="txtGianhap">Giá nhập</label><br>
        <input type="text" name="txtGianhap"><br> 
        <p name="varGia" style="visibility: hidden;">Vui lòng nhập giá cho sản phẩm</p>

        <label for="txtDanhmuc">Danh mục</label><br>
        <!-- Lấy ra danh mục -->
        <?php
            $sql_danhmuc=mysqli_query($conn,"SELECT *FROM danhmuc ORDER BY idDM DESC");
        ?>
        <select name="txtDanhmuc" >
            <option value="0">--Chọn danh mục--</option>
            <?php
            while($row_danhmuc=mysqli_fetch_array($sql_danhmuc))
            { ?>
            <option value="<?php echo $row_danhmuc["idDM"]?>">
                <?php echo $row_danhmuc["LOAISP"]?></option>
                <?php ;} ?>
        <!-- Lấy ra danh mục -->
        </select><br>  
        <p name="varDanhmuc" style="visibility: hidden;">Vui lòng chọn danh mục cho sản phẩm</p>    

        <label for="txtMotasp">Mô tả</label><br>
        <textarea type="text" name="txtMotasp" 
        placeholder="Nhập mô tả cho sản phẩm."></textarea><br>
        
        <label for="txtImg">Hình ảnh</label><br>
        <input type="file" name="txtImg" accept="image/png, image/gif, image/jpeg"
        onchange="hienThiAnh(event)"><br>
        <div>
            <img id="img" src="" alt="" style="width: 100px; height: 100px;">
        </div>
        <p name="varImg" style="visibility: hidden;">
            Vui lòng chọn hình ảnh cho sản phẩm</p>  

        <div>
        
            <button type="submit" name="Add-SP">Thêm sản phẩm</button>
 
            <button class="btn-cancel" name="Cancel">
                <a href="../View/index.php?page=product&chon=list">Hủy</a> 
            </button>
        </div>
    </div>
</form>

<script src="/js/admin/Provider.js"></script>
<link rel="stylesheet" href="/css/admin/Provider.css">

<form action="" method="POST" enctype="multipart/form-data" class="addncc">
<h1>Thêm nhà cung cấp</h1>
    <div class="container">
        <label for="">Tên nhà cung cấp:</label><br>
        <input type="text" name="txtTenNcc" 
        placeholder="Nhập tên nhà cung cấp.."><br>
        <p name="varTen" style="visibility: hidden;">Vui lòng nhập tên nhà cung cấp</p>

        <label for="">Số địn họi</label><br>
        <input type="text" name="txtSDT" 
        placeholder="Nhập số điện thoại.."><br>
        <p name="varSdt" style="visibility: hidden;">Số địn họi không hợp lệ</p>

        <label for="txtDiachi">Địa chỉ</label><br>
        <textarea type="text" name="txtDiachi" 
        placeholder="Nhập mô tả cho sản phẩm."></textarea><br>
        <p name="varDiachi" style="visibility: hidden;">Vui lòng nhập địa chỉ</p>

        <div>
            <button type="submit" name="Add-NCC">Thêm</button>
            <button class="btn-cancel" name="Cancel">
                <a href="/admin/View/index.php?page=provider&chon=list">Hủy</a> 
            </button>
        </div>
    </div>
</form>
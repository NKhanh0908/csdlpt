<link rel="stylesheet" href="/css/admin/Provider.css">
<script src="/js/admin/Provider.js"></script>

<form action="" method="POST" enctype="multipart/form-data" class="form-update-ncc">
<h1>Cập nhật Nhà cung cấp: <?php echo $row_ncc['idNCC']?></h1>
    <div class="container-update">
        <div id="update-left">
        <label for="">Tên Nhà cung cấp: </label>
        <input type="text" name="txtTenNcc" 
            value="<?php echo $row_ncc['TENNCC']?>">
        <p class="var" name="varTen" style="visibility: hidden;">
            Vui lòng nhập tên Nhà cung cấp</p>
   
        <label for="">Số địn họi: </label>
        <input type="text" name="txtSDT" 
            value="<?php echo $row_ncc['SDT']?>">
        <p class="var" name="varSdt" style="visibility: hidden;">
            Vui lòng nhập số địn họi</p>

        <label for="txtDiachi">Địa chỉ: </label>
        <textarea type="text" name="txtDiachi"><?php echo $row_ncc["DIACHI"]?></textarea><br>
        <p class="var" name="varDiachi" style="visibility: hidden;">
            Vui lòng nhập địa chỉ</p>

        </div>
        <div class='confirm-div'>
            <button class="btn-cf" type="submit" name="ConfirmUpdate">Xác nhận</button>
            <button class="btn-cancel">
                <a href="/admin/View/index.php?page=provider&chon=list">Hủy</a> 
            </button>   
        </div>
</form>
<link rel="stylesheet" href="/css/admin/Product.css">
<script src="/js/admin/Product.js"></script>

<form action="" method="POST" enctype="multipart/form-data" class="form-update-sp">
<h1>Cập nhật sản phẩm: <?php echo $row_sanpham['idSP']?></h1>
    <input type="hidden" name="img-name" value="<?php echo $row_sanpham['IMG']?>">
    <div class="container-update">
        <div id="update-left">
        <label for="">Tên sản phẩm</label><br>
        <input type="text" name="Tensp" 
            value="<?php echo $row_sanpham['TENSP']?>">
        <p class="var" name="varTen" style="visibility: hidden;">
            Vui lòng nhập tên sản phẩm</p>

        <label for="Hang">Hãng</label><br>
        <?php
            $sql_hang = mysqli_query($conn,"SELECT * FROM hang
            ORDER BY idHANG DESC");
        ?>
        <select name="Hang">
            <option value="<?php echo $row_sanpham['idHANG']?>"><?php echo $row_sanpham['TENHANG']?></option>
            <?php
                while($row_hang=mysqli_fetch_array($sql_hang))
                {     
            ?>
            <option value="<?php echo $row_hang["idHANG"]?>">
                <?php echo $row_hang["TENHANG"]?></option>
                <?php ;} ?>
        </select>
        <p class="var" name="varHang" style="visibility: hidden;">
            Vui lòng chọn Hãng</p>

        <label for="Danhmuc">Danh mục</label><br>
        <?php
            $sql_danhmuc=mysqli_query($conn,"SELECT * 
            FROM danhmuc ORDER BY idDM DESC");
        ?>
        <select name="Danhmuc" >
            <option value="<?php echo $row_sanpham['idDM']?>"><?php echo $row_sanpham['LOAISP']?></option>
            <?php
            while($row_danhmuc=mysqli_fetch_array($sql_danhmuc))
            { ?>
            <option value="<?php echo $row_danhmuc["idDM"]?>">
                <?php echo $row_danhmuc["LOAISP"]?></option>
                <?php ;} ?>
        </select> 
        <p class="var" name="varDanhmuc" style="visibility: hidden;">
            Vui lòng chọn danh mục cho sản phẩm</p>    


        <label for="Motasp">Mô tả</label><br>
        <textarea type="text" name="Motasp"><?php echo $row_sanpham["MOTA"]?></textarea><br>

        <label for="GiamGia">Mức giảm</label><br>
        <input type="text" name="GiamGia" 
            value="<?php echo $row_sanpham['DISCOUNT']?>">% 
        <p class="var" name="varDiscount" style="visibility: hidden;">
            Vui lòng nhập mức giảm giá cho sản phẩm</p>

        </div>
        <div id="update-middle">
            <p name="soluong">Số lượng: <?php echo $row_sanpham['SOLUONG']?></p>
            <p name="Gianhap">Giá nhập: <?php echo $row_sanpham['GIANHAP']?></p>
            <p name="giaban">Giá bán hiện tại: <?php echo $row_sanpham['GIA']?> </p>
            <p name="loinhuan">Lợi nhuận: <?php 

            echo ($row_sanpham['GIA'] / $row_sanpham['GIANHAP'])*100 - 100?>%</p>
        </div>

        <div id="update-right">
            <label for="Img">Hình ảnh</label><br>
            <div>
                <img id="img" src="/images/products/<?php echo $row_sanpham["IMG"]  ?>" alt="">
                <!-- <script> console.log("<?php echo $path ?>");</script> -->
            </div>
                <input type="file" name="Img" accept="image/png, image/gif, image/jpeg"
                onchange="hienThiAnh(event)">

            </div>
        </div>

        <div class='confirm-div'>
            <button class="btn-cf" type="submit" name="ConfirmUpdate">Xác nhận</button>
            <button class="btn-cancel">
                <a href="../View/index.php?page=product&chon=list">Hủy</a> 
            </button>   
        </div>
</form>
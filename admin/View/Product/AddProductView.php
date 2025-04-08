
<?php
include_once './../Controller/connector.php';
$conn = getConnection("branch2");
?>

<script src="../../js/admin/Product.js"></script>
<link rel="stylesheet" href="/css/admin/add_product.css">

<form action="" method="POST" enctype="multipart/form-data" class="addsp" id="add_product">
<h1>Thêm sản phẩm</h1>
    <div class="container">

    <label for="">Chọn chi nhánh</label><br>
        <select name="choose-branch" id="branch">
            <option value="branch2">--Chi nhánh 1--</option>
            <option value="branch3">--Chi nhánh 2--</option>
            <option value="branch4">--Chi nhánh 3--</option>
        </select>

        <label for="">Tên sản phẩm</label><br>
        <input type="text" name="txtTensp" 
        placeholder="Nhập tên sản phẩm." id="txtTensp"><br>
        <p name="varTen" style="visibility: hidden;">Vui lòng nhập tên sản phẩm</p>

              <!-- Dropdown danh mục và hãng sẽ được render bằng JS -->
      <div id="dropdowns">
        <label for="txtDanhmuc">Danh mục</label><br>
        <select name="txtDanhmuc" id="danhmuc">
          <option value="0">--Chọn danh mục--</option>
        </select>
        
        <label for="txtHang">Hãng</label><br>
        <select name="txtHang" id="hang">
          <option value="0">--Chọn Hãng--</option>
        </select>
      </div>

        <label for="txtGianhap">Giá nhập</label><br>
        <input type="text" name="txtGianhap" id="txtGianhap"><br> 
        <p name="varGia" style="visibility: hidden;">Vui lòng nhập giá cho sản phẩm</p>

        

        <label for="txtMotasp">Mô tả</label><br>
        <textarea type="text" name="txtMotasp" 
        placeholder="Nhập mô tả cho sản phẩm." id="txtMotasp"></textarea><br>
        
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

<script>
    window.onload = function(){
        fetchDanhMucHang();
    }

    document.getElementById('branch').addEventListener('change', function(e){
      let branch = document.getElementById('branch').value;
      fetchDanhMucHang(branch);
    });

    document.getElementById('add_product').addEventListener('submit', function (e) {
    e.preventDefault();

    var formData = new FormData();
    var txtTensp = document.querySelector('input[name="txtTensp"]').value;
    var txtHang = document.querySelector('select[name="txtHang"]').value;
    var txtDanhmuc = document.querySelector('select[name="txtDanhmuc"]').value;
    var txtGianhap = document.querySelector('input[name="txtGianhap"]').value;
    var txtMotasp = document.querySelector('textarea[name="txtMotasp"]').value;
    var branch = document.querySelector('select[name="choose-branch"]').value;
    var fileInput = document.querySelector('input[name="txtImg"]');
    
    // Kiểm tra nếu có file được chọn
    if (fileInput.files.length > 0) {
        formData.append('txtImg', fileInput.files[0]); 
    } else {
        alert('Vui lòng chọn hình ảnh.');
        return;
    }

    // Thêm dữ liệu vào FormData
    formData.append('txtTensp', txtTensp);
    formData.append('txtHang', txtHang);
    formData.append('txtDanhmuc', txtDanhmuc);
    formData.append('txtGianhap', txtGianhap);
    formData.append('txtMotasp', txtMotasp);
    formData.append('branch', branch);

    console.log("Form Data:");
    formData.forEach((value, key) => {
        console.log(key + ':', value);
    });



    // Gửi request bằng fetch
    fetch('./../Controller/Product/ProductCreate.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            console.log(data);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

    function fetchDanhMucHang(branch="branch2"){
      fetch(`./Product/GetInfoProduct.php?branch=${branch}`)
        .then(response => response.json())
        .then(data => {
          if(data.success){
            console.log(data)
            renderInfo(data);
          }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function renderInfo(data){
      const danhmucSelect = document.getElementById('danhmuc');
      danhmucSelect.innerHTML = '<option value="0">--Chọn danh mục--</option>';
      data.danhmuc.forEach(item => {
        let option = document.createElement('option');
        option.value = item.idDM;
        option.textContent = item.LOAISP;
        danhmucSelect.appendChild(option);
      });
      
      // Render hãng
      const hangSelect = document.getElementById('hang');
      hangSelect.innerHTML = '<option value="0">--Chọn Hãng--</option>';
      data.hang.forEach(item => {
        let option = document.createElement('option');
        option.value = item.idHANG;
        option.textContent = item.TENHANG;
        hangSelect.appendChild(option);
      });
    }



</script>
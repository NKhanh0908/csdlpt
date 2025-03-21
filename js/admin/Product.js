//Hiện ảnh
function hienThiAnh(event) {
    var input = event.target;
    var reader = new FileReader();
    reader.onload = function(){
        var dataURL = reader.result;
        var img = document.getElementById("img");
        img.src = dataURL;  
    };
    reader.readAsDataURL(input.files[0]);
}

//Var sai thông tin update
document.addEventListener('DOMContentLoaded', function() {
    
var form = document.querySelector('.form-update-sp');

form.addEventListener('submit', function(event) {
    var tensp = document.querySelector('input[name="Tensp"]').value;
    var danhmuc = document.querySelector('select[name="Danhmuc"]').value;
    var hang = document.querySelector('select[name="Hang"]').value;

    if(Object.keys(tensp).length == 0) {
        // alert("Tên sản phẩm không hợp lệ");
        document.querySelector('p[name="varTen"]').style.visibility='visible';
        event.preventDefault();
    }else{
        document.querySelector('p[name="varTen"]').style.visibility='hidden';
    }

    if(hang == 0){
        // alert("Vui lòng chọn hãng");
        document.querySelector('p[name="varHang"]').style.visibility='visible';
        event.preventDefault();
    }else{
        document.querySelector('p[name="varHang"]').style.visibility='hidden';
    }

    if(danhmuc==0){
        // alert("Vui lòng chọn danh mục");
        document.querySelector('p[name="varDanhmuc"]').style.visibility='visible';
        event.preventDefault();
    }else{
        document.querySelector('p[name="varDanhmuc"]').style.visibility='hidden';
    }

});
});

//Var sai thông tin Add
document.addEventListener('DOMContentLoaded', function() {
    
    var form = document.querySelector('.addsp');
    
    form.addEventListener('submit', function(event) {
        var gianhap = document.querySelector('input[name="txtGianhap"]').value;
        var tensp = document.querySelector('input[name="txtTensp"]').value;
        var danhmuc = document.querySelector('select[name="txtDanhmuc"]').value;
        var hang = document.querySelector('select[name="txtHang"]').value;
        var img = document.querySelector('input[name="txtImg"]');
    
        if(tensp.length == 0) {
            // alert("Tên sản phẩm không hợp lệ");
            document.querySelector('p[name="varTen"]').style.visibility='visible';
            event.preventDefault();
        }

        if(hang == 0){
            // alert("Vui lòng chọn hãng");
            document.querySelector('p[name="varHang"]').style.visibility='visible';
            event.preventDefault();
        }
    
        if (!Number.isInteger(parseInt(gianhap)) || gianhap==0) {
            // alert("Giá nhập không hợp lệ");
            document.querySelector('p[name="varGia"]').style.visibility='visible';
            event.preventDefault(); 
        }
    
        if(danhmuc==0){
            // alert("Vui lòng chọn danh mục");
            document.querySelector('p[name="varDanhmuc"]').style.visibility='visible';
            event.preventDefault();
        }
    
        if(img.files.length == 0){
            // alert("Vui lòng chọn ảnh cho sản phẩm");
            document.querySelector('p[name="varImg"]').style.visibility='visible';
            event.preventDefault();
        }

    });
    });
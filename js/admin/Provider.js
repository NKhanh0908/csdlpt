
//Var sai thông tin update
document.addEventListener('DOMContentLoaded', function() {
    
var form = document.querySelector('.form-update-ncc');

form.addEventListener('submit', function(event) {
    var tenncc = document.querySelector('input[name="TenNcc"]').value;
    var sdt = document.querySelector('input[name="txtSDT"]').value;
    var diachi = document.querySelector('input[name="txtDiachi"]').value;

    if(Object.keys(tenncc).length == 0) {
        // alert("Tên sản phẩm không hợp lệ");
        document.querySelector('p[name="varTen"]').style.visibility='visible';
        event.preventDefault();
    }else{
        document.querySelector('p[name="varTen"]').style.visibility='hidden';
    }

    if(Object.keys(sdt).length == 0 || Object.keys(sdt).length > 10){
        // alert("Vui lòng chọn hãng");
        document.querySelector('p[name="varSdt"]').style.visibility='visible';
        event.preventDefault();
    }else{
        document.querySelector('p[name="varSdt"]').style.visibility='hidden';
    }

    if (Object.keys(diachi).length == 0) {
        // alert("Giá nhập không hợp lệ");
        document.querySelector('p[name="varDiachi"]').style.visibility='visible';
        event.preventDefault(); 
    }else{
        document.querySelector('p[name="varDiachi"]').style.visibility='hidden';
    }
});
});

//Var sai thông tin Add
document.addEventListener('DOMContentLoaded', function() {
    
    var form = document.querySelector('.addncc');
    
    form.addEventListener('submit', function(event) {
        var tenncc = document.querySelector('input[name="txtTenNcc"]').value;
        var sdt = document.querySelector('input[name="txtSDT"]').value;
        var diachi = document.querySelector('input[name="txtDiachi"]').value;
    
        if(Object.keys(tenncc).length == 0) {
            // alert("Tên sản phẩm không hợp lệ");
            document.querySelector('p[name="varTen"]').style.visibility='visible';
            event.preventDefault();
        }else{
            document.querySelector('p[name="varTen"]').style.visibility='hidden';
        }
    
        if(Object.keys(sdt).length == 0){
            // alert("Vui lòng chọn hãng");
            document.querySelector('p[name="varSdt"]').style.visibility='visible';
            event.preventDefault();
        }else{
            document.querySelector('p[name="varSdt"]').style.visibility='hidden';
        }
    
        if (Object.keys(diachi).length == 0) {
            // alert("Giá nhập không hợp lệ");
            document.querySelector('p[name="varDiachi"]').style.visibility='visible';
            event.preventDefault(); 
        }else{
            document.querySelector('p[name="varDiachi"]').style.visibility='hidden';
        }

    });
    });
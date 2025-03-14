window.onbeforeunload = function(event) {
    // ev.preventDefault();
    return "Thay đổi sẽ không được lưu";
}

const ncc_select = document.getElementById('input-ncc');
const sp_select = document.getElementById('input-listSP');
let scrollViewSP = document.getElementById('scrollView-SP');

let products = new Array();
let gianhap = document.getElementById('input-gianhap');

let str = '';
let thanhtien_value = 0;
let loinhuan = document.getElementById('input-loinhuan');
let inputquantity = document.getElementById('input-soluong');
let thanhtienchan = document.getElementById('thanhtien-sp');

//Liên quan đến thêm sản phẩm
let addproduct = document.getElementById('addproduct-container');

const tensp = document.querySelector('input[name=Tensp]');
const hang_select = document.querySelector('select[name=hang]');
const danhmuc_select = document.querySelector('select[name=danhmuc]');
const mota = document.querySelector('textarea[name=Mota]')
const img = document.querySelector('input[name=Img]');

//Thim sản phữm mới
function OpenAddProductPop(){
    addproduct.classList.add("open-addproduct");
}

function CloseAddProductPop(){
    addproduct.classList.remove("open-addproduct");
}
//Hiện ảnh
function hienThiAnh(event) {
    var input = event.target;
    var reader = new FileReader();
    reader.onload = function(){
        var dataURL = reader.result;
        var img = document.getElementById("img");
        img.src = dataURL;  
    };
    var dataimg = new FormData();
    dataimg.append('file', img.files[0]);
    console.log(img.files[0]);
    reader.readAsDataURL(input.files[0]);
}

//Lấy thông tin rồi thim sản phẩm thoai
function InsertProduct(){
    if(tensp.value == ''){
        alert("Chưa nhập tên sản phẩm ấy ơi !"); return;
    }

    if(hang_select.value <= 0 ){
        alert("Chưa chọn hãng cho sản phẩm ấy ơi !"); return;
    }

    if(danhmuc_select.value <= 0 ){
        alert("Chưa chọn danh mục cho sản phẩm ấy ơi !"); return;
    }

    if(img.files.length <= 0 ){
        alert("Chưa có hình nè"); return;
    }

    const url = '../Controller/Receipt/InsertProduct.php';      
    var file = img.files[0];
    console.log(file);

    if (file) {
    const reader = new FileReader();
    
    reader.onloadend = function() {
        const base64Data = reader.result.split(',')[1]; 

    try{
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                tensp: tensp.value,
                hang: hang_select.value,
                danhmuc: danhmuc_select.value,
                mota: mota.value,
                fileName: file.name,
                fileType: file.type,
                fileData: base64Data
        })
        })
        .then(response => response.json())
        .then(data =>{
            alert(data.message);
        })
        .catch(err => console.error(err))
    }catch(error){
        console.error(error)
    }    
  };
  reader.readAsDataURL(file);  // Đọc file dưới dạng base64
    }
}

//Sau khi insert thì load lại
function LoadData(){
    DisplaySelect('NCC');
    DisplaySelect('SP');
    DisplaySelect('HANG');
    DisplaySelect('DANHMUC');
}
function DisplaySelect(type){
    var str = '';
    var url = '../Controller/Receipt/LoadDataToInsert.php?type=' + type;
    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        str += type=='NCC'? `<option value="0">---Chọn nhà cung cấp---</option>`: 
        (type=='HANG'? `<option value="0">---Chọn hãng---</option>`:
        (type=='DANHMUC'? `<option value="0">---Chọn danh mục---</option>` : `<option value="0">---Chọn sản phẩm---</option>`));
        data.forEach(element => {
            str += `<option value="${element.id}">${element.name}</option>`
        });

        if(type=='NCC'){
            ncc_select.innerHTML += str;
        }else if(type=='SP'){
            sp_select.innerHTML += str;
        }else if(type=='HANG'){
            hang_select.innerHTML += str;
        }
        else{
            danhmuc_select.innerHTML += str;
        }
    })
}
//

//Này là ấy 
function Return(){
    alert("Từ từ chưa viết đi~ ơi");
    document.getElementById('addReceipt-popup').classList.remove('open-addreceipt');
}
//////

//Khúc dưới này là của khúc trên
function Resetinput(){
    products.splice(0, products.length);
    str = str.replace(str, '');
    ncc_select.value = 0;
    sp_select.value = 0;
    scrollViewSP.innerHTML = str;
    loinhuan.value = 1;
    inputquantity.value = 1;
    gianhap.value = '';
    thanhtien_value = 0;
    thanhtienchan.innerHTML = thanhtien_value;

    console.log("Products: " + products);
    console.log("str: " + str);
}
function OnchangeLoiNhuan(){
    var loinhuanchange = document.getElementById('input-loinhuan').value;

    str = str.replace(str, '');
    scrollViewSP.innerHTML = str;
    
    products.forEach(element =>{
        DisplayProduct(element[0], element[1], element[2], loinhuanchange);
    })

    alert("Cập nhật lợi nhuận thành công");

}
function InsertReceipt(){
    if(ncc_select.value == 0){
        alert('Chọn nhà cung cấp đi mẹ');
        return;
    }

    if(products.length <= 0){
        alert('Thim sản phửm dùm con');
        return;
    }

    try{
    const url = '../Controller/Receipt/InsertReceipt.php';

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            idNCC: ncc_select.value,
            loinhuan: loinhuan.value,
            thanhtien: thanhtien_value
        })
        })
        .then(response => response.json())
        .then(data => {
            var idPN = data.id;
            var loinhuan = data.loinhuan;
            console.log(data.message);
            console.log("Thành tiền = " + data.thanhtien);
            
            products.forEach(element => {
                InsertReceiptDetail(idPN, element[0], element[1], element[2], loinhuan);
            })
            alert("Insert phíu nhoặp rầu nghen");

            sp_select.innerHTML = '';
            console.log("select nè: ");
            DisplaySelect('SP');
            Resetinput();
        })
    }catch(error){
        console.error(error)
    }
}

function InsertReceiptDetail(idPN, idSP, soluongSP, gianhapSP, loinhuan){
    try{
    const url = '../Controller/Receipt/InsertReceiptDetail.php';

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            idPN: idPN,
            idSP: idSP,
            soluong: soluongSP,
            gianhap: gianhapSP,
            loinhuan: loinhuan
        })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
        })
    }catch(error){
        console.error(error)
    }
}

function DisplayPrice(){
    var url = '../Controller/Receipt/LoadProduct.php?idSP=' + sp_select.value;
    console.log("idsp = " + sp_select.value);
    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data=> {
        gianhap.value = data.gianhap; 
        console.log("gianhap "+ gianhap.value);
    })
    .catch(err => console.log(err))
}

function AddProduct(){
    let idSP = document.getElementById('input-listSP').value;
    let quantity = document.getElementById('input-soluong').value;
    
    if(idSP<=0 ){
        alert('Chọn sản phửm dùm iem');
        return;
    }

    var exist = products.filter(item => item[0] == idSP);
    if(exist.length > 0){
        alert("Sản phửm đã có");
        return;
    }

    if(!Number.isInteger(parseInt(loinhuan.value)) || parseInt(loinhuan.value) > 99 || parseInt(loinhuan.value) < 0){
        alert("Lợi nhuận là số từ 0-99 á má");
        return;
    }

    if(!Number.isInteger(parseInt(gianhap.value)) || parseInt(gianhap.value) < 0){
        alert("Giá nhập là số lớn hơn 0 á má");
        return;
    }
    if(!Number.isInteger(parseInt(inputquantity.value)) || parseInt(inputquantity.value) < 0){
        alert("Số lượng là số lớn hơn 0 á má");
        return;
    }

    var product = new Array(idSP, quantity, gianhap.value);
    products.push(product);

    alert("Thêm sản phẩm thành công!");
    DisplayProduct(product[0], product[1], product[2], loinhuan.value);
}

function RemoveProduct(idsp){
    
    // let idsp = document.getElementById('input-id').value;
    console.log("Remove: " + idsp);
    var isExisted = products.filter(item => item[0]==idsp);
    isExisted_quantity = isExisted[1];
    isExisted_gianhapsp = isExisted[2];

    products.splice(products.indexOf(isExisted[0]), 1);
    alert("Xóa thành công");
    
    str = str.replace(str, '');
    scrollViewSP.innerHTML = str;
    thanhtien_value -= parseInt(isExisted_quantity) * parseFloat(isExisted_gianhapsp);
    thanhtienchan.innerHTML = thanhtien_value + ' VND';

    if(products.length == 0){
        return;
    }
    products.forEach(element =>{
        DisplayProduct(element[0], element[1], element[2], loinhuan.value);
    })

}

function DisplayProduct(idsp, quantity, gianhapsp, loinhuansp){   
    var url = '../Controller/Receipt/LoadProduct.php?idSP=' + idsp;
    
    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        str +=`<div class='item'>
                <img src="/images/products/${data.img}">
                <p>${data.name}</p>
                <p>Giá cũ: ${data.gianhap} Vnd</p>
                <p>Giá mới: ${parseInt(gianhapsp)} Vnd</p>
                <p>Lời: ${loinhuansp}%</p>
                <div class='action-item'>
                    <button onclick="Action('-', ${data.id})">-</button>
                    <p id='quantity-${data.id}'>${quantity}</p>
                    <button onclick="Action('+', ${data.id})">+</button>
                </div>
                <button class='btn-delete' onclick="RemoveProduct(${data.id})">Xóa</button>
            </div>`;

        scrollViewSP.innerHTML = str;

        thanhtien_value += parseInt(quantity) * parseFloat(gianhapsp);
        thanhtienchan.innerHTML = thanhtien_value  + ' VND';
    })
}

function Action(str, idsp){
    var quantitysp = document.getElementById('quantity-'+idsp);

    if(str == "+"){
        products.forEach(element => {
            if(element[0] == idsp){
                element[1] = parseInt(element[1]) + 1;
                quantitysp.innerHTML = element[1];

                thanhtien_value += parseFloat(element[2]);
                thanhtienchan.innerHTML = thanhtien_value  + ' VND';
            }
        });
    }else{
        products.forEach(element => {
            if(element[0] == idsp){
                if((parseInt(element[1]) - 1) < 1){
                    alert('Xóa mẹ luôn đi');
                    return;
                }
                element[1] = parseInt(element[1]) - 1;
                quantitysp.innerHTML = element[1];

                thanhtien_value -= parseFloat(element[2]);
                thanhtienchan.innerHTML = thanhtien_value  + ' VND';
            }
        });
    }
}
// Đơn vị tiền VND
function formatCurrencyVND(amount) {
    return new Intl.NumberFormat('vi-VN').format(amount);
}

function OnloadData(){
    LoadData();
    LoadReceipt();
}

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


function LoadReceipt(){
    const table = document.getElementById('hang');
    let keyword = document.getElementById('keyword').value;
    let order = document.getElementById('order-price').value;
    let dateSearch = document.getElementById('date-serch').value;
   
    try{
        var str = '';
        // url = 
        fetch('../Controller/Receipt/LoadReceipt.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                keyword: keyword,
                order : order,
                dateSearch : dateSearch
            })
            })
            .then(response => response.json())
            .then(data =>{
                if(data.length > 0){
                    data.forEach(element => {
                        str +=`
                            <tr class='PN-rows' id='tr-${element.id}' onmouseenter="ShowDetail(${element.id})" onclick="OpenDetail(${element.id})">
                                <td id="idPN">PN${element.id}</td>
                                <td id="NCC">${element.ncc}</td>
                                <td id="diachi">${element.diachi}</td>
                                <td id="ngaynhap">${element.ngaynhap}</td>
                                <td id="thanhtien">${formatCurrencyVND(element.thanhtien)} VND</td>
                                <td id="loinhuan">${element.loinhuan}%</td>
                            </tr>`;
                    });
                    table.innerHTML = str;
                    document.getElementById("result").innerHTML = "";
                }else{
                    table.innerHTML = '';
                    document.getElementById("result").innerHTML = "Không tìm thấy phiếu nhập nào đi~ ơi";
                }
                }
            )
            .catch(error => console.error(error))

        }catch(error){
            console.error(error)
        }
}

function ShowDetail(id){
    var btn = document.getElementById('tr-' + id);
    var str = '';

    try{
        url = '../Controller/Receipt/LoadReceiptDetail.php';
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                idPN : id
            })
        })
        .then(response => response.json())
        .then(data =>{
            data.forEach(element =>{
                str += element.tensp + ': ' + element.soluong + ' cái\n';
            })

            btn.title = str;
        })
        .catch(error => console.error(error));

    }catch(error) {
        console.error(error);
    }
}

const addreceipt = document.getElementById('addReceipt-popup');

function OpenAddReceiptPop(){
    modal.classList.add('open-modal');
    addreceipt.classList.add("open-addreceipt");
}

function CloseAddReceiptPop(){
    addreceipt.classList.remove("open-addreceipt");
}

//Mở trang chi tiết phiếu nhập
const receiptdetail = document.getElementById('receiptDetail-form');
const modal = document.getElementById('modal');

function OpenReceiptDetailPop(){
    modal.classList.add('open-modal');
    receiptdetail.classList.add("open-detail");
    document.querySelector(".hidden-log-out").classList.add("active");
}

function closeReceiptDetailPop(){
    modal.classList.remove('open-modal');
    receiptdetail.classList.remove("open-detail");
    document.querySelector(".hidden-log-out").classList.remove("active");
}

function OpenDetail(clicked_id){
    OpenReceiptDetailPop();
    const hangSP = document.getElementById('hang-sp');
    const nccElement = document.getElementById('ncc-name');
    const ngaynhapElement = document.getElementById('ngay-nhap');
    var str = '';

    const row = document.getElementById('tr-' + clicked_id);
    const ncc = row.querySelector('#NCC').innerText; 
    const ngaynhap = row.querySelector('#ngaynhap').innerText; 

    nccElement.innerText = ncc;
    ngaynhapElement.innerText = ngaynhap;

    const url = "../Controller/Receipt/ShowReceiptDetail.php?idPN=" + clicked_id;
    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        data.forEach(element =>{
            str += `
            <tr class='SP-rows'">
                <td>
                    <div class='name-sp'>
                        <img class='img-sp' src="/images/products/${element.img}">
                        <p>${element.tensp}</p>
                    </div>
                </td>
                <td>${formatCurrencyVND(element.gianhap)}</td>
                <td>${formatCurrencyVND(element.giaban)}</td>
                <td>${element.soluong}</td>
            </tr>`;
        })

        hangSP.innerHTML = str;
        document.getElementById('maPN').innerText = 'PN' + clicked_id;
    })
    .catch(error => console.error('Error:', error))
}
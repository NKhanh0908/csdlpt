// Gọi gì gì đó
const str = document.getElementById("idNV").value;
const modal = document.getElementById("modal");
const leavepopup = document.getElementById("leave-form");

let salarypopup = document.getElementById("salary-form");
let list_plieu_luong = document.getElementById('PL-List');
let count = 0;

// Đơn vị tiền VND
function formatCurrencyVND(amount) {
    return new Intl.NumberFormat('vi-VN').format(amount);
}

// click modal
document.addEventListener('click', (e)=> {
    if (modal.contains(e.target) 
        && !leavepopup.contains(e.target) 
        && !salarypopup.contains(e.target) 
        && !list_plieu_luong.contains(e.target)) {
            modal.classList.remove("open-modal");
            closeLeavePop()
            closeSalaryPop()
            closePLList()
    }
})


//Load thông tin nhân viên
function LoadInfo(){
    try{
    const api = '../../admin/Controller/Employee/EmployeeInfoController.php';
    fetch(api, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: str
        })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('img-em').src = "../../images/employee/" + data.img;
            document.getElementById('name').querySelector('.value').innerHTML = data.hoten;
            document.getElementById('gioitinh').querySelector('.value').innerHTML = data.gioitinh == 1 ? 'Nam' : 'Nữ';
            var parts = data.ngaysinh.split('-');
            document.getElementById('ngaysinh').querySelector('.value').innerHTML = parts[2] + '/' + parts[1] + '/' + parts[0];
            document.getElementById('email').querySelector('.value').innerHTML = data.email;
            document.getElementById('sdt').querySelector('.value').innerHTML = data.sdt;
            document.getElementById('diachi').querySelector('.value').innerHTML = data.diachi;
            document.getElementById('tinhtrang').querySelector('.value').innerHTML = data.tinhtrang;
            
            //Xin nghỉ
            document.getElementById('name-leave').querySelector('.value').innerHTML = data.hoten;
            document.getElementById('idNV-leave').querySelector('.value').innerHTML = str;

            //Lương
            document.getElementById('idNV-salary').querySelector('.value').innerHTML = str;
            document.getElementById('name-salary').querySelector('.value').innerHTML = data.hoten;
            document.getElementById('vitri').querySelector('.value').innerHTML = data.quyen;
            document.getElementById('luong').querySelector('.value').innerHTML = formatCurrencyVND(data.luong) + " VNĐ/tháng";
            DisplaySalary()
        })
    }catch(error){
        console.error(error)
    }
}

// Nghỉ phép
function OpenLeavePopup(){
    modal.classList.add("open-modal");
    leavepopup.classList.add("open-leaveform");
    document.querySelector(".hidden-log-out").classList.add("active");
}

function closeLeavePop(){
    modal.classList.remove("open-modal");
    leavepopup.classList.remove("open-leaveform");
    document.querySelector(".hidden-log-out").classList.remove("active");
}

//Gửi đơn nghỉ
function SendLeaveRequest(){
    const ngaynghi = document.getElementById('ngaynghi').value;
    const lydo = document.getElementById("lydo").value;
    const api = "../../admin/Controller/Employee/SendLeaveRequest.php";
    console.log(api);
    fetch(api, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: str,
            ngaynghi : ngaynghi,
            lydo : lydo
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.status >= 0){
            alert(data.message);

            if(data.status < 4)  closeLeavePop();
        }
    })
    .catch(error => console.error('Error:', error))
}

// Xem lương
function OpenSalaryPopup(){
    modal.classList.add("open-modal");
    salarypopup.classList.add("open-salaryform");
    document.querySelector(".hidden-log-out").classList.add("active");
}

function closeSalaryPop(){
    modal.classList.remove("open-modal");
    salarypopup.classList.remove("open-salaryform");
    document.querySelector(".hidden-log-out").classList.remove("active");
}

function DisplaySalary(){
    const today = new Date();
    const datetitle = document.getElementById('date-title');
    const ngaycong = document.getElementById('chamcong_ngaylam'); 
    const ngaycongtt = document.getElementById('chamcongtt'); 
    const ngayle = document.getElementById('ngayle'); 
    const hesole = document.getElementById('hesongayle'); 
    const luongchinh= document.getElementById('luongchinh'); 
    //
    const bhxh = document.getElementById('bhxh'); 
    const trachnhiem = document.getElementById('trachnhiem'); 
    const bhyt = document.getElementById('bhyt'); 
    const antrua  = document.getElementById('antrua'); 
    const bhthatnghiep = document.getElementById('bh-thatnghiep'); 
    const dienthoai = document.getElementById('dienthoai'); 
    const thue = document.getElementById('thue'); 
    const xangxe = document.getElementById('xangxe'); 
    const nha= document.getElementById('nha'); 
    const connho = document.getElementById('connho'); 
    //
    const tongthu = document.getElementById('tongthu'); 
    const tongtru = document.getElementById('tongtru'); 
    const tongcong = document.getElementById('tongcong'); 

    const url = "../../admin/Controller/Employee/SalaryCalculating.php";
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify ({
            id: str
        })
    })
    .then(response => response.json())
    .then(data => {
        ngaycong.querySelector('.value').innerHTML = data.ngaycong + " ngày";
        ngaycongtt.querySelector('.value').innerHTML = data.ngaycongtt + ' ngày';
        ngayle.querySelector('.value').innerHTML = data.ngayle + ' ngày';
        hesole.querySelector('.value').innerHTML = data.hesongayle;
        luongchinh.innerHTML = formatCurrencyVND(data.luongchinh);
        datetitle.innerHTML = "Ngày " + today.getUTCDate() + " tháng " + (today.getUTCMonth() + 1) + " năm " + today.getUTCFullYear();
    })
    .catch(error => console.error('Error:', error))
}

//Xem phiếu lương
function closePLList(){ 
    modal.classList.remove("open-modal");
    list_plieu_luong.classList.remove("open-PL-list");
    document.querySelector(".hidden-log-out").classList.remove("active");
}

LoadListLuong = async() => {
    modal.classList.add("open-modal");
    list_plieu_luong.classList.add("open-PL-list");
    document.querySelector(".hidden-log-out").classList.add("active");
    const url = '../Controller/Employee/LoadPayslipList.php?idNV=' + str

    const LoadPL = async() => {
        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })

            const data = response.json()
            return data
        } catch(err) {
            console.error(err)
        }
    }

    const listPL = await LoadPL()
    list_plieu_luong.innerHTML = `
        <h1>Giai đoạn lương</h1>
        <div class='head-timing'>
            <p>Giai đoạn</p>
            <p>Ngày nhận</p>
            <p>Tổng nhận (VND)</p>      
        </div>
        <div class='PL-content'></div>
        <div class='PL-footer'>
            <button class='PL-close' onclick='closePLList()'>Xác nhận</button>
        </div>
    `;

    const plContent = document.querySelector('.PL-content');

    listPL.forEach(element => {
        plContent.innerHTML += `
        <div class='timing-hook'>
            <p>GĐ-${element.idPL}</p>
            <p>${element.time}</p>
            <p>${formatCurrencyVND(element.total)}</p>
        </div>`;
    });
}

//In phiếu lương
document.addEventListener('DOMContentLoaded', function() {
    // Lấy các phần tử
    var loaderFrame = document.getElementById('loaderFrame');
    var printerButton = document.getElementById('salary-printer');

    loaderFrame.addEventListener('load', function() {
        var iframeWindow = loaderFrame.contentWindow || loaderFrame.contentDocument.defaultView;
        iframeWindow.print();
    });

    printerButton.addEventListener('click', function() {
        loaderFrame.setAttribute('src', '../View/Employee/Payslip.php?idBL=1');
    });
});
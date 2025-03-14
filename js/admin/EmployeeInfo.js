
const str = document.getElementById("idNV").value;

let popup = document.getElementById("popup");

let leavepopup = document.getElementById("leave-form");

let salarypopup = document.getElementById("salary-form");

let count = 0;

//Lương
//Hàm hiện cửa sổ bảng lương
function OpenSalaryPopup(){
    salarypopup.classList.add("open-salaryform");
}

//Hàm đóng cửa sổ bảng lương
function closeSalaryPop(){
    salarypopup.classList.remove("open-salaryform");
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

    const api = "../Controller/Employee/SalaryCalculating.php";
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
        ngaycong.innerHTML = 'Chấm công ngày làm: ' + data.ngaycong + " ngày";
        ngaycongtt.innerHTML = 'Chấm công thực tế: ' + data.ngaycongtt + ' ngày';
        ngayle.innerHTML = 'Làm ngày lễ: ' + data.ngayle + ' ngày';
        hesole.innerHTML = 'Hệ số ngày lễ: '+ data.hesongayle + ' ngày';
        luongchinh.innerHTML = data.luongchinh;
        datetitle.innerHTML = "Ngày " + today.getUTCDate() + " tháng " + (today.getUTCMonth() + 1) + " năm " + today.getUTCFullYear();
    })
    .catch(error => console.error('Error:', error))

}
//Lương

//Hàm hiện cửa sổ xin nghỉ
function OpenLeavePopup(){
    leavepopup.classList.add("open-leaveform");
}

//Hàm đóng cửa sổ xin nghi
function closeLeavePop(){
    leavepopup.classList.remove("open-leaveform");
}

//Gửi đơn nghỉ
function SendLeaveRequest(){
    const ngaynghi = document.getElementById('ngaynghi').value;
    const lydo = document.getElementById("lydo").value;
    // var ngay = new Date(ngaynghi);
    // console.log(ngaynghi, lydo);
    const api = "../Controller/Employee/SendLeaveRequest.php";
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

//Insert vào bảng chấm công
// function Insert(){
//     fetch('../Controller/Employee/InsertTimekeeping.php', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json'
//         },
//         body: JSON.stringify({
//             id: str
//         })
//         })
//         .then(response => response.json())
//         .then(data => {
//             if(data.status){
//                 alert(data.message);
//             }
//         })
//         .catch(error => console.error('Error:', error))
// }

//Load thông tin nhân viên
function LoadInfo(){
    // console.log("dô r");
    try{
    const api = '../Controller/Employee/EmployeeInfoController.php';
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
            document.getElementById('img-em').src = "/images/employee/" + data.img;
            document.getElementById('name').innerHTML = "Họ tên nhân viên: " + data.hoten;
            document.getElementById('gioitinh').innerHTML ="Giới tính: " + (data.gioitinh==1? 'Nam' : 'Nữ');
            var parts = data.ngaysinh.split('-');
            document.getElementById('ngaysinh').innerHTML ="Ngày sinh: "+ parts[2]+'/'+ parts[1]+'/'+ parts[0];
            document.getElementById('email').innerHTML ="Địa chỉ email: " + data.email;
            document.getElementById('sdt').innerHTML ="Số điện thoại: " + data.sdt;
            document.getElementById('tinhtrang').innerHTML ="Tình trạng: "+ data.tinhtrang;
            //
            document.getElementById('idNV-leave').innerHTML ="Mã nhân viên: "+ str;
            document.getElementById('name-leave').innerHTML = "Họ tên: " + data.hoten;
            //
            document.getElementById('idNV-salary').innerHTML ="Mã nhân viên: "+ str;
            document.getElementById('name-salary').innerHTML = "Họ tên nhân viên: " + data.hoten;
            document.getElementById('vitri').innerHTML ="Vị trí làm việc: " + data.quyen;
            document.getElementById('luong').innerHTML ="Lương cơ bản: " + data.luong + " VNĐ/ngày";

            DisplaySalary()
        })
    }catch(error){
        console.error(error)
    }
}

//Hàm hiện cửa sổ
function OpenPop(){
    popup.classList.add("open-popup");
}

//Hàm đóng cửa sổ
function closePop(){
    popup.classList.remove("open-popup");
}

//Load data từ bảng chấm công và hiện ra cửa sổ
// function LoadTimekeeping(){
//     OpenPop()
//     // console.log("dô r");
//     const table = document.getElementById('hang');

//     try{
//         console.log("dô r nè");
//         fetch('../Controller/Employee/LoadTimekeeping.php', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json'
//             },
//             body: JSON.stringify({
//                 id: str
//             })
//             })
//             .then(response => response.json())
//             .then(data =>{
//                     data.forEach(element => {
//                         // console.log(element.heso, element.ngaylam);
//                         if(count < data.length){
//                             table.insertAdjacentHTML("afterend", 
//                                 `<td id="ngaylam"></td>
//                                 <td id="heso"></td>`
//                             )
//                             document.getElementById('ngaylam').innerHTML= element.ngaylam;
//                             document.getElementById('heso').innerHTML= element.heso;
//                             count++;
//                         }

//                         console.log("count= ", count);
//                     });
//                 }
//             )
//             .catch(error => console.error(error))

//         }catch(error){
//             console.error(error)
//         }
// }
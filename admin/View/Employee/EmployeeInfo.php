<link rel="stylesheet" href="/css/admin/Employee.css">
<?php include("../Controller/Employee/Getid.php"); ?>

<body onload="LoadInfo()">
<h1>Thông tin nhân viên</h1><br>
<div class='container'>
    <input type="hidden" name="idNV" id="idNV" value='<?php echo $id['idTK'] ?>'>
    <div class='in-content' class='left-content'>
        <div><img id='img-em' src="" alt=""></div>
        <div id="name">Họ tên nhân viên:</div>
        <div id='gioitinh'>Giới tính:</div>
        <div id='ngaysinh'>Ngày sinh:</div>
        <div id='email'>Địa chỉ email:</div>
        <div id='sdt'>Số điện thoại:</div>
    </div>

    <div class='in-content' class='middle-content'>
        <div id='tinhtrang'>Tình trạng:</div>

        <!-- <button id='chamcong' onclick="Insert()">Chấm công đi mẹ</button> -->
        <!-- <button id='lichchamcong' onclick="LoadTimekeeping()">Xem lịch chấm công</button> -->
        <button id='leave-popup' onclick="OpenLeavePopup()">Nghỉ làm</button>
        <button id='salary-popup' onclick="OpenSalaryPopup()">Cho mẹ coi lương</button>
    </div>

    <div class="popup" id="popup">
        <h2>Lịch đã chấm công</h2>
        <p>Thông tin của m ở đây</p>
        <table>
            <thead>
                <tr>
                    <th>Ngày làm</th>
                    <th>Hệ số</th>
                </tr>
            </thead>
            <tbody>
                <tr id="hang">
                <!--Thông tin hiện ra ngay đây-->    
                </tr>
            </tbody>
        </table>
        <button type="button" onclick="closePop()">Ok</button>
    </div>

    <div class="leave-form" id="leave-form" >
        <h1>Form xin nghỉ</h1>
        <button id='close-leave' type="button" onclick="closeLeavePop()">Trở về</button>
        <div class='leave-container'>
            <div id='name-leave'>Tên nhân viên</div>
            <div id='idNV-leave'>Mã nhân viên</div><br>
            <label for="ngaynghi">Chọn ngày nghỉ:</label><br>
            <input type="date" name='ngaynghi' id='ngaynghi'><br><br>
            <label for="lydo">Lý do vắng:</label><br>
            <textarea name='lydo' id='lydo' rows="5" cols="40"></textarea><br>
            <button id='submit-leave' type="button" onclick="SendLeaveRequest()">Gửi</button>
        </div>
    </div>

    <div class="salary-form" id="salary-form" >
        <button class='close' type="button" onclick="closeSalaryPop()">X</button>
        <div class="cty-info">
            <h1>Thông tin lương hiện tại</h1>
            <div>Công ty TNHH MTV HKT-M</div>
            <div>Địa chỉ: 273 An Dương Vương, phường 5, quận 3, TP. HCM</div>
            <div id='date-title'>Ngày.. tháng.. năm..</div>
        </div>

        <div class='contain'>
            <h3>Thông tin nhân viên</h3>
            <div>
                <p id="idNV-salary">Mã nhân viên: </p>
                <p id='chamcong_ngaylam'>Chấm công ngày làm: </p>
            </div>    
            <div>
                <p id="name-salary">Họ tên nhân viên: </p>
                <p id='chamcongtt'>Chấm công thực tế: </p>
            </div>
            <div>
                <p id='vitri'>Chức vụ: </p>
                <p id='luong'>Lương cơ bản: </p>
            </div>
            <div>
                <p id='ngayle'>Làm ngày lễ: </p>
                <p id='hesongayle'>Hệ số ngày lễ: </p>
            </div>
            <table>
                <thead>
                <tr>
                    <th style="width: 5%;" class="stt">STT</th>
                    <th style="width: 25%;" class='text'> Các khoản thu nhập</th>
                    <th style="width: 15%;" class='stt'> (VND) </th>
                    <th style="width: 5%;" class="stt">STT</th>
                    <th style="width: 25%;" class='text'> Các khoản trừ vào lương</th>
                    <th style="width: 15%;" class='stt'> (VND) </th>
                </tr>
                </thead>
                
                <tr>
                    <td class='stt'>1</td>
                    <td class='text'>Lương chính</td>
                    <td class='output-text' id="luongchinh"></td>
                    <td class='stt'>1</td>
                    <td class='text'>Bảo hiểm bắt buộc</td>
                    <td class='output-text'></td>
                </tr>
                <tr>
                    <td class='stt'>2</td>
                    <td class='text'>Phụ cấp</td>
                    <td class='output-text'></td>
                    <td class='stt'>1.1</td>
                    <td class='text'>Bảo hiểm xã hội</td>
                    <td class='output-text' id='bhxh'></td>
                </tr>
                <tr>
                    <td class='stt'>2.1</td>
                    <td class='text'>Trách nhiệm</td>
                    <td class='output-text' id='trachnhiem'></td>
                    <td class='stt'>1.2</td>
                    <td class='text'>Bảo hiểm y tế</td>
                    <td class='output-text' id='bhyt'></td>
                </tr>
                <tr>
                    <td class='stt'>2.2</td>
                    <td class='text'>Ăn trưa</td>
                    <td class='output-text' id='antrua'></td>
                    <td class='stt'>1.3</td>
                    <td class='text'>Bảo hiểm thất nghiệp chuyển sinh</td>
                    <td class='output-text' id='bh-thatnghiep'></td>
                </tr>
                <tr>
                    <td class='stt'>2.3</td>
                    <td class='text'>Điện thoại</td>
                    <td class='output-text' id='dienthoai'></td>
                    <td class='stt'>2</td>
                    <td class='text'>Thuế thu nhập cá nhân</td>
                    <td class='output-text' id='thue'></td>
                </tr>
                <tr>
                    <td class='stt'>2.4</td>
                    <td class='text'>Xăng xe</td>
                    <td class='output-text' id='xangxe'></td>
                    <td class='stt'>3</td>
                    <td class='text'>Tạm ứng</td>
                    <td class='output-text' id='tamung'></td>
                </tr>
                <tr>
                    <td class='stt'>2.5</td>
                    <td class='text'>Nhà ở</td>
                    <td class='output-text' id='nha'></td>
                    <td class='stt'>4</td>
                    <td class='text'>Khác</td>
                    <td class='output-text' id='khac'></td>
                </tr>
                <tr>
                    <td class='stt'>2.6</td>
                    <td class='text'>Nuôi con nhỏ</td>
                    <td class='output-text' id='connho'></td>
                    <td class='stt'></td>
                    <td class='text'></td>
                    <td class='output-text'></td>
                </tr>
                <tr>
                    <td></td>
                    <td class='text'>Tổng cộng</td>
                    <td class='output-text' id='tongthu'></td>
                    <td></td>
                    <td class='text'>Tổng cộng</td>
                    <td class='output-text' id='tongtru'></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td class='text'>Tổng thành tiền</td>
                    <td class='output-text' id='tongcong'></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
</div>
</body>
<script src="/js/admin/EmployeeInfo.js"></script>
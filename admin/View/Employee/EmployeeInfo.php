<?php include("../Controller/Employee/Getid.php"); ?>

<!-- CSS chung -->
<link rel="stylesheet" href="../../css/admin/OneForAll.css">
<link rel="stylesheet" href="../../css/admin/Employee.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<body onload="LoadInfo()">
    <div class="header">    
        <div class="first-header">
            <p>Thông tin nhân viên</p>
        </div>
        <div class="second-header">
            <div class="second-header-main">
                <button class="home">
                    <a href="?page=employeeinfo"> 
                        <i class="fa-solid fa-house home-outline"></i>
                    </a>
                </button>
                <div class="line"></div>
                <button id="leave-popup" class="btn-off" onclick="OpenLeavePopup()">
                    Xin phép
                </button>

                <button id="salary-popup" class="btn-salary" onclick="OpenSalaryPopup()">
                    Lương
                </button>

                <button id='XemPL' onclick="LoadListLuong()">
                    Xem phiếu lương
                </button>

                <button id='salary-printer'>
                    In phiếu lương
                </button>
            </div>
        </div>
    </div>

    <!-- Nội dung chính -->
    <main class="main">
        <div class='container'>
            <input type="hidden" name="idNV" id="idNV" value='<?php echo $id['idTK'] ?>'>
            <div class="first-container">
                <div><img id="img-em" class="img-em" src="" alt=""></div>
                <div class="info">
                    <p id="name">
                        <span class="label">Họ tên nhân viên:</span>
                        <span class="value"></span>
                    </p>
                    <p id="gioitinh">
                        <span class="label">Giới tính:</span>
                        <span class="value"></span>
                    </p>
                    <p id="ngaysinh">
                        <span class="label">Ngày sinh:</span>
                        <span class="value"></span>
                    </p>
                    <p id="email">
                        <span class="label">Email:</span>
                        <span class="value"></span>
                    </p>
                    <p id="sdt">
                        <span class="label">Số điện thoại:</span>
                        <span class="value"></span>
                    </p>
                    <p id="diachi">
                        <span class="label">Địa chỉ:</span>
                        <span class="value"></span>
                    </p>
                    <p id="tinhtrang">
                        <span class="label">Tình trạng:</span>
                        <span class="value"></span>
                    </p>
                </div>
            </div>

            <div class="modal" id="modal">
                <!-- Form nghỉ phép -->
                <div class="leave-form" id="leave-form">
                    <h1>Form xin nghỉ</h1>
                    <div class="leave-container">
                        <div class="leave-info">
                            <p id="name-leave">
                                <span class="label">Tên nhân viên:</span>
                                <span class="value"></span>
                            </p>
                            <p id="idNV-leave">
                                <span class="label">Mã nhân viên:</span>
                                <span class="value"></span>
                            </p>
                        </div>

                        <div class="date-off">
                            <label for="ngaynghi">Chọn ngày nghỉ:</label>
                            <input type="date" name='ngaynghi' id='ngaynghi'>
                        </div>

                        <div class="reason-off">
                            <label for="lydo">Lý do vắng:</label>
                            <textarea name='lydo' id='lydo'></textarea>
                        </div>

                        <div class="btn-leave">
                            <button id='close-leave' type="button" onclick="closeLeavePop()">Trở về</button>
                            <button id='submit-leave' class="submit-leave" type="button" onclick="SendLeaveRequest()">Xác nhận</button>
                        </div>
                    </div>
                </div>

                <!-- Form lương -->
                <div class="salary-form" id="salary-form" >
                    <button class='close' type="button" onclick="closeSalaryPop()">X</button>
                    <div class="cty-info">
                        <div class="head-cty-info">
                            <div class="cty-name-address">
                                <h4>Công ty TNHH MTV HKT-CM</h4>
                                <p>Địa chỉ: 273 An Dương Vương, phường 5, quận 3, TP. HCM</p>
                            </div>
                            <p id='date-title'>Ngày.. tháng.. năm..</p>
                        </div>
                        <h2>THÔNG TIN PHIẾU LƯƠNG</h2>   
                    </div>

                    <div class='contain'>
                        <h3>Thông tin nhân viên</h3>
                        <div class="main-contain">
                            <div class="left-contain">
                                <p id="idNV-salary">
                                    <span class="label">Mã nhân viên:</span>
                                    <span class="value"></span>
                                </p>
                                <p id="name-salary">
                                    <span class="label">Họ tên nhân viên:</span>
                                    <span class="value"></span>
                                </p>
                                <p id='vitri'>
                                    <span class="label">Chức vụ:</span>
                                    <span class="value"></span>
                                </p>
                                <p id='luong'>
                                    <span class="label">Lương cơ bản:</span>
                                    <span class="value"></span>
                                </p>
                            </div>    
                            <div class="right-contain">
                                <p id='chamcong_ngaylam'>
                                    <span class="label">Chấm công ngày làm:</span>
                                    <span class="value"></span>
                                </p>
                                <p id='chamcongtt'>
                                    <span class="label">Chấm công thực tế:</span> 
                                    <span class="value"></span>
                                </p>
                                <p id='ngayle'>
                                    <span class="label">Làm ngày lễ:</span>
                                    <span class="value"></span>
                                </p>
                                <p id='hesongayle'>
                                    <span class="label">Hệ số ngày lễ:</span>
                                    <span class="value"></span>
                                </p>
                            </div>
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
                                <td class='text'>Bảo hiểm thất nghiệp</td>
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

                <!-- Form phiếu lương -->
                <div id="PL-List" class="PL-list"></div>

                <!-- In phiếu lương -->
                <iframe id="loaderFrame" class="print-salary"></iframe>
            </div>
        </div>
    </main>
</body>
<script src="../../js/admin/EmployeeInfo.js"></script>
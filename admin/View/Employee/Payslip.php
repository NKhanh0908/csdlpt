
<?php 
    include('../../Controller/connectDB.php');
    $id = isset($_GET['idBL'])? $_GET['idBL'] : 0;

    $get_payslip = mysqli_query($conn, 'SELECT * from bangluong 
    
    
    
    WHERE idLUONG=' . intval($id));
    $slips = mysqli_fetch_assoc($get_payslip);

?>
<link rel="stylesheet" href="../../../css/admin/Payslip.css">
<div class="main">
    <div class="h2">Phiếu lương</div>
    <div class="row1">Công ty TNHH MTV HKT-M</div>
    <div class="row1">Địa chỉ: 273 An Dương Vương, phường 5, quận 3, TP. HCM</div>
    <div class="row1" id='date-title'>Ngày.. tháng.. năm.. <?= $slips['THOIGIAN'] ?></div>

    <div class="row">
        <div class='col1'></div>
        <div class="text col2">Mã nhân viên</div>
        <div class='output-text col3' id="idNV" ><?= $slips['idNV'] ?></div>
        <div class='col4'></div>
        <div class="text col5">Ngày công đi làm</div>
        <div class='output-text col6' id='chamcong_ngaylam'></div>
    </div>    
    <div  class="row">
        <div class='col1'></div>
        <div class="text col2">Họ tên nhân viên</div>
        <div class='output-text col3' id="name-salary"></div>
        <div class='col4'></div>
        <div class="text col5">Ngày công thực tế</div>
        <div class='output-text col6' id='chamcongtt'></div>
    </div>
    <div  class="row">
        <div class='stt col1'></div>
        <div class="text col2">Chức vụ</div>
        <div class='output-text col3'></div>
        <div class='col4'></div>
        <div class="text col5">Lương cơ bản</div>
        <div class='output-text col6'></div>
    </div>
    <div class="row">
        <div class='col1'></div>
        <div class="text col2">Làm ngày lễ</div>
        <div class='output-text col3' id='ngayle' ></div>
        <div class='col4'></div>
        <div class="text col5">Hệ số ngày lễ</div>
        <div class='output-text col6'>2</div>
    </div>
    <div class="row">
        <div class='stt col1'></div>
        <div class='text col2'></div>
        <div class='output-text col3' id="luongchinh"></div>
        <div class='stt col4'></div>
        <div class='text col5'></div>
        <div class='output-text col6'></div>
    </div>
    <div class="row">
        <div class="stt col1">STT</div>
        <div class='text col2'> Các khoản thu nhập</div>
        <div class='stt col3'> (VND) </div>
        <div class="stt col4">STT</div>
        <div class='text col5'> Các khoản trừ vào lương</div>
        <div class='stt col6'> (VND) </div>
    </div> 
    <div class="row">
        <div class='stt col1'>1</div>
        <div class='text col2'>Lương chính</div>
        <div class='output-text col3' id="luongchinh"></div>
        <div class='stt col4'>1</div>
        <div class='text col5'>Bảo hiểm bắt buộc</div>
        <div class='output-text col6'></div>
    </div>
    <div class="row">
        <div class='stt col1'>2</div>
        <div class='text col2'>Phụ cấp</div>
        <div class='output-text col3'></div>
        <div class='stt col4'>1.1</div>
        <div class='text col5'>Bảo hiểm xã hội</div>
        <div class='output-text col6' id='bhxh'></div>
    </div>
    <div class="row">
        <div class='stt col1'>2.1</div>
        <div class='text col2'>Trách nhiệm</div>
        <div class='output-text col3' id='divachnhiem'></div>
        <div class='stt col4'>1.2</div>
        <div class='text col5'>Bảo hiểm y tế</div>
        <div class='output-text col6' id='bhyt'></div>
    </div>
    <div class="row">
        <div class='stt col1'>2.2</div>
        <div class='text col2'>Ăn trưa</div>
        <div class='output-text col3' id='andivua'></div>
        <div class='stt col4'>1.3</div>
        <div class='text col5'>Bảo hiểm thất nghiệp</div>
        <div class='output-text col6' id='bh-thatnghiep'></div>
    </div>
    <div class="row">
        <div class='stt col1'>2.3</div>
        <div class='text col2'>Điện thoại</div>
        <div class='output-text col3' id='dienthoai'>150000</div>
        <div class='stt col4'>2</div>
        <div class='text col5'>Thuế thu nhập cá nhân</div>
        <div class='output-text col6' id='thue'></div>
    </div>
    <div class="row">
        <div class='stt col1'>2.4</div>
        <div class='text col2'>Xăng xe</div>
        <div class='output-text col3'>300000</div>
        <div class='stt col4'>3</div>
        <div class='text col5'>Tạm ứng</div>
        <div class='output-text col6' id='tamung'></div>
    </div>
    <div class="row">
        <div class='stt col1'>2.5</div>
        <div class='text col2'>Nhà ở</div>
        <div class='output-text col3'>500000</div>
        <div class='stt col4'>4</div>
        <div class='text col5'>Khác</div>
        <div class='output-text col6' id='khac'></div>
    </div>
    <div class="row">
        <div class='stt col1'>2.6</div>
        <div class='text col2'>Nuôi con nhỏ</div>
        <div class='output-text col3' id='connho'></div>
        <div class='stt col4'></div>
        <div class='text col5'></div>
        <div class='output-text col6'></div>
    </div>
    <div class="row">
        <div class="col1"></div>
        <div class='text col2'>Tổng cộng</div>
        <div class='output-text col3' id='tongthu'></div>
        <div class="col4"></div>
        <div class='text col5'>Tổng cộng</div>
        <div class='output-text col6' id='tongdivu'></div>
    </div>
    <div class="row">
        <div class="col1"></div>
        <div class="col2"></div>
        <div class="col3"></div>
        <div class="col4"></div>
        <div class="col5"></div>
        <div class="col6"></div>
    </div>
    <div class="row">
        <div class="col1"></div>
        <div class='text col2'>Tổng thành tiền</div>
        <div class='output-text col3' id='tongcong'><?= $slips['TONGTIEN']?></div>
        <div class="col4"></div>
        <div class="col5"></div>
        <div class="col6"></div>
    </div>
    <div class="row">
        <div class="col1"></div>
        <div class='text col2'></div>
        <div class='output-text col3'></div>
        <div class="col4"></div>
        <div class="col5"></div>
        <div class="col6"></div>
    </div>
</div>

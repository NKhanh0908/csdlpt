<?php
header('Content-Type: application/json');

include('../../Controller/connectDB.php');
$conn = getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $id = isset($data['id']) ? $data['id'] : null;
    
    $lydo = isset($data['lydo']) ? $data['lydo'] : null;

    $ngaynghi = isset($data['ngaynghi']) ? $data['ngaynghi'] : null;
    $holiday = date($ngaynghi);

//Kiểm tra có nhậphay chưa
if($ngaynghi == ''){
    $response = [
        'status' => 6,
        'message' => 'Không định nghỉ hả'
    ];

    echo json_encode($response);
    exit;
}
//Kiểm tra có lý do hay chưa
if($lydo == ''){
    $response = [
        'status' => 5,
        'message' => 'Nhập lý do bạn êy'
    ];

    echo json_encode($response);
    exit;
}

//Khởi tạo ngày hiện tại
$today = date('Y-m-d');
//Lấy ra tháng
$month = date("m",strtotime($today));
//Lấy ra năm
$year= date("Y",strtotime($today));


//Ngày nghỉ lớn hơn bữa nay: Kiểm tra dữ liệu đầu vào

if($holiday < $today){
    $response = [
        'status' => 4,
        'message' => 'Nghỉ trước khi xin luôn, ghê'
    ];

    echo json_encode($response);
    exit;
}

//Kiểm tra coi ngày nghỉ có chưa
$test = mysqli_query($conn, "SELECT DATE_FORMAT(NGAYNGHI, '%Y-%m-%d') AS NGAYNGHI from ngaynghi WHERE 
DATE_FORMAT(NGAYNGHI, '%Y-%m-%d')='$today' AND idNV='$id'");

if($tester = mysqli_num_rows($test) > 0){
    $response = [
        'status' => 3,
        'message' => 'Xin nghỉ rồi á bây'
    ];

    echo json_encode($response);
    exit;
}


//Kiểm tra tháng này xin nghỉ bao nhiêu lần gồi
$leave = mysqli_query($conn, "SELECT NGAYNGHI from ngaynghi WHERE 
DATE_FORMAT(NGAYNGHI, '%m')='$month' AND DATE_FORMAT(NGAYNGHI, '%Y')='$year' AND idNV='$id'");

//Lấy ra ngày đã nghỉ trong tháng
$num_leave = mysqli_num_rows($leave);

if($num_leave > 3){
    $response = [
        'status' => 2,
        'message' => 'Quá số lần xin phép trong tháng rồi đi~ ơi'
    ];

    echo json_encode($response);
    exit;
}

//Kiểm tra tháng này đã được duyệt phép chưa (Tối đa 1)
$authorized_leave = mysqli_query($conn, "SELECT NGAYNGHI from ngaynghi WHERE 
DATE_FORMAT(NGAYNGHI, '%m')='$month' AND DATE_FORMAT(NGAYNGHI, '%Y')='$year' AND TRANGTHAI=1 AND idNV='$id'");


if(mysqli_num_rows($authorized_leave) > 0){
    $response = [
        'status' => 1,
        'message' => 'Tháng được phép 1 ngày thoi đi~ ơi'
    ];

    echo json_encode($response);
    exit;
}

// Xử lý insert
    mysqli_query($conn, "INSERT INTO ngaynghi(idNV, NGAYNGHI, LYDO)
    VALUES ('$id', '$ngaynghi', '$lydo')");

    //Kết thúc xử lý
    $response = [
        'status' => 0,
        'message' => 'Gửi đơn xin nghỉ rồi á, chờ duyệt nghen mom'
    ];

    echo json_encode($response);
    exit;
}
?>
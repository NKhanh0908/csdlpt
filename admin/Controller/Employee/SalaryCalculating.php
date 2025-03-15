<?php

include('../../Controller/connectDB.php');
$conn = getConnection();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    //Khỏi tạo biến
    $luongcoban = 0;
    $salary = 0;

    $id = isset($data['id']) ? $data['id'] : null;

    $luong = mysqli_query($conn, "SELECT LUONGCOBAN from nhanvien WHERE idTK=".intval($id));
    while($luong_row = mysqli_fetch_assoc($luong)){
        $luongcoban = $luong_row['LUONGCOBAN'];
    }

    //Tính số ngày của tháng này
    $today = date("Y-m-d");
    $month = date("m", strtotime($today));
    $year = date("Y", strtotime($today));
    $days_of_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    // echo "\n Số ngày trong tháng $month : ". $days_of_month;

    //Lấy ra số ngày đã chấm công
    $times = mysqli_query($conn, "SELECT HESO from bangchamcong WHERE DATE_FORMAT(NGAYLAM, '%m')='$month'
    AND DATE_FORMAT(NGAYLAM, '%Y')='$year' AND CHECKOUT!=0 AND idNV=" . intval($id));

    $timekeeping_days = mysqli_num_rows($times);
    // echo "\n Số ngày chấm công: " . $timekeeping_days;

    $count = 0;
    while($salary_keep = mysqli_fetch_array($times)){
        if($salary_keep['HESO'] == 2) $count++;
        $salary += $salary_keep['HESO'] * $luongcoban;
    }
    // echo "\n Số ngày có hệ số 2: " . $count;

    //Lấy ra số ngày nghỉ có phép
    $authorized_leave = mysqli_query($conn, "SELECT idNV from ngaynghi WHERE DATE_FORMAT(NGAYNGHI, '%m')='$month'
    AND DATE_FORMAT(NGAYNGHI, '%Y')='$year' AND TRANGTHAI=1 AND idNV=" . intval($id));

    $authorized_leave_days = mysqli_num_rows($authorized_leave);

    if($authorized_leave_days > 1){
        echo "Số ngày nghỉ trong tháng lớn hơn 1 rồi, vui lòng xử lý trước đê";
        exit;
    }

    // echo "\n Số ngày nghỉ có phép: ". $authorized_leave_days;

    // $salary += $authorized_leave_days * $luongcoban * 0.5;

    //Số ngày nghỉ không phép
    $unauthorized_leave_days = $days_of_month - $authorized_leave_days - $timekeeping_days; 
    // echo "\n Số ngày nghỉ không phép: " . $unauthorized_leave_days;

    //Tính lương sigma(ngày chấm công * hệ số * lương) + nghỉ có phép * lương * hệ số mặc định 0.5 
    // echo "\nLương sau khi ấy: " . $salary;
    $hesongayle = 2;

    $response = [
        'ngaycong' => $days_of_month,
        'ngaycongtt'=> $timekeeping_days,
        'ngayle' => $count,
        'nghiphep' => $authorized_leave_days,
        'luongchinh' => $salary,
        'hesongayle' => $hesongayle,
    ];
}

    mysqli_close($conn);

    $json = json_encode($response);
    echo $json;

    exit;

?>
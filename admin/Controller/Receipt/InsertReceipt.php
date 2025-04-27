<?php
include('../connector.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $idNCC = isset($data['idNCC'])? $data['idNCC'] : '';
    $loinhuan = isset($data['loinhuan'])? intval($data['loinhuan']) : 1;
    $thanhtien = isset($data['thanhtien'])? floatval($data['thanhtien']) : 1;
    $branch = isset($data['branch'])? $data['branch'] : '';
    $connect = getConnection($branch);

    //Khỏi tạo phiếu nhập
    // $pn_row = sqlsrv_query($connect, "SELECT idPN from phieunhap");
    // $idPN = sqlsrv_num_rows($pn_row) + 1;

    //Làm tí ngày hiện tại
    $today = date('Y-m-d');

    // Sử dụng SCOPE_IDENTITY() thay vì OUTPUT INSERTED vì bảng có trigger
    $sql = "INSERT INTO phieunhap(idNCC, NGAYNHAP, THANHTIEN, LOINHUAN)
    VALUES($idNCC, '$today', '$thanhtien' , $loinhuan);
    SELECT SCOPE_IDENTITY() AS idPN;";

    $result = sqlsrv_query($connect, $sql);
    
    if ($result === false) {
        // Xử lý lỗi nếu có
        $errors = sqlsrv_errors();
        echo json_encode(['status' => 'error', 'message' => 'Lỗi khi thêm phiếu nhập: ' . $errors[0]['message']]);
        exit;
    }
    
    // Chuyển đến kết quả thứ hai (SELECT)
    sqlsrv_next_result($result);
    
    // Lấy ID từ kết quả
    $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
    $idPN = $row['idPN'];


    $response = [
        'id' => $idPN,
        'loinhuan' => $loinhuan,
        'thanhtien' => $thanhtien,
        'message' => "Thim phíu nhập thành kong" 
    ];

    $json = json_encode($response);
    echo $json;
}
?>
<?php
include('../connector.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $idPN = isset($data['idPN'])? $data['idPN'] : '';
    $idSP = isset($data['idSP'])? $data['idSP'] : '';
    $soluong = isset($data['soluong'])? $data['soluong'] : '';
    $gianhap = isset($data['gianhap'])? $data['gianhap'] : '';
    $branch = isset($data['branch'])? $data['branch'] : '';
    $connect = getConnection($branch);


    //$giaban = intval($gianhap) * (1 + intval($loinhuan)/100);

    //Insert vào chitietphieunnhap
    $sql = "INSERT INTO chitietphieunhap (idPN, idSP, SOLUONG)
    VALUES($idPN, $idSP, $soluong)";

    sqlsrv_query($connect, $sql);

    if($branch == 'branch2'){
        $idCN = 1;
    }else if($branch == 'branch3'){
        $idCN = 2;
    }else if($branch == 'branch4'){
        $idCN = 3;
    }

    $checkExistProduct = sqlsrv_query($connect, "SELECT * FROM kho k INNER JOIN tonkho tk ON k.idKho = tk.idKho WHERE k.idCN = $idCN AND tk.idSP = $idSP");
    
    // Thêm log để debug
    error_log("Kiểm tra sản phẩm trong kho: idCN=$idCN, idSP=$idSP");
    
    // Kiểm tra xem có kết quả không
    $hasRows = sqlsrv_has_rows($checkExistProduct);
    error_log("Có kết quả: " . ($hasRows ? "Có" : "Không"));
    
    if($hasRows){
        // Lấy dữ liệu từ kết quả truy vấn
        $row = sqlsrv_fetch_array($checkExistProduct, SQLSRV_FETCH_ASSOC);
        $idKho = $row['idKho'];
        error_log("Tìm thấy sản phẩm trong kho: idKho=$idKho, idSP=$idSP");
        
        // Cập nhật số lượng
        $updateExistProduct = sqlsrv_query($connect, "UPDATE tonkho SET SOLUONG = SOLUONG + $soluong WHERE idKho = $idKho AND idSP = $idSP");
        if($updateExistProduct === false) {
            error_log("Lỗi khi cập nhật số lượng: " . print_r(sqlsrv_errors(), true));
        } else {
            error_log("Đã cập nhật số lượng sản phẩm: +$soluong");
        }
    } else {
        error_log("Không tìm thấy sản phẩm trong kho, thêm mới");
        
        // Lấy idKho từ bảng kho
        $khoResult = sqlsrv_query($connect, "SELECT idKho FROM kho WHERE idCN = $idCN");
        if($khoResult === false) {
            error_log("Lỗi khi lấy idKho: " . print_r(sqlsrv_errors(), true));
            echo json_encode(['status' => 'error', 'message' => 'Lỗi khi lấy thông tin kho']);
            exit;
        }
        
        $khoRow = sqlsrv_fetch_array($khoResult, SQLSRV_FETCH_ASSOC);
        if($khoRow === false) {
            error_log("Không tìm thấy kho cho chi nhánh: $idCN");
            echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy kho cho chi nhánh']);
            exit;
        }
        
        $idKho = $khoRow['idKho'];
        error_log("Thêm sản phẩm mới vào kho: idKho=$idKho, idSP=$idSP, số lượng=$soluong");
        
        // Thêm sản phẩm mới vào kho
        $insertExistProduct = sqlsrv_query($connect, "INSERT INTO tonkho (idKho, idSP, SOLUONG) VALUES($idKho, $idSP, $soluong)");
        if($insertExistProduct === false) {
            error_log("Lỗi khi thêm sản phẩm vào kho: " . print_r(sqlsrv_errors(), true));
            echo json_encode(['status' => 'error', 'message' => 'Lỗi khi thêm sản phẩm vào kho']);
            exit;
        } else {
            error_log("Đã thêm sản phẩm mới vào kho thành công");
        }
    }

    $checkPriceProduct = sqlsrv_query($connect, "SELECT GIANHAP FROM sanpham WHERE idSP = $idSP");
    $row = sqlsrv_fetch_array($checkPriceProduct, SQLSRV_FETCH_ASSOC);
    $gianhapSP = $row['GIANHAP'];

    if($gianhapSP != $gianhap){
        $updatePriceProduct = sqlsrv_query($connect, "UPDATE sanpham SET GIANHAP = $gianhap WHERE idSP = $idSP");
        if($updatePriceProduct === false) {
            error_log("Lỗi khi cập nhật giá nhập: " . print_r(sqlsrv_errors(), true));
        } else {
            error_log("Đã cập nhật giá nhập sản phẩm: $idSP");
        }
    }
    
    


    //sqlsrv_query($connect, "UPDATE sanpham SET GIANHAP = " . intval($gianhap) . ", GIA = " . intval($giaban) . " WHERE idSP=" . intval($idSP));
    
    $response = [
        'message' => 'Đã thêm sản phẩm ' . intval($idSP) . ' vào phiếu nhập ' . intval($idPN)
    ];

    $json = json_encode($response);
    echo $json;
}
?>
<?php
include('../connector.php');



// Lấy trạng thái từ request
$status = isset($_GET["status"]) ? $_GET["status"] : "all";
$branch = isset($_GET["branch"]) ? $_GET["branch"] : "branch1";

if($branch == 'branch1'){
    getAllOderOfAllBranch($status);
}else{
    getAllOderOfSingleBranch( $branch, $status);
}




function getAllOderOfAllBranch($status = "all") {
    // Danh sách các linked servers (bao gồm server chính ở vị trí đầu)
    $servers = [
        'LOCAL'      => 'chdidong.dbo',
        'LINKEDSV2'  => 'LINKEDSV2.chdidong.dbo',
        'LINKEDSV3'  => 'LINKEDSV3.chdidong.dbo'
    ];

    // Kết nối đến một server bất kỳ (chỉ để chạy UNION)
    $conn = getConnection('branch2');

    // Chuyển status thành số nguyên nếu cần lọc
    $filterStatus = ($status !== "all") ? intval($status) : null;

    $subqueries = [];
    $params = [];  // lưu tham số cho mỗi WHERE

    foreach ($servers as $prefix) {
        $sql = "SELECT 
                    d.idHD, 
                    tk.USERNAME AS khachhang, 
                    d.NGAYMUA, 
                    d.THANHTIEN, 
                    t.STATUS, 
                    d.idCN
                FROM {$prefix}.donhang d
                JOIN {$prefix}.taikhoan tk    ON d.idTK     = tk.idTK
                JOIN {$prefix}.trangthaidonhang t ON d.TRANGTHAI = t.idSTATUS";

        if ($filterStatus !== null) {
            $sql .= " WHERE d.TRANGTHAI = ?";
            $params[] = $filterStatus;
        }

        $subqueries[] = $sql;
    }

    // Ghép UNION ALL và thêm ORDER BY ở cuối
    $fullQuery = implode(" UNION ALL ", $subqueries) . " ORDER BY NGAYMUA DESC";

    // Thực thi
    $stmt = sqlsrv_query($conn, $fullQuery, $params);

    if ($stmt === false) {
        // Trả về JSON lỗi
        die(json_encode(["error" => sqlsrv_errors()]));
    }

    $orders = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        // Chuyển DateTime object thành chuỗi
        if ($row['NGAYMUA'] instanceof DateTime) {
            $row['NGAYMUA'] = $row['NGAYMUA']->format('Y-m-d');
        }
        $orders[] = $row;
    }

    // Đóng kết nối (nếu cần)
    sqlsrv_close($conn);

    // In ra JSON kết quả
    echo json_encode($orders);
}


function getAllOderOfSingleBranch($branch, $status= "all"){
    $query = "SELECT d.idHD, tk.USERNAME AS khachhang, d.NGAYMUA, d.THANHTIEN, t.STATUS, d.idCN 
                FROM [chdidong].[dbo].[donhang] d 
                JOIN taikhoan tk ON d.idTK = tk.idTK
                JOIN trangthaidonhang t ON d.TRANGTHAI = t.idSTATUS";

    if ($status !== "all") {
        $query .= " WHERE d.TRANGTHAI = " . intval($status);
    }

    $sql = $query .  " ORDER BY idHD ASC";

    $conn = getConnection($branch);  
    $getProducts = sqlsrv_query($conn, $sql);

    if (!$getProducts) {
        die(json_encode(["error" => sqlsrv_errors()])); // In lỗi ra nếu có
    }

    $orders = [];
    while ($row = sqlsrv_fetch_array($getProducts, SQLSRV_FETCH_ASSOC)) {
        if ($row['NGAYMUA'] instanceof DateTime) {
            $row['NGAYMUA'] = $row['NGAYMUA']->format('Y-m-d'); // Format ngày giờ
        }
        $orders[] = $row;
    }
    

    

    header('Content-Type: application/json');
    echo json_encode($orders);
}
?>
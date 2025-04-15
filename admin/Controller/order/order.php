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
    // Kết nối đến server chính (MSSQLSERVER3) thay vì branch2
    $conn = getConnection('branch1');
    
    $query = "SELECT d.idHD, tk.USERNAME AS khachhang, d.NGAYMUA, d.THANHTIEN, t.STATUS, d.idCN
              FROM chdidong.dbo.donhang d 
              JOIN chdidong.dbo.taikhoan tk ON d.idTK = tk.idTK
              JOIN chdidong.dbo.trangthaidonhang t ON d.TRANGTHAI = t.idSTATUS";
    
    if ($status !== "all") {
        $query .= " WHERE d.TRANGTHAI = " . intval($status);
    }
    
    $query .= " ORDER BY idHD ASC";
    
    $getProducts = sqlsrv_query($conn, $query);
    
    if (!$getProducts) {
        die(json_encode(["error" => sqlsrv_errors()]));
    }
    
    $orders = [];
    while ($row = sqlsrv_fetch_array($getProducts, SQLSRV_FETCH_ASSOC)) {
        if ($row['NGAYMUA'] instanceof DateTime) {
            $row['NGAYMUA'] = $row['NGAYMUA']->format('Y-m-d');
        }
        $orders[] = $row;
    }
    
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
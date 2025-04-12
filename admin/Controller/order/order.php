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
    $linkedServers = ["LINKEDSV2", "LINKEDSV3", "LINKEDSV4"];
    $queries = [];

    foreach ($linkedServers as $server) {
        $query = "SELECT d.idHD, tk.USERNAME AS khachhang, d.NGAYMUA, d.THANHTIEN, t.STATUS, d.idCN
                  FROM [$server].[chdidong].[dbo].[donhang] d 
                  JOIN taikhoan tk ON d.idTK = tk.idTK
                  JOIN trangthaidonhang t ON d.TRANGTHAI = t.idSTATUS";

        if ($status !== "all") {
            $query .= " WHERE d.TRANGTHAI = " . intval($status);
        }

        $queries[] = $query;
    }

    
 
    $sql = implode(" UNION ALL ", $queries) . " ORDER BY idHD ASC";

    $conn = getConnection('branch2'); // Kết nối đến một chi nhánh bất kỳ có quyền truy vấn LINKED SERVER
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
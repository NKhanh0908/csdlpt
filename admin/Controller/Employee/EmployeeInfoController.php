<?php
include('../connector.php');

// Lấy tham số chi nhánh từ request
$branch = isset($_GET["branch"]) ? $_GET["branch"] : "all";

// Kết nối đến database chính (branch1) để lấy dữ liệu từ tất cả chi nhánh
$conn = getConnection('branch1');

// Xây dựng query cơ bản
$query = "SELECT 
             tk.idTK, tk.HOTEN, tk.SDT, tk.EMAIL, nv.GIOITINH, nv.NGAYSINH, nv.NGAYSINH, nv.DIACHI, nv.IMG, nv.NGAYVAOLAM, nv.TINHTRANG
            , nv.DIACHI, nv.NGAYVAOLAM, 
             tk.TRANGTHAI, cv.TENCHUCVU as tenCV, nv.idCN,
            cn.ten AS TEN_CHI_NHANH
          FROM chdidong.dbo.taikhoan tk
          JOIN chdidong.dbo.nhanvien nv ON tk.idTK = nv.idTK
          JOIN chdidong.dbo.chucvu cv on nv.idCV = cv.idCV
        --   JOIN chdidong.dbo.quyen q ON tk.QUYEN = q.idQUYEN
          JOIN chdidong.dbo.chinhanh cn ON nv.idCN = cn.idCN";
          

// Thêm điều kiện lọc nếu không phải là "all"
if ($branch !== "all") {
    $query .= " WHERE nv.idCN = " . intval(str_replace("branch", "", $branch));
}

$query .= " ORDER BY tk.idTK ASC";

$result = sqlsrv_query($conn, $query);

if (!$result) {
    die(json_encode(["error" => sqlsrv_errors()]));
}

$employees = [];
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    // Format các trường ngày tháng
    if ($row['NGAYSINH'] instanceof DateTime) {
        $row['NGAYSINH'] = $row['NGAYSINH']->format('Y-m-d');
    }
    if ($row['NGAYVAOLAM'] instanceof DateTime) {
        $row['NGAYVAOLAM'] = $row['NGAYVAOLAM']->format('Y-m-d');
    }
    $employees[] = $row;
}

header('Content-Type: application/json');
echo json_encode($employees);
?>
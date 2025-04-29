<?php
include('../connector.php');

// Lấy tham số chi nhánh từ request
$branch = isset($_GET["branch"]) ? $_GET["branch"] : "all";

// Kết nối đến database chính (branch1) để lấy dữ liệu từ tất cả chi nhánh
$sql ="";
if($branch == "all"){
    $conn = getConnection('branch2');
    $sql .= "SELECT 
    tk.idTK, tk.HOTEN, tk.SDT, tk.EMAIL,
    nv.GIOITINH, nv.NGAYSINH, nv.DIACHI,
    nv.IMG, nv.NGAYVAOLAM, nv.TINHTRANG,
    tk.TRANGTHAI, cv.TENCHUCVU AS tenCV,
    nv.idCN, cn.ten AS TEN_CHI_NHANH
FROM chdidong.dbo.taikhoan tk
JOIN chdidong.dbo.nhanvien    nv ON tk.idTK = nv.idTK
JOIN chdidong.dbo.chucvu      cv ON nv.idCV = cv.idCV
JOIN chdidong.dbo.chinhanh    cn ON nv.idCN = cn.idCN

UNION ALL

SELECT 
    tk.idTK, tk.HOTEN, tk.SDT, tk.EMAIL,
    nv.GIOITINH, nv.NGAYSINH, nv.DIACHI,
    nv.IMG, nv.NGAYVAOLAM, nv.TINHTRANG,
    tk.TRANGTHAI, cv.TENCHUCVU AS tenCV,
    nv.idCN, cn.ten AS TEN_CHI_NHANH
FROM LINKEDSV2.chdidong.dbo.taikhoan tk
JOIN LINKEDSV2.chdidong.dbo.nhanvien nv ON tk.idTK = nv.idTK
JOIN LINKEDSV2.chdidong.dbo.chucvu   cv ON nv.idCV = cv.idCV
JOIN LINKEDSV2.chdidong.dbo.chinhanh cn ON nv.idCN = cn.idCN

UNION ALL

SELECT 
    tk.idTK, tk.HOTEN, tk.SDT, tk.EMAIL,
    nv.GIOITINH, nv.NGAYSINH, nv.DIACHI,
    nv.IMG, nv.NGAYVAOLAM, nv.TINHTRANG,
    tk.TRANGTHAI, cv.TENCHUCVU AS tenCV,
    nv.idCN, cn.ten AS TEN_CHI_NHANH
FROM LINKEDSV3.chdidong.dbo.taikhoan tk
JOIN LINKEDSV3.chdidong.dbo.nhanvien nv ON tk.idTK = nv.idTK
JOIN LINKEDSV3.chdidong.dbo.chucvu   cv ON nv.idCV = cv.idCV
JOIN LINKEDSV3.chdidong.dbo.chinhanh cn ON nv.idCN = cn.idCN;
";

}else{
    $conn = getConnection($branch);
    $sql .= "SELECT 
    tk.idTK, tk.HOTEN, tk.SDT, tk.EMAIL,
    nv.GIOITINH, nv.NGAYSINH, nv.DIACHI,
    nv.IMG, nv.NGAYVAOLAM, nv.TINHTRANG,
    tk.TRANGTHAI, cv.TENCHUCVU AS tenCV,
    nv.idCN, cn.ten AS TEN_CHI_NHANH
FROM chdidong.dbo.taikhoan tk
JOIN chdidong.dbo.nhanvien    nv ON tk.idTK = nv.idTK
JOIN chdidong.dbo.chucvu      cv ON nv.idCV = cv.idCV
JOIN chdidong.dbo.chinhanh    cn ON nv.idCN = cn.idCN";
}


$result = sqlsrv_query($conn, $sql);

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
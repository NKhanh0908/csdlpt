<?php
function getConnection($branch = "branch2") {
    $servers = [
        'branch1' => 'LAPTOP-O2NQEJ35',          // Server chính
        'branch2' => 'LAPTOP-O2NQEJ35\MSSQLSERVER2',  
        'branch3' => 'LAPTOP-O2NQEJ35\MSSQLSERVER3',  
        'branch4' => 'LAPTOP-O2NQEJ35\MSSQLSERVER4'
    ];

    $database = "chdidong";
    $uid = "sa";
    $password = "13524679";

    if (!isset($servers[$branch])) {
        die("Chi nhánh không tồn tại!");
    }

    $connectionInfo = [
        "Database" => $database,
        "Uid" => $uid,
        "PWD" => $password,
        "CharacterSet" => "UTF-8"
    ];

    $conn = sqlsrv_connect($servers[$branch], $connectionInfo);

    if (!$conn) {
        die(print_r(sqlsrv_errors(), true));
    }
    return $conn;
}




// Kiểm tra xem chi nhánh có tồn tại không
function isBranchValid($conn, $branchId) {
    $sql = "SELECT COUNT(*) FROM dbo.chinhanh WHERE idCN = ?";
    $params = array($branchId);
    $stmt = sqlsrv_query($conn, $sql, $params);
    
    if ($stmt === false) {
        throw new Exception("Lỗi khi kiểm tra chi nhánh: " . print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    return $row[''] > 0;
}


function getActiveBranches() {
    $branchesList = [];
    
    // Kết nối tới cơ sở dữ liệu
    $conn = getConnection('branch1');  // Kết nối đến chi nhánh mặc định hoặc chi nhánh bạn muốn
    if (!$conn) {
        throw new Exception("Không thể kết nối tới cơ sở dữ liệu");
    }

    // Truy vấn để lấy thông tin chi nhánh
    $tsql = "SELECT [idCN], [ten], [diachi], [email], [sdt] FROM [chdidong].[dbo].[chinhanh]";
    $stmt = sqlsrv_query($conn, $tsql);

    if ($stmt === false) {
        throw new Exception("Truy vấn không thành công: " . print_r(sqlsrv_errors(), true));
    }

    // Lấy kết quả và đưa vào mảng
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $branchesList[] = $row;
    }

    // Giải phóng bộ nhớ và đóng kết nối
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
    
    return $branchesList;
}


// Hàm kiểm tra sự tồn tại của chức vụ
function getJobTitles($conn) {
    $sql = "SELECT idCV, TENCHUCVU FROM chucvu"; // ✅ đúng cột
    $stmt = sqlsrv_query($conn, $sql);

    if (!$stmt) {
        throw new Exception("Lỗi khi truy vấn chức vụ: " . print_r(sqlsrv_errors(), true));
    }

    $result = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $result[] = $row;
    }
    return $result;
}
function jobTitleExists($jobTitleId, $conn) {
    // Truy vấn để kiểm tra chức vụ có tồn tại hay không
    $sql = "SELECT COUNT(*) FROM chucvu WHERE idCV = ?";
    $stmt = sqlsrv_query($conn, $sql, array($jobTitleId));

    if (!$stmt) {
        throw new Exception("Lỗi khi kiểm tra chức vụ: " . print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    return $row['COUNT(*)'] > 0;  // Nếu đếm được >= 1, tức là chức vụ tồn tại
}


// Hàm lấy chi nhánh của nhân viên
function getEmployeeBranch($employeeId) {
    $conn = getConnection('branch1'); // Chọn chi nhánh mặc định (hoặc có thể thay đổi nếu cần)

    if (!$conn) {
        throw new Exception("Không thể kết nối tới cơ sở dữ liệu");
    }

    // Truy vấn để lấy chi nhánh của nhân viên
    $tsql = "SELECT idCN FROM [chdidong].[dbo].[nhanvien] WHERE idTK = ?";
    $params = array($employeeId);
    $stmt = sqlsrv_query($conn, $tsql, $params);

    if ($stmt === false) {
        throw new Exception("Truy vấn không thành công: " . print_r(sqlsrv_errors(), true));
    }

    // Lấy chi nhánh từ kết quả truy vấn
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $branchId = $row['idCN'] ?? null;

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);

    return $branchId; // Trả về ID chi nhánh
}


function getValidBranch($idCN) {
    $branchMap = [
        1 => 'branch2',
        2 => 'branch3',
        3 => 'branch4'
    ];

    if (!isset($branchMap[$idCN])) {
        die("<script>alert('ID chi nhánh không hợp lệ!');</script>");
    }

    $conn = getConnection($branchMap[$idCN]);

    if (!$conn) {
        die("<script>alert('Không thể kết nối đến chi nhánh $idCN!');</script>");
    }

    return $conn;
}

?>
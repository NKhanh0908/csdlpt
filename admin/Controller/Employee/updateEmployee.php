<?php
include_once('../Controller/connector.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cấu hình ánh xạ id chi nhánh sang connection name
function getBranchConnectionName($idCN) {
    switch ($idCN) {
        case 1: return 'branch2';
        case 2: return 'branch3';
        case 3: return 'branch4';
        default: return null;
    }
}


// Khởi tạo biến
$errors = [];
$success = '';
$employeeData = [];
$branchesList = getActiveBranches();
$connForJobTitles = getConnection('branch2'); // Hoặc chi nhánh nào bạn muốn
$jobTitlesList = getJobTitles($connForJobTitles);


try {
    if (isset($_GET['id'])) {
        $employeeId = (int)$_GET['id'];
        $currentBranchId = getEmployeeBranch($employeeId);
        $conn = getConnection(getBranchConnectionName($currentBranchId));
        $employeeData = getEmployeeData($employeeId, $conn);
    }
} catch (Exception $e) {
    $errors[] = $e->getMessage();
}

// Xử lý form submit
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['updateEmployee'])) {
    try {
        $idTK = (int)($_POST['idTK'] ?? 0);
        // $fullname = trim($_POST['fullname'] ?? '');
        // $gender = in_array($_POST['gender'] ?? '', ['Nam', 'Nữ', 'Khác']) ? $_POST['gender'] : 'Khác';
        $dob = $_POST['dob'] ?? '';
        $startDate = $_POST['startDate'] ?? '';
        $address = trim($_POST['address'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $status = (int)($_POST['status'] ?? 0);
        $newBranchId = (int)($_POST['branch'] ?? 0);    
        $jobTitle = (int)($_POST['jobTitle'] ?? 0);
        $imgPath = null;

        // Validate
        // if (!preg_match('/^0[0-9]{9}$/', $phone)) throw new Exception("Số điện thoại không hợp lệ.");
        // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new Exception("Email không hợp lệ.");
       


        // $newConnName = getBranchConnectionName($newBranchId);
        // if (!$newConnName) throw new Exception("Chi nhánh mới không hợp lệ.");

        // Lấy chi nhánh hiện tại
        $currentBranchId = getEmployeeBranch($idTK);
        $currentConnName = getBranchConnectionName($currentBranchId);
        $currentConnName = getBranchConnectionName($currentBranchId);
        echo $currentBranchId . $currentConnName;
        if (!$currentConnName) throw new Exception("Chi nhánh hiện tại không hợp lệ.");

        $oldConn = getConnection($currentConnName);
        $employeeData = getEmployeeData($idTK, $oldConn);

        // Xử lý ảnh
        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'];
            $maxSize = 2 * 1024 * 1024;
            $fileType = $_FILES['img']['type'];
            $fileSize = $_FILES['img']['size'];

            if (!array_key_exists($fileType, $allowedTypes)) {
                throw new Exception("Chỉ chấp nhận ảnh JPG, PNG hoặc GIF.");
            }
            if ($fileSize > $maxSize) {
                throw new Exception("Kích thước ảnh tối đa là 2MB.");
            }

            $ext = $allowedTypes[$fileType];
            $imgName = 'emp_' . $idTK . '_' . time() . '.' . $ext;
            $uploadDir = '../../images/employee/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $uploadPath = $uploadDir . $imgName;
            if (!move_uploaded_file($_FILES['img']['tmp_name'], $uploadPath)) {
                throw new Exception("Tải ảnh thất bại.");
            }

            $imgPath = 'images/employee/' . $imgName;

            // Xóa ảnh cũ nếu có
            if (!empty($employeeData['IMG'])) {
                @unlink('../../' . $employeeData['IMG']);
            }
        }

        // Cập nhật tài khoản ở chi nhánh hiện tại
        //checkDuplicateInfo($oldConn, $idTK, $phone, $email);
        updateAccount($oldConn, $idTK, $phone, $email, $status);

        if ($newBranchId === $currentBranchId) {
            updateEmployee($oldConn, $idTK, [
                'DIACHI' => $address,
                'TINHTRANG' => $status,
                'idCV' => $jobTitle,
                'IMG' => $imgPath
            ]);
            $success = "Cập nhật thông tin thành công.";
        } else {
            updateEmployee($oldConn, $idTK, [
                'DIACHI' => $address,
                'TINHTRANG' => $status,
                'idCV' => $jobTitle,
                'IMG' => $imgPath
            ]);
            // Di chuyển nhân viên sang chi nhánh mới
            transferEmployeeToBranch($idTK, $currentBranchId, $newBranchId);
            $success = "Chuyển nhân viên sang chi nhánh mới thành công!";
        }

    } catch (Exception $e) {
        $errors[] = $e->getMessage();
    }
}

// =======================
// ==== HÀM HỖ TRỢ =======
// =======================



function transferEmployeeToBranch($idTK, $fromBranchId, $toBranchId) {
    $fromConn = getConnection(getBranchConnectionName($fromBranchId));
    $toConn = getConnection(getBranchConnectionName($toBranchId));
    
    sqlsrv_begin_transaction($fromConn);
    sqlsrv_begin_transaction($toConn);
    
    try {
        // Lấy nhân viên
        $queryOldEmp = "SELECT * FROM nhanvien WHERE idTK = ?";
        $empOld = sqlsrv_query($fromConn, $queryOldEmp, [$idTK]);
        $empOld = sqlsrv_fetch_array($empOld, SQLSRV_FETCH_ASSOC);
    
        if (!$empOld) throw new Exception("Không tìm thấy nhân viên!");
    
        // Thêm vào chi nhánh mới
        $sqlInsert = "INSERT INTO nhanvien (idTK, GIOITINH, NGAYSINH, DIACHI, IMG, NGAYVAOLAM, TINHTRANG, idCN, idCV)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
        $params = [
            $empOld['idTK'], $empOld['GIOITINH'], $empOld['NGAYSINH'], $empOld['DIACHI'],
            $empOld['IMG'], $empOld['NGAYVAOLAM'], $empOld['TINHTRANG'], $toBranchId, $empOld['idCV']
        ];

        

    
        $insertResult = sqlsrv_query($toConn, $sqlInsert, $params);
        if ($insertResult === false) throw new Exception("Lỗi chèn: " . print_r(sqlsrv_errors(), true));
    
        // Xoá nhân viên cũ
        $deleteResult = sqlsrv_query($fromConn, "DELETE FROM nhanvien WHERE idTK = ?", [$idTK]);
        if ($deleteResult === false) throw new Exception("Lỗi xoá: " . print_r(sqlsrv_errors(), true));
    
        // Commit
        sqlsrv_commit($fromConn);
        sqlsrv_commit($toConn);
    
        header("Location: ../../View/index.php?page=employee");
        exit;
    
    } catch (Exception $e) {
        sqlsrv_rollback($fromConn);
        sqlsrv_rollback($toConn);
        die("Lỗi khi chuyển nhân viên: " . $e->getMessage());
    }
}    

    // Các hàm hỗ trợ
    function checkDuplicateInfo($conn, $idTK, $phone, $email) {
        $sql = "SELECT COUNT(*) FROM TAIKHOAN WHERE idTK != ? AND (SDT = ? OR EMAIL = ?)";
        $params = array($idTK, $phone, $email);
        $stmt = sqlsrv_query($conn, $sql, $params);
        
        if ($stmt === false) {
            throw new Exception("Lỗi truy vấn cơ sở dữ liệu: " . print_r(sqlsrv_errors(), true));
        }

        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        if ($row[''] > 0) {
            throw new Exception("Số điện thoại hoặc email đã tồn tại.");
        }
    }
    function updateAccount($conn, $idTK, $phone, $email, $status) {
        $sql = "UPDATE taikhoan SET SDT = ?, EMAIL = ? WHERE idTK = ?";
        $params = array($phone, $email, $status, $idTK);
        
        $stmt = sqlsrv_query($conn, $sql, $params);
        
        if ($stmt === false) {
            throw new Exception("Lỗi khi cập nhật tài khoản: " . print_r(sqlsrv_errors(), true));
        }
    }
    function updateEmployee($conn, $idTK, $data) {
        // First, verify the branch exists if we're changing branches
        if (isset($data['idCN'])) {
            $sqlCheckBranch = "SELECT COUNT(*) AS BranchCount FROM dbo.chinhanh WHERE idCN = ?";
            $stmtCheckBranch = sqlsrv_query($conn, $sqlCheckBranch, array($data['idCN']));

            if ($stmtCheckBranch === false) {
                throw new Exception("Lỗi khi kiểm tra chi nhánh: " . print_r(sqlsrv_errors(), true));
            }

            $row = sqlsrv_fetch_array($stmtCheckBranch, SQLSRV_FETCH_ASSOC);
            sqlsrv_free_stmt($stmtCheckBranch);
            
            if ($row['BranchCount'] == 0) {
                throw new Exception("Chi nhánh mới (ID: {$data['idCN']}) không tồn tại trong hệ thống.");
            }
        }

        // Build the update query
        $sql = "UPDATE nhanvien SET 
                DIACHI = ?,
                TINHTRANG = ?,
                idCV = ?";
        
        $params = array(
            $data['DIACHI'],
            $data['TINHTRANG'],
            $data['idCV']
        );

        // Add branch update if needed
        if (isset($data['idCN'])) {
            $sql .= ", idCN = ?";
            $params[] = $data['idCN'];
        }

        // Add image update if needed
        if (isset($data['IMG'])) {
            $sql .= ", IMG = ?";
            $params[] = $data['IMG'];
        }

        $sql .= " WHERE idTK = ?";
        $params[] = $idTK;

        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            throw new Exception("Lỗi khi cập nhật thông tin nhân viên: " . print_r(sqlsrv_errors(), true));
        }
        
        return true;
    }


 
    


// Hàm lấy thông tin nhân viên từ cơ sở dữ liệu
function getEmployeeData($employeeId, $conn) {
    // Kiểm tra kết nối
    if ($conn === null) {
        throw new Exception("Kết nối cơ sở dữ liệu không hợp lệ.");
    }

    $sql = "SELECT * FROM nhanvien WHERE idTK = ?";
    $params = array($employeeId);
    
    // Thực hiện truy vấn
    $stmt = sqlsrv_query($conn, $sql, $params);
    
    // Kiểm tra lỗi truy vấn
    if ($stmt === false) {
        throw new Exception("Lỗi khi truy vấn cơ sở dữ liệu: " . print_r(sqlsrv_errors(), true));
    }
    
    // Lấy dữ liệu nhân viên
    $employee = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    
    // Giải phóng bộ nhớ của statement
    sqlsrv_free_stmt($stmt);
    
    return $employee;
}



    ?>

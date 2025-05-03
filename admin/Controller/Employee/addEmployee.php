<?php
// include('../Controller/connector.php');

// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;



// if (isset($_POST["addEmployee"])) {
//     if (
//         !empty($_POST["hoten"])
//         && !empty($_FILES["txtImg"]["name"])
//         && !empty($_POST["date"])
//         && !empty($_POST["gender"])
//         && !empty($_POST["address"])
//         && !empty($_POST["phone"])
//         && !empty($_POST["email"])
//         && !empty($_POST["ngaylam"])
//         && isset($_POST["idCN"])
//         && isset($_POST["idCV"])
//     ) {
//         echo "<script>console.log('do6 rr')</script>";
//         $hoten = $conn->real_escape_string($_POST["hoten"]);
//         $ngaysinh = $conn->real_escape_string($_POST["date"]);
//         $gioitinh = $conn->real_escape_string($_POST["gender"]);
//         $diachi = $conn->real_escape_string($_POST["address"]);
//         $sdt = $conn->real_escape_string($_POST["phone"]);
//         $email = $conn->real_escape_string($_POST["email"]);
//         $ngaylam = $conn->real_escape_string($_POST["ngaylam"]);
//         $idCN = intval($_POST["idCN"]);
//         $idCV = intval($_POST["idCV"]);

//         $img_temp = $_FILES["txtImg"]["tmp_name"];
//         $images_dir = $_SERVER["DOCUMENT_ROOT"] . "/HTTTDN/images/employee";

//         $options = ["cost" => 12];

//         $hashedPwd = password_hash($ngaysinh, PASSWORD_BCRYPT, $options);

//         // Kiểm tra số điện thoại tồn tại
//         $stmt = $conn->prepare("SELECT * FROM taikhoan WHERE SDT = ? OR EMAIL = ?");
//         $stmt->bind_param("ss", $sdt, $email);
//         $stmt->execute();
//         $result = $stmt->get_result();

//         if ($result->num_rows > 0) {
//             echo "<script>alert('Số điện thoại hoặc email đã tồn tại trong hệ thống. Vui lòng kiểm tra lại!')</script>";
//         } else {
//             // Thêm tài khoản
//             // Trạng thái 2 là trạng thái quản lý nhân sự mới tạo tài khoản cho nhân viên
//             $insert_taikhoan = mysqli_query($conn, "INSERT INTO taikhoan (USERNAME, PASSWORD, SDT, EMAIL, HOTEN, idCN,idCV, TRANGTHAI) 
//                                                     VALUES('$sdt', '$hashedPwd', '$sdt', '$email', '$hoten', '$idCN' ,'$idCV', 2)");

//             if (!$insert_taikhoan) {
//                 die("Lỗi thêm tài khoản: " . mysqli_error($conn));
//             }

//             // Lấy ID tài khoản vừa tạo
//             $idTK = mysqli_insert_id($conn);

//             // Tạo username mới
//             $newUsername = "NV" . $idTK;
//             // Cập nhật username cho tài khoản vừa tạo
//             $sql_update = "UPDATE taikhoan SET USERNAME = '$newUsername' WHERE idTK = $idTK";
//             if (mysqli_query($conn, $sql_update)) {
//                 echo "<script>alert('Sửa tên thành công blabla')</script>";
//             } else {
//                 echo "<script>alert('Lỗi blabla')</script>";
//             }

//             // Đặt tên file ảnh
//             $img_extension = pathinfo($_FILES["txtImg"]["name"], PATHINFO_EXTENSION);
//             $new_name = 'NV' . $idTK . '.' . $img_extension;
//             $img_path = "$images_dir/$new_name";

//             if (!move_uploaded_file($img_temp, $img_path)) {
//                 $error = error_get_last();
//                 die("Lỗi khi upload ảnh: " . $error['message']);
//             }
//             echo "<script>console.log($img_path)</script>";
//             // Thêm nhân viên
//             $insert_nhanvien = mysqli_query($conn, "INSERT INTO nhanvien (idTK, GIOITINH, NGAYSINH, DIACHI, IMG, NGAYVAOLAM, TINHTRANG) 
//                                                     VALUES('$idTK', '$gioitinh', '$ngaysinh', '$diachi', '$new_name', '$ngaylam', 'Dang lam')");

//             if (!$insert_nhanvien) {
//                 die("Lỗi thêm nhân viên: " . mysqli_error($conn));
//             }


//             // Cấu hình gửi email
//             $mail = new PHPMailer(true);
//             try {
//                 $mail->CharSet = "UTF-8"; // Đặt mã hóa UTF-8 để hỗ trợ tiếng Việt
//                 $mail->isSMTP();
//                 $mail->Host = 'smtp.gmail.com'; // Thay bằng SMTP của bạn
//                 $mail->SMTPAuth = true;
//                 $mail->Username = 'ikon1605@gmail.com'; // Email của bạn
//                 $mail->Password = 'wuzs ogxs auif bcns'; // Mật khẩu ứng dụng
//                 $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
//                 $mail->Port = 465;

//                 // Gửi email
//                 $mail->setFrom('ikon1605@gmail.com', 'Your Website');
//                 $mail->addAddress($email);
//                 $mail->Subject = 'Thông tin tài khoản của nhân viên';
//                 $mail->Body = "Đây là thông tin tài khoản của bạn. 
//                 Vui lòng không cung cấp thông tin cho người khác. 
//                 Xin cảm ơn người đẹp.
//                 Vui lòng đăng nhập hệ thống theo thông tin dưới đây
//                 username: $newUsername
//                 mật khẩu: $ngaysinh
//                 chinhanh: $idCN";

//                 $mail->send();

//                 exit();
//             } catch (Exception $e) {
//                 echo "Lỗi gửi email: " . $mail->ErrorInfo;
//             }

//         }
//     }
// }

// Thêm phần log lỗi ở đầu file
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once ('../Controller/connector.php');
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debug: Kiểm tra request và POST data
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    error_log("POST request received");
    if (isset($_POST["addEmployee"])) {
        error_log("addEmployee found in POST data");
    } else {
        error_log("addEmployee NOT found in POST data");
    }
    error_log("POST data: " . print_r($_POST, true));
    error_log("FILES data: " . print_r($_FILES, true));
}

// Kiểm tra POST và xử lý thêm nhân viên
if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST["addEmployee"])) {
    try {
        error_log("Starting employee addition process");
        
        // Xác thực các trường dữ liệu bắt buộc
        $requiredFields = ["hoten", "date", "gender", "address", "phone", "email", "ngaylam", "idCN", "idCV"];
        $missingFields = [];

        // Kiểm tra các trường bắt buộc có dữ liệu hay không
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field]) || trim($_POST[$field]) === '') {
                $missingFields[] = $field;
                error_log("Missing field: $field");
            }
        }

        // Kiểm tra ảnh
        if (empty($_FILES["txtImg"]) || !isset($_FILES["txtImg"]["name"]) || $_FILES["txtImg"]["name"] === "") {
            $missingFields[] = "txtImg (Ảnh)";
            error_log("No image file selected");
        } else if ($_FILES["txtImg"]["error"] !== 0) {
            $missingFields[] = "txtImg (Ảnh)";
            $error_message = "Lỗi upload ảnh: ";
            switch ($_FILES["txtImg"]["error"]) {
                case UPLOAD_ERR_INI_SIZE:
                    $error_message .= "File vượt quá kích thước cho phép";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $error_message .= "File vượt quá kích thước form cho phép";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $error_message .= "File chỉ được upload một phần";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $error_message .= "Không có file nào được upload";
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $error_message .= "Thiếu thư mục tạm";
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $error_message .= "Không thể ghi file";
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $error_message .= "Upload bị dừng bởi extension";
                    break;
                default:
                    $error_message .= "Lỗi không xác định";
                    break;
            }
            error_log("Image upload error: " . $error_message);
        }

        // Nếu thiếu trường nào, ném lỗi
        if (count($missingFields) > 0) {
            $error_message = 'Thiếu thông tin: ' . implode(", ", $missingFields);
            error_log($error_message);
            throw new Exception($error_message);
        }

        // Lấy dữ liệu từ POST
        $hoten = $_POST["hoten"];
        $ngaysinh = $_POST["date"];
        $gioitinh = $_POST["gender"];
        $diachi = $_POST["address"];
        $sdt = $_POST["phone"];
        $email = $_POST["email"];
        $ngaylam = $_POST["ngaylam"];
        $idCN = intval($_POST["idCN"]);
        $idCV = intval($_POST["idCV"]);
        $img_temp = $_FILES["txtImg"]["tmp_name"];

        // Kết nối đến cơ sở dữ liệu chi nhánh
        error_log("Attempting to connect to branch database: $idCN");
        $conn = getValidBranch($idCN);
        if ($conn === false) {
            throw new Exception("Không thể kết nối đến database chi nhánh $idCN");
        }
        error_log("Connected to branch database successfully");

        // Kiểm tra trùng số điện thoại hoặc email
        $check_sql = "SELECT * FROM taikhoan WHERE SDT = ? OR EMAIL = ?";
        $check_params = [$sdt, $email];
        $stmt_check = sqlsrv_prepare($conn, $check_sql, $check_params);
        if (!$stmt_check) {
            throw new Exception("Lỗi chuẩn bị câu lệnh SQL kiểm tra tài khoản: " . print_r(sqlsrv_errors(), true));
        }
        
        if (!sqlsrv_execute($stmt_check)) {
            throw new Exception("Lỗi thực thi kiểm tra tài khoản: " . print_r(sqlsrv_errors(), true));
        }
        
        // if (sqlsrv_has_rows($stmt_check)) {
        //     throw new Exception("Số điện thoại hoặc email đã tồn tại trong hệ thống");
        // }
        error_log("Validated phone and email uniqueness");

        // Hash mật khẩu
        $hashedPwd = password_hash($ngaysinh, PASSWORD_BCRYPT, ["cost" => 12]);
        error_log("Password hashed successfully");

        // Thêm tài khoản vào hệ thống
        $tempUser = $sdt;
        $insert_sql = "INSERT INTO taikhoan (USERNAME, PASSWORD, SDT, EMAIL, HOTEN, TRANGTHAI)
                    VALUES (?, ?, ?, ?, ?, 1)";
        $insert_params = [$tempUser, $hashedPwd, $sdt, $email, $hoten];
        $stmt_insert = sqlsrv_prepare($conn, $insert_sql, $insert_params);
        if (!$stmt_insert) {
            throw new Exception("Lỗi chuẩn bị câu lệnh SQL thêm tài khoản: " . print_r(sqlsrv_errors(), true));
        }
        
        if (!sqlsrv_execute($stmt_insert)) {
            throw new Exception("Lỗi thực thi thêm tài khoản: " . print_r(sqlsrv_errors(), true));
        }
        error_log("Account added successfully");

        // Lấy idTK vừa thêm
        $query_id = "SELECT TOP 1 idTK FROM taikhoan WHERE SDT = ? ORDER BY idTK DESC";
        $stmt_id = sqlsrv_query($conn, $query_id, [$sdt]);
        if (!$stmt_id) {
            throw new Exception("Lỗi truy vấn ID tài khoản: " . print_r(sqlsrv_errors(), true));
        }
        
        $row = sqlsrv_fetch_array($stmt_id, SQLSRV_FETCH_ASSOC);
        if (!$row) {
            throw new Exception("Không tìm thấy tài khoản vừa tạo");
        }
        
        $idTK = $row['idTK'];
        $newUsername = "NV" . $idTK;
        error_log("Got new account ID: $idTK, setting username to: $newUsername");

        // Cập nhật username cho tài khoản
        $update_result = sqlsrv_query($conn, "UPDATE taikhoan SET USERNAME = ? WHERE idTK = ?", [$newUsername, $idTK]);
        if (!$update_result) {
            throw new Exception("Lỗi cập nhật username: " . print_r(sqlsrv_errors(), true));
        }
        error_log("Username updated successfully");

        // Xử lý ảnh
        $img_dir = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "CSDLPT" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "employee" . DIRECTORY_SEPARATOR;
        
        if (!file_exists($img_dir)) {
            error_log("Creating image directory: $img_dir");
            if (!mkdir($img_dir, 0777, true)) {
                throw new Exception("Không thể tạo thư mục lưu ảnh: $img_dir");
            }
        }

        $img_ext = pathinfo($_FILES["txtImg"]["name"], PATHINFO_EXTENSION);
        $new_img_name = "NV" . $idTK . '.' . $img_ext;
        $img_path = $img_dir . $new_img_name;
        error_log("Attempting to save image to: $img_path");

        if (!move_uploaded_file($img_temp, $img_path)) {
            throw new Exception("Lỗi khi upload ảnh: " . $_FILES["txtImg"]["error"] . " - Path: $img_path");
        }
        error_log("Image uploaded successfully");

        // Thêm vào bảng nhân viên
        $insert_nv = "INSERT INTO nhanvien (idTK, GIOITINH, NGAYSINH, DIACHI, IMG, NGAYVAOLAM, TINHTRANG, idCN, idCV)
                    VALUES (?, ?, ?, ?, ?, ?, 'Dang lam', ?, ?)";
        $params_nv = [$idTK, $gioitinh, $ngaysinh, $diachi, $new_img_name, $ngaylam, $idCN, $idCV];
        error_log("params_nv: " . print_r($params_nv, true));
        $stmt_nv = sqlsrv_prepare($conn, $insert_nv, $params_nv);
        if (!$stmt_nv) {
            throw new Exception("Lỗi chuẩn bị câu lệnh SQL thêm nhân viên: " . print_r(sqlsrv_errors(), true));
        }
        
        if (!sqlsrv_execute($stmt_nv)) {
            throw new Exception("Lỗi thực thi thêm nhân viên: " . print_r(sqlsrv_errors(), true));
        }
        error_log("Employee added successfully");

        // Thông báo thành công với nhiều cách
        echo "<div class='alert alert-success'>Thêm nhân viên thành công!</div>";
        echo "<script>alert('Thêm nhân viên thành công!'); window.location.href='index.php?page=employee';</script>";
        
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        error_log("Error adding employee: " . $error_message);
        
        // Hiển thị thông báo lỗi trên trang web
        echo "<div class='alert alert-danger'>Lỗi khi thêm nhân viên: " . htmlspecialchars($error_message) . "</div>";
        
        // Hiển thị alert JavaScript
        echo "<script>alert('Lỗi khi thêm nhân viên: " . addslashes($error_message) . "');</script>";
    }
}

// Phần code gửi email (đã comment)
// require 'vendor/autoload.php';  // Autoload PHPMailer nếu sử dụng Composer
// $mail = new PHPMailer(true);
// ...

// Thêm đoạn debug HTML để kiểm tra biến POST và FILES
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['addEmployee'])) {
    echo "<div class='debug-info' style='background:#f8f9fa; padding:10px; margin:10px; border:1px solid #ddd;'>";
    echo "<h4>Debug Information</h4>";
    echo "<p>POST data received but 'addEmployee' not found. Check your form submission.</p>";
    echo "<p>POST data: <pre>" . print_r($_POST, true) . "</pre></p>";
    echo "</div>";
}
?>

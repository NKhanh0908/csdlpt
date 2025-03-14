<?php
// Kết nối database
include_once(__DIR__ . "/../../../Model/db_connect.php");

$db = new Database();
$conn = $db->connect();

// Lấy vai trò được chọn từ yêu cầu AJAX
$selected_role = $_POST['role'];

// Lấy danh sách các chức năng từ bảng chucnang
$sql_chucnang = "SELECT * FROM chucnang WHERE TRANGTHAI = 1";
$result_chucnang = $conn->query($sql_chucnang);
if ($result_chucnang === false) {
    die("Lỗi truy vấn SQL: " . $conn->error);
}
$chucnang = [];
if ($result_chucnang->num_rows > 0) {
    while ($row = $result_chucnang->fetch_assoc()) {
        $chucnang[] = $row;
    }
}

// Lấy danh sách các quyền đã được phân từ bảng phanquyen
$sql_phanquyen = "SELECT * FROM phanquyen WHERE idQUYEN = $selected_role";
$result_phanquyen = $conn->query($sql_phanquyen);
if ($result_phanquyen === false) {
    die("Lỗi truy vấn SQL: " . $conn->error);
}
$phanquyen = [];
if ($result_phanquyen->num_rows > 0) {
    while ($row = $result_phanquyen->fetch_assoc()) {
        $phanquyen[] = $row;
    }
}

// Tạo HTML để trả về
$html = '';
foreach ($chucnang as $cn) {
    $html .= '<div class="card mb-3">';
    $html .= '<div class="card-header">' . $cn['TENCN'] . '</div>';
    $html .= '<div class="card-body">';
    $html .= '<div class="form-check">';

    // Kiểm tra xem thao tác nào đã được phân quyền cho role được chọn
    $view_checked = false;
    $them_checked = false;
    $sua_checked = false;
    $xoa_checked = false;

    foreach ($phanquyen as $pq) {
        if ($pq['idCN'] == $cn['idCN']) {
            switch ($pq['THAOTAC']) {
                case 'XEM':
                    $view_checked = true;
                    break;
                case 'THEM':
                    $them_checked = true;
                    break;
                case 'SUA':
                    $sua_checked = true;
                    break;
                case 'XOA':
                    $xoa_checked = true;
                    break;
            }
        }
    }

    $html .= '<input type="checkbox" name="chucnang[]" value="' . $cn['idCN'] . '_XEM" ' . ($view_checked ? 'checked' : '') . '> XEM ';
    $html .= '<input type="checkbox" name="chucnang[]" value="' . $cn['idCN'] . '_THEM" ' . ($them_checked ? 'checked' : '') . '> THÊM ';
    $html .= '<input type="checkbox" name="chucnang[]" value="' . $cn['idCN'] . '_SUA" ' . ($sua_checked ? 'checked' : '') . '> SỬA ';
    $html .= '<input type="checkbox" name="chucnang[]" value="' . $cn['idCN'] . '_XOA" ' . ($xoa_checked ? 'checked' : '') . '> XÓA ';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
}

// Trả về HTML
echo $html;

// Đóng kết nối
$conn->close();
?>
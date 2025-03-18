<?php
include_once ('../Controller/connector.php');

$conn = getConnection('branch2');

if (isset($_GET["chon"])) {
    if ($_GET["chon"] == "Add") {
        $path = $_SERVER["DOCUMENT_ROOT"] . '/admin/View/Provider/AddProviderView.php';
        include($path);
    }
}

if (isset($_POST["Add-NCC"])) {
    if (!empty($_POST["txtTenNcc"]) && !empty($_POST["txtSDT"]) && !empty($_POST["txtDiachi"])) {

        $tenncc = $_POST["txtTenNcc"];
        $sdt = $_POST["txtSDT"];
        $diachi = $_POST["txtDiachi"];

        $id_temp = sqlsrv_query($conn, "SELECT idNCC FROM nhacungcap", array(), array("Scrollable" => SQLSRV_CURSOR_STATIC));
        if ($id_temp === false) {
            die("Lỗi truy vấn idNCC: " . print_r(sqlsrv_errors(), true));
        }
        $num_rows_id = sqlsrv_num_rows($id_temp) + 1;

        $sql_check_provider = "SELECT * FROM nhacungcap WHERE TENNCC = '$tenncc'";
        $check_stmt = sqlsrv_query($conn, $sql_check_provider);
        if ($check_stmt === false) {
            die("Lỗi truy vấn kiểm tra nhà cung cấp: " . print_r(sqlsrv_errors(), true));
        }
        $num_rows = sqlsrv_num_rows($check_stmt);

        if ($num_rows > 0) {
            echo '<script>alert("Nhà cung cấp đã tồn tại")</script>';
        } else {
            $sql_insert_provider = "INSERT INTO nhacungcap (TENNCC, SDT, DIACHI) 
                                     VALUES (?, ?, ?)";
            $params = array($tenncc, $sdt, $diachi);
            $stmt_insert = sqlsrv_query($conn, $sql_insert_provider, $params);
            if ($stmt_insert === false) {
                die("Lỗi insert: " . print_r(sqlsrv_errors(), true));
            }
            echo '<script>alert("Thêm ' . $tenncc . ' thành công")</script>';
            header('Location: /admin/View/index.php?page=provider&chon=list');
        }
    }
    echo "<meta http-equiv='refresh' content='0'>";
}
?>

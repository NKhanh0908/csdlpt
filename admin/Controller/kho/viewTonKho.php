<?php
include_once("../connector.php");

if (!isset($_POST['idKho']) || !isset($_POST['branch'])) {
    die("Không nhận được thông tin kho hoặc chi nhánh!");
}

$idKho = $_POST['idKho'];
$branch = $_POST['branch'];
$conn = getConnection($branch);

if ($conn === false) {
    die("Không thể kết nối đến cơ sở dữ liệu!");
}

$sql = "SELECT vt.TENVT, tk.SOLUONG 
        FROM tonkho tk 
        JOIN vattu vt ON tk.idVT = vt.idVT 
        WHERE tk.idKHO = ?";

$params = array($idKho);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$output = "";
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $output .= '<tr>';
    $output .= '<td>'.$row['TENVT'].'</td>';
    $output .= '<td>'.$row['SOLUONG'].'</td>';
    $output .= '</tr>';
}

if (empty($output)) {
    $output = '<tr><td colspan="2" class="text-center">Không có dữ liệu tồn kho</td></tr>';
}

sqlsrv_close($conn);
echo $output; 
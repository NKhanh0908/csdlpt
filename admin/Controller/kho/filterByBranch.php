<?php
include_once("../connector.php");

if (!isset($_POST['branch'])) {
    die("Không nhận được thông tin chi nhánh!");
}

$branch = $_POST['branch'];
$conn = getConnection($branch);

if ($conn === false) {
    die("Không thể kết nối đến cơ sở dữ liệu!");
}

$sql = "SELECT k.*, cn.ten as TEN_CHI_NHANH 
        FROM kho k 
        JOIN chinhanh cn ON k.idCN = cn.idCN";

$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$output = "";
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $output .= '<tr>';
    $output .= '<td>'.$row['idKho'].'</td>';
    $output .= '<td>'.$row['TENKHO'].'</td>';
    $output .= '<td>'.$row['TEN_CHI_NHANH'].'</td>';
    $output .= '<td>
                <a href="?page=tonkhodetail&idKho='.$row['idKho'].'&branch='.$branch.'" class="btn btn-info btn-sm">
                                    <i class="fas fa-boxes"></i> Xem tồn kho
                                </a>
               </td>';
    $output .= '</tr>';
}

if (empty($output)) {
    $output = '<tr><td colspan="4" class="text-center">Không có dữ liệu kho</td></tr>';
}

sqlsrv_close($conn);
echo $output;
?> 
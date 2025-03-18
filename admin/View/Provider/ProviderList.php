<?php
include('ProviderFilter.php');

echo "<h3>Danh sách nhà cung cấp</h3><br>";
echo '<table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên nhà cung cấp</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>';
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $row_ncc = sqlsrv_query($conn, "SELECT * from nhacungcap
    where idNCC={$row['idNCC']}");
    $result_ncc = sqlsrv_fetch_array($row_ncc, SQLSRV_FETCH_ASSOC);
    echo "<tr>
            <td>{$row['idNCC']}</td>
            <td>{$row['TENNCC']}</td>
            <td>{$row['SDT']}</td>
            <td>{$row['DIACHI']}</td>
    <td class='btn-action'> 
        <button style='visibility:".($result_ncc['TRANGTHAI']==1? 'visible' : 'hidden')."'> 
        <a href='../View/index.php?page=provider&chon=Update&idNCC={$row['idNCC']}'
        class='btn-update'>Cập nhật</a></button><br>";
        if($result_ncc["TRANGTHAI"] < 1){
            echo "<button><a class='btn-restore' href=
            '../View/index.php?page=provider&chon=Restore&idNCC={$row['idNCC']}'>Mở khóa</a></button>";

        }else{
            echo "<button><a class='btn-remove' href=
            '../View/index.php?page=provider&chon=Remove&idNCC={$row['idNCC']}'>Khóa</a></button>";
        }
}
    echo "</td></tr>";
    echo "</tbody></table>";

?>
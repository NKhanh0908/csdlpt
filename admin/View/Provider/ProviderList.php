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
while ($row = mysqli_fetch_array($result)) {
    $row_ncc = mysqli_query($conn, "SELECT * from nhacungcap
    where idNCC={$row['idNCC']}");
    $result_ncc = mysqli_fetch_array($row_ncc);
    echo "<tr>
            <td>{$row['idNCC']}</td>
            <td>{$row['TENNCC']}</td>
            <td>{$row['SDT']}</td>
            <td>{$row['DIACHI']}</td>
    <td class='btn-action'> 
        <button style='visibility:".($result_ncc['TRANGTHAI']==1? 'visible' : 'hidden')."'> 
        <a href='../View/index.php?page=provider&chon=Update&idNCC={$row['idNCC']}'
        class='btn-update'>Cập nhật</a></button><br>";
        //CSS nút khóa và mở khóa dựa trên trạng thái
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

    $list = mysqli_num_rows($result)<=0? 'Không thấy ai cung cấp tee-hee': 'Đã hiển thị toàn bộ nhà cung cấp';
    echo "<div id='last-row'>$list</div>";
?>
<?php

include('ProductFilter.php');


echo "<br><h3>Danh sách sản phẩm</h3>";
echo '<table>
<thead>
    <tr>
        <th style="width: 35%">Tên sản phẩm</th>
        <th>Giá nhập</th>
        <th>Giá bán</th>
        <th>Giảm giá</th>
        <th style="width: 5%">Hãng</th>
        <th>Danh mục</th>
        <th>Hành động</th>
    </tr>
</thead>
<tbody>';

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
$path = "/images/products/" . $row['IMG'];
$row_sp = sqlsrv_query($conn, "SELECT * from sanpham where idSP={$row['idSP']}");
$result_sp = sqlsrv_fetch_array($row_sp, SQLSRV_FETCH_ASSOC);

echo "<tr style='opacity: ".($result_sp['TRANGTHAI']==1? 1 : 0.5)."'>
<td class='name-row'>
<img class='name-img' src='$path'><div>{$row['TENSP']}</div></td>
<td>{$row['GIANHAP']} VND</td>
<td>{$row['GIA']} VND</td>
<td>{$row['DISCOUNT']}%</td>
<td>{$row['TENHANG']}</td>
<td>{$row['LOAISP']}</td>

<td class='btn-action'> 
<button style='visibility:".($result_sp['TRANGTHAI']==1? 'visible' : 'hidden')."'> 
<a href='../View/index.php?page=product&chon=Update&idSP={$row['idSP']}'
class='btn-update'>Cập nhật</a></button><br>";

//CSS nút khóa và mở khóa dựa trên trạng thái
if($result_sp["TRANGTHAI"] < 1){
echo "<button><a class='btn-restore' href=
'../View/index.php?page=product&chon=Restore&idSP={$row['idSP']}'>Mở khóa</a></button>";

}else{
echo "<button><a class='btn-remove' href=
'../View/index.php?page=product&chon=Remove&idSP={$row['idSP']}'>Khóa</a></button>";
}
}
echo "</td></tr>";
echo "</tbody></table>";

$list = sqlsrv_num_rows($result)<=0? 'Không tìm thấy sản phẩm': 'Đã hiển thị toàn bộ sản phẩm';
echo "<div id='last-row'>$list</div>";
?>
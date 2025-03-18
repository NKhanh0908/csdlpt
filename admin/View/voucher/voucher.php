<?php

include  '.\..\Controller\vouncher\GetAllVouncher.php';


$result = getAllVouncher();
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $row['NGAYAPDUNG'] = $row['NGAYAPDUNG']->format('Y-m-d');
    $row['HANSUDUNG'] = $row['HANSUDUNG']->format('Y-m-d');
    $data[] = $row;
}
?>

<h2>Quản lý khuyến mãi</h2>
<link rel="stylesheet" href="/css/admin/voucher.css">
<a href="?page=promotion&action=add" class="btn-add">Thêm khuyến mãi mới</a>

<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Mã KM</th>
            <th>Code</th>
            <th>Giá trị</th>
            <th>Số lượng</th>
            <th>Ngày áp dụng</th>
            <th>Hạn sử dụng</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
        <tr>
            <td><?= $row['MAKHUYENMAI'] ?></td>
            <td><?= $row['CODE'] ?></td>
            <td><?= $row['GIATRI'] ?>%</td>
            <td><?= $row['SOLUONG'] ?></td>
            <td><?= $row['NGAYAPDUNG'] ?></td>
            <td><?= $row['HANSUDUNG'] ?></td>
            <td><?= ($row['TRANGTHAI'] ? 'Đang áp dụng' : 'Ngưng áp dụng') ?></td>
            <td>
                <a href="?page=promotion&action=edit&id=<?= $row['MAKHUYENMAI'] ?>">Sửa</a> |
                <a href="?page=promotion&action=delete&id=<?= $row['MAKHUYENMAI'] ?>" onclick="return confirm('Xóa thật không?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

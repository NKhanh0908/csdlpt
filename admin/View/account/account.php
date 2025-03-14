<?php
include("../Controller/account/account.php");
$accounts = getAllAccounts();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách tài khoản</title>
    <link rel="stylesheet" href="/css/admin/account.css">

</head>
<body>

<h2>Danh sách tài khoản</h2>

<!-- Nút thêm tài khoản -->
<a href="?page=add_account" class="add-btn">Thêm Tài Khoản</a>


<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Họ Tên</th>
            <th>Email</th>
            <th>ID Quyền</th>
            <th>Trạng Thái</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($accounts) > 0): ?>
            <?php foreach ($accounts as $row): ?>
                <tr>
                    <td><?= $row['idTK'] ?></td>
                    <td><?= htmlspecialchars($row['USERNAME']) ?></td>
                    <td><?= htmlspecialchars($row['HOTEN']) ?></td>
                    <td><?= htmlspecialchars($row['EMAIL']) ?></td>
                    <td><?= $row['TENQUYEN'] ?></td>
                    <td class="<?= $row['TRANGTHAI'] ? 'active' : 'inactive' ?>">
                        <?= $row['TRANGTHAI'] ? 'Hoạt động' : 'Ngưng hoạt động' ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="text-align:center;">Không có tài khoản nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>

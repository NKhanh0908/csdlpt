<?php
include("../Controller/account/add_account.php");  // Chỉnh lại đường dẫn đúng
$dsQuyen = getAllRoles();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm tài khoản</title>
    <link rel="stylesheet" href="/css/admin/add_account.css">
</head>
<body>

<h2 style="text-align:center;">Thêm Tài Khoản</h2>

<form method="post">
    <label>Username:</label>
    <input type="text" name="username" required>

    <label>Mật khẩu:</label>
    <input type="password" name="password" required>

    <label>Chọn nhóm quyền:</label>
    <select name="idQUYEN">
        <?php foreach ($dsQuyen as $quyen): ?>
            <?php if ($quyen['idQUYEN'] != 1): ?>
                <option value="<?= $quyen['idQUYEN'] ?>"><?= $quyen['TENQUYEN'] ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>

    <label>Trạng thái:</label>
    <select name="trangthai">
        <option value="1">Hoạt động</option>
        <option value="0">Ngưng hoạt động</option>
    </select>

    <input type="hidden" name="action" value="add_account">
    <input type="submit" value="Thêm Tài Khoản">
</form>

<?php
// Xử lý form ngay sau khi submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add_account') {
    addAccount();
}
?>
</body>
</html>

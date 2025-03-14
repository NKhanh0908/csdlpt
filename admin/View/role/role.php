
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'add_new_role') {
        include_once(__DIR__ . "/../../Controller/role/role_add.php");
    } elseif ($_POST['action'] === 'update_permission') {
        include_once(__DIR__ . "/../../Controller/role/role_edit.php");
    }
}
?>

<?php
include_once(__DIR__ . "/../../Controller/role/role.php");


// Xử lý thêm mới quyền
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add_new_role') {
        $tenquyen = $_POST['tenquyen'];
        $new_permissions = $_POST['new_role_permissions'] ?? [];

        $new_role_id = themQuyenMoi($tenquyen);

        if ($new_role_id) {
            foreach ($new_permissions as $permission) {
                [$idCN, $thaotac] = explode('_', $permission);
                themPhanQuyen($new_role_id, $idCN, $thaotac);
            }

            header("Location: ?page=role&role={$new_role_id}&status=add_success");
            exit();
        } else {
            echo '<div class="alert alert-danger">Quyền đã tồn tại!</div>';
        }
    }

    // Xử lý cập nhật quyền hiện tại
    if ($_POST['action'] === 'update_permission') {
        $selected_role = $_POST['role'];
        $selected_permissions = $_POST['chucnang'] ?? [];

        capNhatPhanQuyen($selected_role, $selected_permissions);

        header("Location: ?page=role&role={$selected_role}&status=success");
        exit();
    }
}

// Thông báo nếu có
if (isset($_GET['status'])) {
    if ($_GET['status'] === 'success') {
        echo '<div class="alert alert-success">Cập nhật quyền thành công!</div>';
    } elseif ($_GET['status'] === 'add_success') {
        echo '<div class="alert alert-success">Thêm quyền mới thành công!</div>';
    }
}

// Lấy danh sách vai trò, chức năng, phân quyền hiện tại
$selected_role = $_REQUEST['role'] ?? ($roles[0]['idQUYEN'] ?? null);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Phân Quyền</title>
    <link rel="stylesheet" href="/css/admin/role.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container">
    <h2 class="mt-4">Quản Lý Phân Quyền</h2>

    <!-- Nút thêm quyền -->
    <button class="btn btn-success mb-3" id="btn-them-quyen">Thêm Quyền Mới</button>

    <!-- Form thêm quyền (ẩn ban đầu) -->
    <div id="form-them-quyen" style="display:none; border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">
        <h4>Thêm Quyền Mới</h4>
        <form method="POST">
            <input type="hidden" name="action" value="add_new_role">
            <div class="form-group">
                <label>Tên Quyền:</label>
                <input type="text" class="form-control" name="tenquyen" required>
            </div>
            <div class="form-group">
                <label>Chọn Chức Năng và Thao Tác:</label>
                <?php foreach ($chucnang as $cn): ?>
                    <div class="card mb-2">
                        <div class="card-header"><?= $cn['TENCN'] ?></div>
                        <div class="card-body">
                            <input type="checkbox" name="new_role_permissions[]" value="<?= $cn['idCN'] ?>_XEM"> XEM
                            <input type="checkbox" name="new_role_permissions[]" value="<?= $cn['idCN'] ?>_THEM"> THÊM
                            <input type="checkbox" name="new_role_permissions[]" value="<?= $cn['idCN'] ?>_SUA"> SỬA
                            <input type="checkbox" name="new_role_permissions[]" value="<?= $cn['idCN'] ?>_XOA"> XÓA
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="submit" class="btn btn-primary">Thêm Quyền</button>
        </form>
    </div>

    <!-- Form phân quyền hiện tại -->
    <form method="POST">
        <input type="hidden" name="action" value="update_permission">
        <div class="form-group">
            <label>Chọn Vai Trò:</label>
            <select class="form-control" name="role" id="role">
                <?php foreach ($roles as $role): ?>
                    <option value="<?= $role['idQUYEN'] ?>" <?= $selected_role == $role['idQUYEN'] ? 'selected' : '' ?>>
                        <?= $role['TENQUYEN'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Chức Năng và Thao Tác:</label>
            <?php foreach ($chucnang as $cn): ?>
                <?php
                $view_checked = $them_checked = $sua_checked = $xoa_checked = false;
                foreach ($phanquyen as $pq) {
                    if ($pq['idQUYEN'] == $selected_role && $pq['idCN'] == $cn['idCN']) {
                        switch ($pq['THAOTAC']) {
                            case 'XEM': $view_checked = true; break;
                            case 'THEM': $them_checked = true; break;
                            case 'SUA': $sua_checked = true; break;
                            case 'XOA': $xoa_checked = true; break;
                        }
                    }
                }
                ?>
                <div class="card mb-3">
                    <div class="card-header"><?= $cn['TENCN'] ?></div>
                    <div class="card-body">
                        <input type="checkbox" name="chucnang[]" value="<?= $cn['idCN'] ?>_XEM" <?= $view_checked ? 'checked' : '' ?>> XEM
                        <input type="checkbox" name="chucnang[]" value="<?= $cn['idCN'] ?>_THEM" <?= $them_checked ? 'checked' : '' ?>> THÊM
                        <input type="checkbox" name="chucnang[]" value="<?= $cn['idCN'] ?>_SUA" <?= $sua_checked ? 'checked' : '' ?>> SỬA
                        <input type="checkbox" name="chucnang[]" value="<?= $cn['idCN'] ?>_XOA" <?= $xoa_checked ? 'checked' : '' ?>> XÓA
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="submit" class="btn btn-primary">Cập Nhật Quyền</button>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#btn-them-quyen').click(function() {
        $('#form-them-quyen').toggle();
    });

    $('#role').change(function() {
        window.location.href = "?page=role&role=" + $(this).val();
    });
});
</script>
</body>
</html>

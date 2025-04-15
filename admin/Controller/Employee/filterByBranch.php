<?php
include("../../Controller/connectDB.php");
$branch = $_GET['branch'] ?? 'all';

$sql = "SELECT nv.*, q.TENQUYEN 
        FROM nhanvien nv
        JOIN taikhoan tk ON nv.idTK = tk.idTK
        JOIN quyen q ON tk.idQuyen = q.idQuyen";

if ($branch !== 'all') {
    $sql .= " WHERE nv.idChiNhanh = " . intval($branch);
}

$conn = getConnection();
$result = mysqli_query($conn, $sql);
$employees = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (count($employees) > 0):
    foreach ($employees as $row):
        $path = "../../images/employee/" . $row['IMG'];
        ?>
        <tr class="<?= $row['TRANGTHAI'] == 0 ? 'locked' : '' ?>">
            <td><?= $row['idTK'] ?></td>
            <td><img class='name-img' src="<?= $path ?>"> <?= htmlspecialchars($row['HOTEN']) ?></td>
            <td><?= htmlspecialchars($row['NGAYSINH']) ?></td>
            <td><?= htmlspecialchars($row['GIOITINH']) == 0 ? "Nữ" : "Nam" ?></td>
            <td><?= htmlspecialchars($row['SDT']) ?></td>
            <td><?= htmlspecialchars($row['EMAIL']) ?></td>
            <td><?= htmlspecialchars($row['DIACHI']) ?></td>
            <td><?= htmlspecialchars($row['NGAYVAOLAM']) ?></td>
            <td><?= htmlspecialchars($row['LUONGCB']) ?></td>
            <td><?= $row['TENQUYEN'] ?></td>
            <td class='btn-action'>
                <?php if ($row['TRANGTHAI'] == 1): ?>
                    <form action='../View/employee/updateEmployee.php' method='POST'>
                        <input type='hidden' name='idTK' value='<?= $row['idTK'] ?>'>
                        <button type='submit' class='btn-update' name="update">Cập nhật</button>
                    </form>
                <?php endif; ?>
                <button type='button' class='btn-toggle-status' data-id='<?= $row['idTK'] ?>'
                        style="background-color: <?= $row['TRANGTHAI'] == 1 ? 'red' : 'green' ?>;">
                    <?= $row['TRANGTHAI'] == 1 ? "Khóa" : "Mở khóa" ?>
                </button>
            </td>
        </tr>
    <?php endforeach;
else:
    echo "<tr><td colspan='11' style='text-align:center;'>Không có nhân viên nào trong chi nhánh này.</td></tr>";
endif;
?>

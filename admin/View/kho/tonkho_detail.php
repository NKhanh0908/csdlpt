<?php
include_once("../Controller/connector.php");

if (!isset($_GET['idKho']) || !isset($_GET['branch'])) {
    die("Không nhận được thông tin kho hoặc chi nhánh!");
}

$idKho = $_GET['idKho'];
$branch = $_GET['branch'];
$conn = getConnection($branch);

if ($conn === false) {
    die("Không thể kết nối đến cơ sở dữ liệu!");
}

// Lấy thông tin kho
$sqlKho = "SELECT k.*, cn.ten as TEN_CHI_NHANH 
           FROM kho k 
           JOIN chinhanh cn ON k.idCN = cn.idCN 
           WHERE k.idKho = ?";

$paramsKho = array($idKho);
$stmtKho = sqlsrv_query($conn, $sqlKho, $paramsKho);

if ($stmtKho === false) {
    die(print_r(sqlsrv_errors(), true));
}

$khoInfo = sqlsrv_fetch_array($stmtKho, SQLSRV_FETCH_ASSOC);

// Lấy danh sách tồn kho
$sqlTonKho = "  SELECT sp.TENSP, tk.SOLUONG, sp.idSP
              FROM tonkho tk 
              JOIN sanpham sp ON tk.idSP = sp.idSP
              WHERE tk.idKHO = ? ";

$paramsTonKho = array($idKho);
$stmtTonKho = sqlsrv_query($conn, $sqlTonKho, $paramsTonKho);

if ($stmtTonKho === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết tồn kho - <?php echo $khoInfo['TENKHO']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .table-container {
            margin-top: 20px;
        }
        .info-card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid mt-4">
        <div class="row mb-4">
            <div class="col">
                <h2>Chi tiết tồn kho</h2>
                <div class="card info-card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $khoInfo['TENKHO']; ?></h5>
                        <p class="card-text">
                            <strong>Chi nhánh:</strong> <?php echo $khoInfo['TEN_CHI_NHANH']; ?><br>
                        </p>
                        <a href="?page=kho" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng tồn</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $hasData = false;
                            while ($row = sqlsrv_fetch_array($stmtTonKho, SQLSRV_FETCH_ASSOC)) {
                                $hasData = true;
                                echo '<tr>';
                                echo '<td>'.$row['idSP'].'</td>';
                                echo '<td>'.$row['TENSP'].'</td>';
                                echo '<td>
                                        <span id="soluong_'.$row['idSP'].'">'.$row['SOLUONG'].'</span>
                                        <input type="number" class="form-control d-none" 
                                               id="edit_soluong_'.$row['idSP'].'" 
                                               value="'.$row['SOLUONG'].'">
                                      </td>';
                                echo '<td>
                                        <button class="btn btn-warning btn-sm" 
                                                onclick="toggleEdit('.$row['idSP'].')"
                                                id="btn_edit_'.$row['idSP'].'">
                                            <i class="fas fa-edit"></i> Sửa
                                        </button>
                                        <button class="btn btn-success btn-sm d-none" 
                                                onclick="saveEdit('.$idKho.', '.$row['idSP'].')"
                                                id="btn_save_'.$row['idSP'].'">
                                            <i class="fas fa-save"></i> Lưu
                                        </button>
                                        <button class="btn btn-secondary btn-sm d-none" 
                                                onclick="cancelEdit('.$row['idSP'].')"
                                                id="btn_cancel_'.$row['idSP'].'">
                                            <i class="fas fa-times"></i> Hủy
                                        </button>
                                      </td>';
                                echo '</tr>';
                            }
                            
                            if (!$hasData) {
                                echo '<tr><td colspan="3" class="text-center">Không có dữ liệu tồn kho</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function toggleEdit(idSP) {
        $(`#soluong_${idSP}`).toggleClass('d-none');
        $(`#edit_soluong_${idSP}`).toggleClass('d-none');
        $(`#btn_edit_${idSP}`).toggleClass('d-none');
        $(`#btn_save_${idSP}`).toggleClass('d-none');
        $(`#btn_cancel_${idSP}`).toggleClass('d-none');
    }

    function saveEdit(idKho, idSP) {
        const newSoLuong = $(`#edit_soluong_${idSP}`).val();
        
        $.ajax({
            url: '../../Controller/kho/kho.php?action=updateTonKho',
            type: 'POST',
            data: {
                idKho: idKho,
                idSP: idSP,
                soLuong: newSoLuong,
                branch: '<?php echo $branch; ?>'
            },
            success: function(response) {
                const result = JSON.parse(response);
                if(result.success) {
                    $(`#soluong_${idSP}`).text(newSoLuong);
                    toggleEdit(idSP);
                } else {
                    alert('Có lỗi xảy ra khi cập nhật số lượng!');
                }
            },
            error: function() {
                alert('Có lỗi xảy ra khi cập nhật số lượng!');
            }
        });
    }

    function cancelEdit(idSP) {
        const originalValue = $(`#soluong_${idSP}`).text();
        $(`#edit_soluong_${idSP}`).val(originalValue);
        toggleEdit(idSP);
    }
    </script>
</body>
</html>

<?php
sqlsrv_close($conn);
?> 
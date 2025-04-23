<?php
include_once("../Controller/connector.php");
$conn = getConnection('branch2'); // Mặc định branch2
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý kho</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .table-container {
            margin-top: 20px;
        }
        .branch-select {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid mt-4">
        <h2 class="mb-4">Quản lý kho</h2>

        <!-- Form chọn chi nhánh -->
        <div class="branch-select">
            <div class="row">
                <div class="col-auto">
                    <label class="form-label">Chọn chi nhánh:</label>
                </div>
                <div class="col-auto">
                    <select class="form-select" id="branchSelect">
                        <option value="branch2">Chi nhánh 1</option>
                        <option value="branch3">Chi nhánh 2</option>
                        <option value="branch4">Chi nhánh 3</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Danh sách kho -->
        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Kho</th>
                        <th>Tên kho</th>
                        <th>Chi nhánh</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody id="khoTableBody">
                    <?php
                    $sql = "SELECT k.*, cn.ten as TEN_CHI_NHANH 
                            FROM kho k 
                            JOIN chinhanh cn ON k.idCN = cn.idCN";
                    
                    $stmt = sqlsrv_query($conn, $sql);
                    
                    if($stmt === false) {
                        die(print_r(sqlsrv_errors(), true));
                    }

                    while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        echo '<tr>';
                        echo '<td>'.$row['idKho'].'</td>';
                        echo '<td>'.$row['TENKHO'].'</td>';
                        echo '<td>'.$row['TEN_CHI_NHANH'].'</td>';
                        echo '<td>
                                <a href="?page=tonkhodetail&idKho='.$row['idKho'].'&branch=branch2" class="btn btn-info btn-sm">
                                    <i class="fas fa-boxes"></i> Xem tồn kho
                                </a>
                              </td>';
                        echo '</tr>';
                    }
                    sqlsrv_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    document.getElementById('branchSelect').addEventListener('change', function() {
        const selectedBranch = this.value;
        fetch('../Controller/kho/filterByBranch.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'branch=' + selectedBranch
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('khoTableBody').innerHTML = data;
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi tải dữ liệu kho!');
        });
    });
    </script>
</body>
</html> 
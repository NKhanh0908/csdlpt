<?php      
    // Kết nối cơ sở dữ liệu
    $conn = mysqli_connect("localhost", "root", "", "chdidong", 3306);
    if (!$conn) {
        die("Kết nối thất bại: " . mysqli_connect_error());
    }
    
    // Lấy danh sách ngày nghỉ
    $listNgayNghi = mysqli_query($conn, "SELECT * FROM ngayle");
    
    // Lưu danh sách quyền vào mảng để sử dụng nhiều lần
    $takeLeave = [];
    while ($row = mysqli_fetch_assoc($listNgayNghi)) {
        $takeLeave[] = $row;
    }

?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 90%;
            margin: auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 10px;
            border-bottom: 2px solid orange;
        }
        .header h2 {
            color: orange;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background: orange;
            color: white;
        }
        .status {
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
        }
        .approved { background: green; }
        .pending { background: orange; }
        .buttons {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            color: white;
        }
        .btn-add { background: green; }
        .btn-filter { background: blue; }
        .btn-search { background: gray; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Tất cả nghỉ lễ</h2>
            <div class="buttons">
                <!-- <button class="btn btn-add">+ Xin nghỉ phép</button> -->
                <a href="../employee/assignLeave.php" class="btn btn-filter">Thêm</a>
            </div>
        </div>
        <div class="filter">
            <input type="month" id="filter-month">
            <input type="text" id="search" placeholder="Tìm kiếm...">
            <button class="btn btn-search" onclick="filterTable()">Tìm kiếm</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>idNgayLe</th>
                    <th>Ngày</th>
                    <th>Tên ngày lễ</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="leave-list">
                    <?php foreach ($takeLeave as $row):?>
                        <tr>
                            <td><?= $row['idNGAYLE'] ?></td>
                            <td>
                                <?= htmlspecialchars($row['NGAY']) ?>
                            </td>
                            <td><?= htmlspecialchars($row['TENNGAYLE']) ?></td>
                            <td>
                                <i class="fa fa-eye" style="cursor:pointer;" onclick="openEditForm(<?= $row['idNGAYLE'] ?>, '<?= $row['NGAY'] ?>', '<?= htmlspecialchars($row['TENNGAYLE'], ENT_QUOTES) ?>')"></i>
                            </td>

                        </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Form sửa ngày lễ -->
    <div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
        <div style="background:white; padding:20px; border-radius:10px; min-width:300px; position:relative;">
            <h3>Sửa ngày lễ</h3>
            <input type="hidden" id="edit-id">
            <label for="edit-ngay">Ngày:</label>
            <input type="date" id="edit-ngay" style="width: 100%; margin-bottom: 10px;"><br>
            <label for="edit-ten">Tên ngày lễ:</label>
            <input type="text" id="edit-ten" style="width: 100%; margin-bottom: 15px;"><br>
            <button onclick="saveEdit()" style="padding: 5px 10px; background: green; color: white; border: none; border-radius: 5px;">Lưu</button>
            <button onclick="closeModal()" style="padding: 5px 10px; background: gray; color: white; border: none; border-radius: 5px; margin-left: 10px;">Hủy</button>
        </div>
    </div>


    <script>
        function filterTable() {
            let searchValue = document.getElementById('search').value.toLowerCase();
            let filterMonth = document.getElementById('filter-month').value; // dạng yyyy-mm
            let rows = document.querySelectorAll('#leave-list tr');

            rows.forEach(row => {
                let ngayText = row.children[1]?.textContent.trim(); // cột ngày
                let tenNgayLe = row.children[2]?.textContent.toLowerCase();

                // Format lại thành yyyy-mm để so sánh
                let rowDate = new Date(ngayText);
                let rowMonthStr = rowDate.toISOString().slice(0, 7); // yyyy-mm

                let matchSearch = tenNgayLe.includes(searchValue);
                let matchMonth = !filterMonth || rowMonthStr === filterMonth;

                row.style.display = (matchSearch && matchMonth) ? '' : 'none';
            });
        }


        function openEditForm(id, ngay, tenNgayLe) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-ngay').value = ngay;
            document.getElementById('edit-ten').value = tenNgayLe;
            document.getElementById('editModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        function saveEdit() {
            const id = document.getElementById('edit-id').value;
            const ngay = document.getElementById('edit-ngay').value;
            const ten = document.getElementById('edit-ten').value;

            if (!ngay || !ten) {
                alert("Vui lòng nhập đầy đủ thông tin!");
                return;
            }

            // Gửi dữ liệu đi (AJAX)
            fetch('../../Controller/employee/UpdateLeave.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: id,
                    ngay: ngay,
                    ten: ten
                })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    location.reload();
                }
            })
            .catch(err => console.error(err));
        }
    </script>

</body>
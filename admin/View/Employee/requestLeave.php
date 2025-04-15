<?php      
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Kết nối cơ sở dữ liệu
    $conn = mysqli_connect("localhost", "root", "", "chdidong", 3306);
    if (!$conn) {
        die("Kết nối thất bại: " . mysqli_connect_error());
    }

    $listNgayNghi = mysqli_query($conn, 
        "SELECT t.HOTEN, t.idTK, n.TRANGTHAI, n.LYDO, n.NGAYNGHI, n.NGAYGUI, nv.IMG
                FROM ngaynghi n
                LEFT JOIN taikhoan t ON n.idNV = t.idTK
                LEFT JOIN nhanvien nv ON nv.idTK = t.idTK");

    // Lưu danh sách quyền vào mảng để sử dụng nhiều lần
    $requestLeave = [];
    while ($row = mysqli_fetch_assoc($listNgayNghi)) {
        $requestLeave[] = $row;
    }

?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../../../css/admin/Manager.css">
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
        .popup-form {
            position: fixed;
            top: 20%;
            left: 35%;
            width: 30%;
            background: white;
            border: 2px solid orange;
            padding: 20px;
            z-index: 9999;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.3);
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Tất cả nghỉ phép</h2>
            <div class="buttons">
                <!-- <button class="btn btn-add">+ Xin nghỉ phép</button> -->
            </div>
        </div>
        <button class="btn btn-add" onclick="openLeaveForm()">+ Xin nghỉ phép</button>
        <div class="filter">
            <input type="month" id="filter-month">
            <input type="text" id="search" placeholder="Tìm kiếm...">
            <button class="btn btn-search" onclick="filterTable()">Tìm kiếm</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>idTK</th>
                    <th>Họ tên</th>
                    <th>Ngày gửi</th>
                    <th>Ngày nghỉ</th>
                    <th>Lí do</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="leave-list">
                    <?php foreach ($requestLeave as $row):?>
                        <tr>
                            <td><?= $row['idTK'] ?></td>
                            <td><?= $row['HOTEN'] ?></td>
                            <td>
                                <?= htmlspecialchars($row['NGAYGUI']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($row['NGAYNGHI']) ?>
                            </td>
                            <td><?= htmlspecialchars($row['LYDO']) ?></td>
                            <td><?= htmlspecialchars($row['TRANGTHAI']) ?></td>
                            <td class='btn-action'>
                                <input type="hidden" id="idTKInput" name="idTK" value="">
                                <?php if ($row['TRANGTHAI'] == "Chưa duyệt"): ?>
                                    <button type="button" class="btn-update" name="updateRequestLeave"
                                        onclick="openFormUpdate(this)"
                                        data-idtk="<?= $row['idTK'] ?>"
                                        data-img="<?= $row['IMG'] ?>"
                                        data-nn="<?= $row['NGAYNGHI'] ?>">Cập nhật</button>
                                <?php endif; ?>

                                <div class="detail" id="detail">
                                    <h2>Thông tin phép</h2>
                                    <input type="hidden" name="idTK" id="popup-idTK" value=""> <!-- Thêm dòng này -->
                                    <input type="hidden" name='idnv' value=''>
                                    <div><img id="imgnv" src="" alt=""></div>
                                    <p name='tennv'>Tên nhân viên: </p>
                                    <p name='ngaynghi'>Ngày xin nghỉ: </p>
                                    <p name='lydo'>Lý do: </p>
                                    <button name="duyet" onclick="DuyetPhep('duyet')">Duyệt</button>
                                    <button name='tuchoi' onclick="DuyetPhep('tuchoi')">Từ chối</button>
                                    <button name='huy' onclick="closePopup('detail', 'detail-popup')">X</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="leave-form" class="popup-form" style="display: none;">
        <h2>Xin nghỉ phép</h2>
        <form method="POST" action="" onsubmit="return validateLeaveForm();">
                   
            <!-- Ngày nghỉ -->
            <label for="ngaynghi">Ngày nghỉ:</label>
            <input type="date" name="ngaynghi" id="ngaynghi" required>

            <!-- Lý do -->
            <label for="lydo">Lý do:</label>
            <input type="text" name="lydo" id="lydo" required>

            <!-- Nhân viên: Lấy danh sách nhân viên từ cơ sở dữ liệu -->
            <label for="nhanvien">Nhân viên:</label>
            <select name="idNV" id="nhanvien">
                <?php
                // Kết nối cơ sở dữ liệu và lấy danh sách nhân viên
                $conn = mysqli_connect("localhost", "root", "", "chdidong", 3306);
                if (!$conn) {
                    die("Kết nối thất bại: " . mysqli_connect_error());
                }

                // Lấy danh sách nhân viên từ cơ sở dữ liệu
                $result = mysqli_query($conn, "SELECT idTK, HOTEN FROM taikhoan");
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['idTK'] . "'>" . $row['idTK'] . "_" . $row['HOTEN'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Không có nhân viên</option>";
                }
                mysqli_close($conn);
                ?>
            </select>

            <button type="submit" >Chấp nhận</button>
            <button type="button" onclick="closeLeaveForm()">Hủy</button>
        </form>
    </div>

    </body>


    <script>
        document.getElementById("leaveForm").addEventListener("submit", function(event) {
            // Gọi hàm kiểm tra khi người dùng gửi form
            if (!validateLeaveForm()) {
                // Nếu validate trả về false, ngừng gửi form
                event.preventDefault();
            } else {
                DuyetNghiPhep();
            }
        });
        function openLeaveForm() {
            document.getElementById("leave-form").style.display = "block";
        }

        function closeLeaveForm() {
            document.getElementById("leave-form").style.display = "none";
        }

        function validateLeaveForm() {
            // Lấy thông tin ngày nghỉ, lý do và ID nhân viên
            const ngaynghi = document.getElementById('ngaynghi').value;
            const lydo = document.getElementById('lydo').value;
            const idNV = document.getElementById('nhanvien').value;

            // Kiểm tra các trường có được điền đầy đủ không
            if (!ngaynghi || !lydo || !idNV) {
                alert("Vui lòng điền đầy đủ thông tin.");
                event.preventDefault();
                return false;
            }

            // Kiểm tra xem ngày nghỉ có lớn hơn ngày hôm nay không
            const today = new Date();  // Lấy ngày hiện tại
            const leaveDate = new Date(ngaynghi);  // Chuyển ngày nghỉ thành đối tượng Date

            // So sánh ngày nghỉ với ngày hiện tại
            if (leaveDate <= today) {
                alert("Ngày nghỉ phải lớn hơn ngày hôm nay.");
                event.preventDefault();
                return false;
            }

            return true;  // Nếu tất cả các điều kiện đúng, cho phép gửi form
        }



        function DuyetNghiPhep() {
            // Lấy giá trị từ các trường trong form
            const ngaynghi = document.getElementById('ngaynghi').value;
            const lydo = document.getElementById('lydo').value;
            const idNV = document.getElementById('nhanvien').value;

            // Tiến hành gửi yêu cầu lên server thông qua AJAX (fetch)
            fetch('../../Controller/Manager/SubmitLeaveRequest.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `ngaynghi=${ngaynghi}&lydo=${lydo}&idNV=${idNV}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Yêu cầu nghỉ phép đã được gửi thành công!');
                    closeLeaveForm(); // Đóng form sau khi gửi thành công
                    window.location.reload();  // Tải lại trang
                } else {
                    alert('Có lỗi xảy ra: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Có lỗi xảy ra:', error);
                alert('Không thể gửi yêu cầu nghỉ phép.');
            });
        }


        function filterTable() {
            let searchValue = document.getElementById('search').value.toLowerCase();
            let selectedMonth = document.getElementById('filter-month').value; // yyyy-mm
            let rows = document.querySelectorAll('#leave-list tr');

            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                let matchSearch = text.includes(searchValue);

                // Lấy ngày nghỉ từ cột thứ 4 (index 3)
                let ngayNghiText = row.cells[3]?.innerText.trim(); // ex: "2025-04-07"
                let matchMonth = true;

                if (selectedMonth) {
                    let rowMonth = ngayNghiText.substring(0, 7); // "yyyy-mm"
                    matchMonth = rowMonth === selectedMonth;
                }

                row.style.display = matchSearch && matchMonth ? '' : 'none';
            });
        }

        closePopup= (id, classpop) =>{
        var container = document.getElementById(id);
        container.classList.remove(classpop)
        }

        DuyetPhep = async(option)=>{
        const url = "../../Controller/Manager/HandleNghiPhep.php"
        const idnv = document.querySelector("input[name=idnv]").value
        const ngaynghi_str = document.querySelector('p[name=ngaynghi]').innerHTML
        const ngaynghi = ngaynghi_str.slice(15, ngaynghi_str.length)

        const getMess = async() =>{
            try{
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                    'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        option: option,
                        idNV: idnv,
                        ngaynghi: ngaynghi
                    })
                })

                const message = response.json()
                return message

            }catch(err){
                console.error(err)
            }}

            const reply = await getMess()
            alert(reply.message)
            closePopup('detail', 'detail-popup')
            window.location.href = window.location.href;
        }

	    function openFormUpdate(button) {
            const idTK = button.getAttribute('data-idtk');
            const imgFileName = button.getAttribute('data-img'); 

            document.getElementById('popup-idTK').value = idTK;

            // Find the parent row of the button
            const row = button.closest('tr');
            const cells = row.querySelectorAll('td');

            // Populate detail form with the information
            document.getElementById('popup-idTK').value = idTK;
            document.querySelector("input[name='idnv']").value = cells[0].innerText; 
            document.querySelector("p[name='tennv']").innerText = "Tên nhân viên: " + cells[1].innerText; 
            document.querySelector("p[name='ngaynghi']").innerText = "Ngày xin nghỉ: " + cells[3].innerText; 
            document.querySelector("p[name='lydo']").innerText = "Lý do: " + cells[4].innerText; 

            document.getElementById('imgnv').src = "../../../images/employee/" + imgFileName;
            console.log("Image file name:", imgFileName);

            // Show the detail popup
            const formDetail = document.getElementById('detail');
            formDetail.classList.add("detail-popup");
        }
    </script>

<!-- <script src="../../../js/admin/Manager.js"></script> -->

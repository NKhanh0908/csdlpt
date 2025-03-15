<?php 
// include_once '../../Controller/connectDB.php';
// $conn = getConnection(); 
?>

<h3>Danh sách đơn hàng</h3>

<!-- Bộ lọc trạng thái -->
<label for="filterStatus">Lọc theo trạng thái:</label>
<select id="filterStatus">
    <option value="all">Tất cả</option>
    <?php
  include_once './../Controller/connector.php';
  $connector = getConnection('branch2');
    $sql_status = "SELECT * FROM trangthaidonhang";
    $result_status = sqlsrv_query($connector, $sql_status);
    while ($row_status = sqlsrv_fetch_array($result_status, SQLSRV_FETCH_ASSOC)) {
        echo "<option value='{$row_status['idSTATUS']}'>{$row_status['STATUS']}</option>";
    }
    ?>
</select>

<label for="filterBranch">Lọc theo chi nhánh:</label>
<select id="filterBranch">
    <option value="branch1">Tất cả</option>
    <option value="branch2">Chi nhánh 1</option>
    <option value="branch3">Chi nhánh 2</option>
    <option value="branch4">Chi nhánh 3</option>
</select>


<!-- Khu vực hiển thị đơn hàng -->
<div id="orderList"></div>

<script>
    function loadOrders() {
        let statusValue = document.getElementById("filterStatus").value;
        let branchValue = document.getElementById("filterBranch").value;

    console.log("Trạng thái đơn hàng:", statusValue);
    console.log("Chi nhánh:", branchValue);

    fetch("../Controller/order/order.php?status=" + statusValue + "&branch=" + branchValue)
        .then(response => response.json())
        .then(orders => {
            let html = `<table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>`;

            orders.forEach(order => {
                html += `<tr>
                    <td>${order.idHD}</td>
                    <td>${order.khachhang}</td>
                    <td>${order.NGAYMUA}</td>
                    <td>${order.THANHTIEN} VND</td>
                    <td>${order.STATUS}</td>
                    <td>
                        <a href='?page=orderdetail&idHD=${order.idHD}&idCN=${order.idCN}' class='btn-detail'>Chi tiết</a>
                        ${order.STATUS === "Hủy" ? `<a href="javascript:deleteOrder(${order.idHD})" class="btn-delete">Xóa</a>` : ''}
                    </td>
                </tr>`;
            });

            html += `</tbody></table>`;
            document.getElementById("orderList").innerHTML = html;
        })
        .catch(error => console.error("Lỗi tải đơn hàng:", error));
}

    document.getElementById("filterStatus").addEventListener("change", function () {
        loadOrders();
    });

    document.getElementById("filterBranch").addEventListener("change", function () {
        loadOrders();
    });

    window.onload = function() {
        loadOrders();
    };


    function deleteOrder(idHD) {
    if (confirm('Bạn có chắc chắn muốn xóa đơn hàng này không?')) {
        fetch(`../Controller/order/order_delete.php?idHD=${idHD}`)
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    alert(result.message);
                    loadOrders();  // Reload lại danh sách ngay sau khi xóa
                } else {
                    alert(result.message);
                }
            })
            .catch(error => alert('Lỗi khi xóa: ' + error));
    }
}
</script>

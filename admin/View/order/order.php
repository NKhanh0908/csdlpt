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
  

    $sql_status = "SELECT * FROM trangthaidonhang";
    $result_status = $connect->query($sql_status);
    while ($row_status = $result_status->fetch_assoc()) {
        echo "<option value='{$row_status['idSTATUS']}'>{$row_status['STATUS']}</option>";
    }
    $connect->close();
    ?>
</select>

<!-- Khu vực hiển thị đơn hàng -->
<div id="orderList"></div>

<script>
    function loadOrders(status = "all") {
    fetch("../Controller/order/order.php?status=" + status)
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
                        <a href='?page=orderdetail&idHD=${order.idHD}' class='btn-detail'>Chi tiết</a>
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
        loadOrders(this.value);
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

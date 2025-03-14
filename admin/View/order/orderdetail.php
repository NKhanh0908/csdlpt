
<?php
include("../Controller/order/orderdetail.php");

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>
    <link rel="stylesheet" href="/css/admin/orderdetail.css">
</head>
<body>
    <div class="container">
        <h2>Chi tiết đơn hàng #<?php echo htmlspecialchars($order["idHD"]); ?></h2>
        
        <div class="order-info">
            <p><strong>Khách hàng:</strong> <?php echo htmlspecialchars($order["khachhang"]); ?></p>
            <p><strong>Ngày đặt:</strong> <?php echo htmlspecialchars($order["NGAYMUA"]); ?></p>
            <p><strong>Địa chỉ giao hàng:</strong> <?php echo htmlspecialchars($order["DIACHI"]); ?></p>
            <p><strong>Tổng tiền:</strong> <?php echo number_format($order["THANHTIEN"], 0, ',', '.'); ?> VND</p>
        </div>

        <h3>Sản phẩm trong đơn hàng</h3>
        <table>
            <thead>
                <tr>
                    <th>Anh</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $products->fetch_assoc()) { ?>
                    <tr>
                    <td>
                                <img src="../../images/products/<?php echo htmlspecialchars($row["IMG"]); ?>" alt="" width="100">
                            </td>
                        <td><?php echo htmlspecialchars($row["TENSP"]); ?></td>
                        <td><?php echo htmlspecialchars($row["SOLUONG"]); ?></td>
                        <td><?php echo number_format($row["GIA"], 0, ',', '.'); ?> VND</td>
                        <td><?php echo number_format($order["THANHTIEN"], 0, ',', '.'); ?> VND</td>
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Cập nhật trạng thái đơn hàng -->
        <div class="status-update">
            <h3>Cập nhật trạng thái đơn hàng</h3>
             <form method="POST">
                         <input type="hidden" name="idHD" value="<?php echo $idHD; ?>">

                        <!-- Chờ xác nhận -->
                        <label style="display: <?= ($order['idSTATUS'] > 1) ? 'none' : 'block' ?>">
                            <input type="radio" name="status" value="1" <?php echo ($order["idSTATUS"] == 1) ? "checked" : ""; ?>> Chờ xác nhận
                        </label>

                        <!--    Đang chuẩn bị giao hàng (Chỉ hiển thị nếu đơn chưa đến bước "Đang giao hàng" hoặc cao hơn) -->
                        <label style="display: <?= ($order['idSTATUS'] >= 3) ? 'none' : 'block' ?>">
                            <input type="radio" name="status" value="2" <?php echo ($order["idSTATUS"] == 2) ? "checked" : ""; ?>> Đang chuẩn bị giao hàng
                        </label>

                        <!-- Đang giao hàng (Chỉ hiển thị nếu đơn chưa hoàn tất hoặc hủy) -->
                        <label style="display: <?= ($order['idSTATUS'] >= 4) ? 'none' : 'block' ?>">
                            <input type="radio" name="status" value="3" <?php echo ($order["idSTATUS"] == 3) ? "checked" : ""; ?>> Đang giao hàng
                        </label>

                        <!-- Giao hàng thành công (Chỉ có thể chọn nếu đơn đang giao) -->
                        <label style="display: <?= ($order['idSTATUS'] != 3) ? 'none' : 'block' ?>">
                            <input type="radio" name="status" value="4" <?php echo ($order["idSTATUS"] == 4) ? "checked" : ""; ?>> Giao hàng thành công
                        </label>

                        <!-- Hủy đơn hàng (Chỉ cho phép hủy nếu đơn chưa giao thành công) -->
                        <label style="display: <?= ($order['idSTATUS'] >= 4) ? 'none' : 'block' ?>">
                            <input type="radio" name="status" value="5" <?php echo ($order["idSTATUS"] == 5) ? "checked" : ""; ?>> Hủy đơn hàng
                        </label>

                        <button type="submit" class="update-btn">Cập nhật trạng thái</button>
                    </form>
                

        </div>

        <a href="?page=order" class="btn-back">⬅ Quay lại danh sách</a>
    </div>
</body>
</html>

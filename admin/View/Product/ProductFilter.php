<?php 
include_once './../Controller/connector.php';

$branch = "branch2";
if (isset($_POST["filter-branch"]) && !empty($_POST["filter-branch"])) {
    $branch = $_POST["filter-branch"];
}

$conn = getConnection($branch);

$sql_hang = sqlsrv_query($conn, "SELECT * FROM hang ORDER BY idHANG DESC", array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));
$sql_dm   = sqlsrv_query($conn, "SELECT * FROM danhmuc ORDER BY idDM DESC", array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));

echo '<form method="POST" class="filter">
    <input name="search-filter" placeholder="Nhập từ khóa tìm kiếm"></input>
    <select name="filter-hang" class="filter-form">
        <option value="0">--Lọc theo Hãng--</option>';
while ($row_hang = sqlsrv_fetch_array($sql_hang, SQLSRV_FETCH_ASSOC)) {     
    echo "<option value='{$row_hang['idHANG']}'>{$row_hang['TENHANG']}</option>";
}
echo "</select>";

echo '<select name="filter-danhmuc" class="filter-form">
        <option value="0">--Lọc theo Danh mục--</option>';
while ($row_dm = sqlsrv_fetch_array($sql_dm, SQLSRV_FETCH_ASSOC)) {     
    echo "<option value='{$row_dm['idDM']}'>{$row_dm['LOAISP']}</option>";
}
echo "</select>";

echo '<select name="filter-branch" class="filter-form">
        <option value="branch1"' . ($branch=="branch1"?" selected":"") . '>-- Chi nhánh 1 --</option>
        <option value="branch2"' . ($branch=="branch2"?" selected":"") . '>-- Chi nhánh 2 --</option>
        <option value="branch3"' . ($branch=="branch3"?" selected":"") . '>-- Chi nhánh 3 --</option>
    </select>';

echo "<label for='gianhap-from' class='filter-form'>Từ:</label>
    <input name='gianhap-from' placeholder='Nhập giá nhập' class='filter-form'></input>";

echo "<label for='gianhap-to' class='filter-form'>Đến:</label>
    <input name='gianhap-to' placeholder='Nhập giá nhập' class='filter-form'></input>";

echo "<label for='orderby' class='filter-form'>Sắp xếp theo:</label>
    <select name='orderby' class='filter-form'>
        <option value='0'>Mở Khóa</option>
        <option value='1'>Khóa</option>
    </select>";

echo "<button type='submit' class='filter-form' name='filter'>Tìm kiếm</button></form>";

echo "<button class='btn-add'><a class='filter-form' href='../View/index.php?page=product&chon=Add'>Thêm sản phẩm</a></button>";

$sql = "SELECT * FROM [chdidong].[dbo].[sanpham] s 
        JOIN hang h ON s.HANG = h.idHANG 
        JOIN danhmuc d ON s.idDM = d.idDM";

$hang = 0;
$danhmuc = 0;
$from = 0;
$to = 0;
$sql_queue = "";
$sql_search = "";
$sql_order = " ORDER BY s.TRANGTHAI ASC";

if (isset($_POST['filter'])) {
    if (isset($_POST["filter-hang"], $_POST["filter-danhmuc"], $_POST["filter-branch"],
              $_POST["gianhap-from"], $_POST["gianhap-to"], $_POST["search-filter"], $_POST["orderby"])) {
        
        $hang = $_POST['filter-hang'];
        $danhmuc = $_POST['filter-danhmuc'];
        $from = $_POST["gianhap-from"];
        $to = $_POST["gianhap-to"];
        $text_search = $_POST["search-filter"];
        $orderby = $_POST["orderby"];
    
        if (intval($to) < intval($from)) {
            echo "<script>alert('Giá trước phải nhỏ hơn giá sau');</script>";
        }
    
        // Tạo chuỗi tìm kiếm dựa trên tên sản phẩm
        $sql_search = ($text_search != "" ? (" AND s.TENSP LIKE '%$text_search%'") : "");

        // Xây dựng điều kiện lọc cho hãng và danh mục
        if (($hang + $danhmuc) > 0) {
            $sql_queue = " WHERE";
            if (($hang > 0) && ($danhmuc > 0)) {
                $sql_queue .= (" s.HANG=" . intval($hang) . " AND s.idDM=" . intval($danhmuc)); 
            } else {
                $sql_queue .= ($hang == 0 ? (" s.idDM=" . intval($danhmuc)) : (" s.HANG=" . intval($hang)));
            }
            // Thêm điều kiện giá nhập nếu có
            $sql_queue .= ($to > 0 ? (" AND s.GIANHAP BETWEEN " . intval($from) . " AND " . intval($to)) : "");
        } else {
            $sql_queue .= ($to > 0 ? (" WHERE s.GIANHAP BETWEEN " . intval($from) . " AND " . intval($to)) : "");
        }

        if (intval($hang) + intval($danhmuc) + intval($to) + intval($from) == 0 && $text_search != "") {
            $sql_search = " WHERE s.TENSP LIKE '%$text_search%'";    
        }

        $sql_order = $orderby == 0 ? " ORDER BY s.TRANGTHAI ASC" : " ORDER BY s.TRANGTHAI DESC";
    }
}

$sql .= ($sql_queue . $sql_search . $sql_order);

echo "<script>console.log('" . addslashes($sql) . "')</script>";

$result = sqlsrv_query($conn, $sql);
if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

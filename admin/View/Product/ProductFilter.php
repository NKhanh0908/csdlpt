<?php 
//Lấy ra hãng
$sql_hang = mysqli_query($conn, "SELECT * FROM hang ORDER BY idHANG DESC");
//Lấy ra danh mục
$sql_dm = mysqli_query($conn, "SELECT * FROM danhmuc ORDER BY idDM DESC");
echo '<form method="POST" class="filter">
    <input name="search-filter" placeholder="Nhập từ khóa tìm kiếm"></input>
    <select name="filter-hang" class="filter-form">
        <option value="0">--Lọc theo Hãng--</option>';
        while($row_hang=mysqli_fetch_array($sql_hang)){     
            echo "<option value='{$row_hang['idHANG']}'>
                {$row_hang['TENHANG']}</option>";
        }
    echo "</select>";
    echo '<select name="filter-danhmuc">
            <option value="0">--Lọc theo Danh mục--</option>';
    while($row_dm = mysqli_fetch_array($sql_dm)){     
        echo "<option value='{$row_dm['idDM']}'>
        {$row_dm['LOAISP']}</option>";
    }
    echo "</select>";

    echo "<label for='gianhap-from' class='filter-form'>Từ:</label>
    <input name='gianhap-from' value='' 
    placeholder='Nhập nhá nhập'></input>";

    echo "<label for='gianhap-to' class='filter-form'>Đến:</label>
    <input name='gianhap-to' value='' 
    placeholder='Nhập nhá nhập'></input>";

    echo "<label for='orderby'>Sắp xếp theo:</label>
    <select name='orderby' class='filter-form'>
        <option value='0'>Mở Khóa</option>
        <option value='1'>Khóa</option>
    </select>";

    echo "<button type='submit' class='filter-form' name='filter'>Tìm kiếm</button></form>";
    if ($coQuyenThem) {
        echo "<button class='btn-add'><a class='filter-form' 
        href='../View/index.php?page=product&chon=Add'>
        Thêm sản phẩm</a></button>";
    }
    


$sql = "SELECT * FROM sanpham s JOIN hang h ON s.HANG = h.idHANG
JOIN danhmuc d ON s.idDM = d.idDM";

$hang = 0;
$danhmuc = 0;
$from = 0;
$to = 0;
$sql_queue = "";
$sql_search="";
$sql_order = " ORDER BY s.TRANGTHAI ASC";

if(isset($_POST['filter'])){
    if(isset($_POST["filter-hang"]) 
    &&isset($_POST["filter-danhmuc"])
    &&isset($_POST["gianhap-from"])
    &&isset($_POST["gianhap-to"])
    &&isset($_POST["search-filter"])
    &&isset($_POST["orderby"])
    ){
        $hang = $_POST['filter-hang'];
        $danhmuc = $_POST['filter-danhmuc'];
        $from = $_POST["gianhap-from"];
        $to = $_POST["gianhap-to"];
        $text_search = $_POST["search-filter"];
        $orderby = $_POST["orderby"];
    
        //Check giá nhập
    if( intval($to) < intval($from)){
        echo "<script>alert('Giá trước phải nhỏ hơn giá sau')</script>";
        // exit();
    }
    
    //Ấy chuỗi tìm kiếm
    $sql_search = ($text_search!=""? (" AND s.TENSP LIKE '%$text_search%'") : "");

    //Check điều kiện lọc để nối vào câu truy vấn
    if(($hang + $danhmuc) > 0){ //Có chọn hãng hoặc danh mục hoặc cả 2
        $sql_queue = " WHERE";

        if(($hang > 0) && ($danhmuc > 0)){ //Đều chọn hãng và danh mục
            $sql_queue .= (" s.HANG=" . intval($hang) . " AND s.idDM=" . intval($danhmuc)); 
        }else{
            //Chỉ chọn 1 trong 2
            $sql_queue .= ($hang==0? (" s.idDM=" . intval($danhmuc)) : (" s.HANG=" . intval($hang)));
        }

        //Có nhập giá nhập đến
        $sql_queue .= ($to > 0? (" AND s.GIANHAP BETWEEN " . intval($from) . " AND " . intval($to)) : "");

    }else{
        //Không chọn hãng và danh mục
        $sql_queue .= $to > 0? (" WHERE s.GIANHAP BETWEEN " . intval($from) . " AND " . intval($to)) : "";
    }

    //Check input đặng truy vấn tìm kiếm
    if( intval($hang) + intval($danhmuc) + intval($to) + intval($from) == 0 && $text_search != ""){
        $sql_search = " WHERE s.TENSP LIKE '%$text_search%'";    
    }

    $sql_order = $orderby == 0? " ORDER BY s.TRANGTHAI ASC" : " ORDER BY s.TRANGTHAI DESC";
}
}

$sql .= ($sql_queue . $sql_search . $sql_order);
echo "<script>console.log('$sql')</script>";
//Chạy truy vấn
$result = mysqli_query($conn, $sql);
?>
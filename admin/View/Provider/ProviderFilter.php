
<?php 
echo '<form method="POST" class="filter">
    <input name="search-filter" placeholder="Nhập từ khóa tìm kiếm"></input>';

    echo "<label for='orderby'>Sắp xếp theo:</label>
    <select name='orderby' class='filter-form'>
        <option value='0'>Mở khóa</option>
        <option value='1'>Khóa</option>
    </select>";
    echo "<button type='submit' class='filter-form' name='filter'>Tìm kiếm</button></form>";
    
    echo "<button class='btn-add'><a class='filter-form' 
    href='/admin/View/index.php?page=provider&chon=Add'>
    + Nhà cung cấp</a></button>";

$sql = "SELECT * FROM nhacungcap n ";
$sql_order = " ORDER BY n.idNCC ASC";
$sql_search = '';

if(isset($_POST['filter'])){
    if(isset($_POST["search-filter"])
    &&isset($_POST["orderby"])
    ){

        $text_search = $_POST["search-filter"];
        $orderby = $_POST["orderby"];

    //Check truy vấn tìm kiếm
    if($text_search != ""){
        $sql_search = " WHERE n.TENNCC LIKE '%$text_search%'";    
    }

    $sql_order = $orderby == 0? " ORDER BY n.TRANGTHAI ASC" : " ORDER BY n.TRANGTHAI DESC";
}
}

$sql .= ($sql_search . $sql_order);
echo "<script>console.log('$sql')</script>";
//Chạy truy vấn
$result = sqlsrv_query($conn, $sql);
?>
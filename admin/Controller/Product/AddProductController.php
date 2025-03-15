<?php
include('../../Controller/connectDB.php');
$conn = getConnection();

if(isset($_POST["Add-SP"])){
    if (!empty($_POST["txtTensp"])
    && !empty($_FILES["txtImg"]["name"])
    && !empty($_POST["txtHang"])
    && !empty($_POST["txtDanhmuc"])
    && !empty($_POST["txtGianhap"])
    ){
    $tensp = $_POST["txtTensp"];
    $hang = $_POST["txtHang"];
    $gianhap = $_POST["txtGianhap"];
    $danhmuc = $_POST["txtDanhmuc"];
    $motasp = $_POST["txtMotasp"];
    $img = basename($_FILES["txtImg"]["name"]);
    $img_temp = $_FILES["txtImg"]["tmp_name"];
    $images_dir = $_SERVER["DOCUMENT_ROOT"] . "\images\products";
    

    //Tính id của hiện tại của sản phẩm
    $id_temp = mysqli_query($conn, "SELECT idSP FROM sanpham");
    $num_rows_id = mysqli_num_rows($id_temp) + 1;

    // Kiểm tra xem sản phẩm đã tồn tại trong cơ sở dữ liệu chưa
    $sql_check_product = mysqli_query($conn, "SELECT * FROM sanpham WHERE TENSP = '$tensp'");
    $num_rows = mysqli_num_rows($sql_check_product);

    if ($num_rows > 0) {
        // echo '<script>window.location.href = "AddProductView.php?id=sanpham"</script>';
        echo '<script>alert("Sản phẩm đã tồn tại")</script>';
    } else {
        // Sản phẩm chưa tồn tại, thêm sản phẩm mới
        $sqp_insert_product = mysqli_query($conn, "INSERT INTO sanpham
        (idSP, TENSP, HANG, GIANHAP, idDM, IMG, MOTA, GIA) 
        VALUES('$num_rows_id', '$tensp', '$hang', '$gianhap', '$danhmuc', '$img', '$motasp', '$gianhap')");

        //Thêm ảnh vào folder images
        move_uploaded_file($img_temp, "$images_dir/$img");    
        echo '<script>alert("Thêm sản phẩm ' .$tensp. ' thành công");</script>'; 
    }

    //Reload page
    echo "<meta http-equiv='refresh' content='0'>";
    header('Location: /admin/View/index.php?page=product&chon=list');
}   
}   

if (isset($_GET["chon"])) {
    if($_GET["chon"]=="Add"){
    $path = $_SERVER["DOCUMENT_ROOT"] . '/admin/View/Product/AddProductView.php';
    include("$path");
}
}
mysqli_close($conn);
?>
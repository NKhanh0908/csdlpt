<?php
include('./../Controller/connector.php');

if (isset($_POST["Add-SP"])) {
    if (
        !empty($_POST["txtTensp"])
        && !empty($_FILES["txtImg"]["name"])
        && !empty($_POST["txtHang"])
        && !empty($_POST["txtDanhmuc"])
        && !empty($_POST["txtGianhap"])
        && !empty($_POST["choose-branch"])
    ) {
        $tensp = $_POST["txtTensp"];
        $hang = $_POST["txtHang"];
        $gianhap = $_POST["txtGianhap"];
        $danhmuc = $_POST["txtDanhmuc"];
        $motasp = $_POST["txtMotasp"];
        $img = basename($_FILES["txtImg"]["name"]);
        $img_temp = $_FILES["txtImg"]["tmp_name"];
        $images_dir = $_SERVER["DOCUMENT_ROOT"] . "\images\products";
        $branch = $_POST["choose-branch"];

        $conn = getConnection($branch);


        //Tính id của hiện tại của sản phẩm
        $id_temp = sqlsrv_query($conn, "SELECT idSP FROM sanpham");
        $num_rows_id = sqlsrv_num_rows($id_temp) + 1;

        // Kiểm tra xem sản phẩm đã tồn tại trong cơ sở dữ liệu chưa
        $sql_check_product = sqlsrv_query($conn, "SELECT * FROM sanpham WHERE TENSP = '$tensp'");
        $num_rows = sqlsrv_num_rows($sql_check_product);

        header('Content-Type: application/json');

        if ($num_rows > 0) {
            // echo '<script>window.location.href = "AddProductView.php?id=sanpham"</script>';
            echo json_encode(array(
                'status' => false,
                'message' => 'Sản phẩm đã tồn tại'
            ));
        } else {
            // Sản phẩm chưa tồn tại, thêm sản phẩm mới
            $sqp_insert_product = sqlsrv_query($conn, "INSERT INTO sanpham
        (idSP, TENSP, HANG, GIANHAP, idDM, IMG, MOTA, GIA) 
        VALUES('$num_rows_id', '$tensp', '$hang', '$gianhap', '$danhmuc', '$img', '$motasp', '$gianhap')");

            //Thêm ảnh vào folder images
            move_uploaded_file($img_temp, "$images_dir/$img");
        }
        echo json_encode(array(
            'status' => true,
            'message' => 'Thêm sản phẩm thành công'
        ));
    }
}

if (isset($_GET["chon"])) {
    if ($_GET["chon"] == "Add") {
        $path = $_SERVER["DOCUMENT_ROOT"] . '/admin/View/Product/AddProductView.php';
        include("$path");
    }
}

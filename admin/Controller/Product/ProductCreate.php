<?php
include('../connector.php');
 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tensp = $_POST["txtTensp"];
        $hang = $_POST["txtHang"];
        $gianhap = $_POST["txtGianhap"];
        $danhmuc = $_POST["txtDanhmuc"];
        $motasp = $_POST["txtMotasp"];
        $img = basename($_FILES["txtImg"]["name"]);
        $img_temp = $_FILES["txtImg"]["tmp_name"];
        $images_dir = $_SERVER["DOCUMENT_ROOT"] . "\images\products";
        $branch = $_POST["branch"];

        $connectBranch = getConnection($branch);


        $id_temp = sqlsrv_query($connectBranch, "SELECT idSP FROM [chdidong].[dbo].[sanpham]", [], ["Scrollable" => SQLSRV_CURSOR_STATIC]);

        if ($id_temp === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $num_rows_id = sqlsrv_num_rows($id_temp) + 1;

        // Kiểm tra xem sản phẩm đã tồn tại trong cơ sở dữ liệu chưa
        $sql_check_product = sqlsrv_query($connectBranch, "SELECT * FROM [chdidong].[dbo].[sanpham] WHERE TENSP = '$tensp'");
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
            $sqp_insert_product = sqlsrv_query($connectBranch, "INSERT INTO [chdidong].[dbo].[sanpham]
        (idSP, TENSP, HANG, GIANHAP, idDM, IMG, MOTA, GIA) 
        VALUES($num_rows_id, '$tensp', '$hang', '$gianhap', '$danhmuc', '$img', '$motasp', '$gianhap')");
        


            move_uploaded_file($img_temp, "$images_dir/$img");
        }
        echo json_encode(array(
            'status' => true,
            'message' => 'Thêm sản phẩm thành công',
            "id" => $num_rows_id,
            "sql" => "INSERT INTO [LINKEDSV2].[chdidong].[dbo].[sanpham]
            (idSP, TENSP, HANG, GIANHAP, idDM, IMG, MOTA, GIA) 
            VALUES('$num_rows_id', '$tensp', '$hang', '$gianhap', '$danhmuc', '$img', '$motasp', '$gianhap')"
        ));
    }

?>
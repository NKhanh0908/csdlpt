<?php
    $conn = mysqli_connect("localhost:3306", "root", "", "chdidong");

    if(isset($_GET['chon'])){
        $id = $_GET['idSP'];
        $sql_sanpham = mysqli_query($conn, "SELECT * FROM
        sanpham s JOIN HANG h ON s.HANG=h.idHANG JOIN DANHMUC d
        ON s.idDM = d.idDM WHERE idSP = '$id'");

        $row_sanpham = mysqli_fetch_assoc($sql_sanpham);
        $path = $_SERVER["DOCUMENT_ROOT"] . '/admin/View/Product/UpdateProductView.php';
        include("$path");
    }
       
    if(isset($_POST['ConfirmUpdate'])){

        $id = $_GET['idSP'];
        $tensp = $_POST["Tensp"];
        $hang = $_POST["Hang"];
        $danhmuc = $_POST["Danhmuc"];
        $motasp = $_POST["Motasp"];
        $discount = $_POST["GiamGia"];

        $img = basename($_FILES["Img"]["name"]); //File ảnh mới
        $img_old = $_POST['img-name']; //Tên file ảnh cũ
        $img_temp = $_FILES["Img"]["tmp_name"]; //url file mới

        // //Kiểm tra xem tên sản phẩm đã tồn tại trong cơ sở dữ liệu chưa
        $sql_check_product = mysqli_query($conn, "SELECT * 
        FROM sanpham WHERE TENSP = '$tensp'");
        $num_rows = mysqli_num_rows($sql_check_product);
        // echo $num_rows;

        if($num_rows > 1){
            //Đã tồn tại
            echo '<script>alert("Sản phẩm '.$tensp.' đã tồn tại")</script>';
        }else{

            $images_dir = $_SERVER["DOCUMENT_ROOT"] . "/images/products/";
            
            //Lấy đuôi file mới
            $ext_img = pathinfo($img, PATHINFO_EXTENSION);

            if(strlen($ext_img) > 0){
                //Xóa file ảnh cũ
                unlink($images_dir . $img_old);

                //Lắp file ảnh mới dô
                $url_new = $tensp . '.' . $ext_img;
                //Update hình mới
                $query = "UPDATE sanpham SET IMG='$url_new' WHERE idSP = $id";
                move_uploaded_file($img_temp, "$images_dir/$url_new");
                mysqli_query($conn, $query); 
            }
            
            $query = "UPDATE sanpham SET TENSP= '$tensp',
            HANG='$hang', idDM='$danhmuc', MOTA='$motasp', 
            DISCOUNT='$discount' WHERE idSP = $id";

            echo "<script>console.log('$query')</script>";
            //Update dữ liệu sản phẩm
            mysqli_query($conn, $query); 
            echo '<script>alert("Cập nhật ' .$tensp. ' thành công")</script>';

            //Reload page
            echo "<meta http-equiv='refresh' content='0'>";
            header('Location: ../admin//View/index.php?page=product&chon=list');
        }     
    }
    mysqli_close($conn);
?>


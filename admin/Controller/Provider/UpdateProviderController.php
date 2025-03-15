<?php
    include('../../Controller/connectDB.php');
    $conn = getConnection();

    if(isset($_GET['chon'])){
        if($_GET['chon'] == 'Update'){
            $id = $_GET['idNCC'];
            $sql_ncc = mysqli_query($conn, "SELECT * FROM nhacungcap
            WHERE idNCC = '$id'");
    
            $row_ncc = mysqli_fetch_assoc($sql_ncc);
            $path = $_SERVER["DOCUMENT_ROOT"] . '/admin/View/Provider/UpdateProviderView.php';
            include("$path");
        }
    }
       
    if(isset($_POST['ConfirmUpdate'])){

        $id = $_GET['idNCC'];
        $tenncc = $_POST["txtTenNcc"];
        $sdt = $_POST["txtSDT"];
        $diachi = $_POST["txtDiachi"];

        //Kiểm tra xem tên nhà cung cấp đã tồn tại trong cơ sở dữ liệu chưa
        $sql_check_provider = mysqli_query($conn, "SELECT * 
        FROM nhacungcap WHERE TENNCC = '$tenncc'");
        $num_rows = mysqli_num_rows($sql_check_provider);
        // echo $num_rows;

        if($num_rows > 1){
            //Đã tồn tại
            echo '<script>alert("Nhà cung cấp '.$tenncc.' đã tồn tại")</script>';
        }else{
            
            $query = "UPDATE nhacungcap SET TENNCC= '$tenncc',
            SDT='$sdt', DIACHI='$diachi' WHERE idNCC = $id";

            echo "<script>console.log('$query')</script>";
            //Update dữ liệu nhà cung cấp
            mysqli_query($conn, $query); 

            echo '<script>alert("Cập nhật ' .$tenncc. ' thành công")</script>';
            //Reload page
            echo "<meta http-equiv='refresh' content='0'>";
            header('Location: /admin/View/index.php?page=provider&chon=list');
        }     
    }
    mysqli_close($conn);
?>


<?php

include('../../Controller/connectDB.php');
$conn = getConnection();

if(isset($_GET['chon'])){
    $id = $_GET['idSP'];
    ///Xử lý xóa sản phẩm
    if($_GET['chon'] == 'Remove'){

        $sql_query=mysqli_query($conn, "UPDATE sanpham s SET s.TRANGTHAI = 0 where idSP=$id");
        echo '<script>window.location.href = "/admin/View/index.php?page=product&chon=list"</script>'; 

        echo "$id has been remove";  
    }

    ///Xử lý khôi phục sản phẩm
    if($_GET['chon'] == 'Restore'){

        $sql_query=mysqli_query($conn, "UPDATE sanpham s SET s.TRANGTHAI = 1 where idSP=$id");
        echo '<script>window.location.href = "/admin/View/index.php?page=product&chon=list"</script>'; 

        echo "$id has been unlock";  
    }
}
mysqli_close($conn);
?>

<?php

$conn = getConnection('branch2');

if(isset($_GET['chon'])){

    $id = $_GET['idNCC'];

    ///Xử lý xóa nhà cung cấp
    if($_GET['chon'] == 'Remove'){

        $sql_query=sqlsrv_query($conn, "UPDATE nhacungcap SET TRANGTHAI = 0 where idNCC=$id");
        echo '<script>window.location.href = "/admin/View/index.php?page=provider&chon=list"</script>'; 

        echo "$id has been remove";  
    }

    ///Xử lý khôi phục nhà cung cấp
    if($_GET['chon'] == 'Restore'){

        $sql_query=sqlsrv_query($conn, "UPDATE nhacungcap SET TRANGTHAI = 1 where idNCC=$id");
        echo '<script>window.location.href = "/admin/View/index.php?page=provider&chon=list"</script>'; 

        echo "$id has been unlock";  
    }
}
?>

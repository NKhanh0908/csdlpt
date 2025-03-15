<?php 
    include('../../Controller/connectDB.php');

    $conn = getConnection();

    $user = $_SESSION['user'];
    // echo "<script>console.log('$user')</script>";
    $get_id = mysqli_query($conn, "SELECT idTK from taikhoan WHERE username='$user'");
    $id = mysqli_fetch_array($get_id);

    echo "<script>console.log('{$id["idTK"]}')</script>";
?>
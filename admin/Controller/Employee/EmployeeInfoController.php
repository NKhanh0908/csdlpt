<?php 
include('../../Controller/connectDB.php');

$conn = getConnection();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $id = isset($data['id']) ? $data['id'] : null;

    $sql = 'SELECT * from taikhoan tk 
    JOIN quyen q ON tk.idQUYEN=q.idQUYEN JOIN nhanvien nv 
    ON tk.idTK=nv.idTK WHERE tk.idTK=' . intval($id);

    $employee = mysqli_query($conn, $sql);

    if(mysqli_num_rows($employee) > 0){

        $info = array();
        while($employee_rows = mysqli_fetch_array($employee)){
            $idnv = $employee_rows['idTK'];
            $hoten = $employee_rows['HOTEN'];
            $img = $employee_rows['IMG'];
            $gioitinh = $employee_rows['GIOITINH'];
            $ngaysinh = $employee_rows['NGAYSINH'];
            $email = $employee_rows['EMAIL'];
            $sdt = $employee_rows['SDT'];
            $quyen = $employee_rows['TENQUYEN'];
            $luong = $employee_rows['LUONGCOBAN'];
            $tinhtrang = $employee_rows['TINHTRANG'];

            $info = array(
                'id' => $idnv,
                'hoten' => $hoten,
                'img' => $img,
                'gioitinh' => $gioitinh, 
                'ngaysinh' => $ngaysinh,  
                'email' => $email,  
                'sdt' => $sdt,  
                'quyen' => $quyen,  
                'luong' => $luong,  
                'tinhtrang' => $tinhtrang,   
            ); 
        }

        $json = json_encode($info);
        echo $json;
    }
    // $file = "info.json";
    // if (file_put_contents($file, $json) !== false) {
    //     echo "Data has been written to $file.";
    // } else {
    //     echo "Error occurred while writing to $file.";
    // }
}
?>
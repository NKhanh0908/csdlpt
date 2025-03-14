<?php
$path = $_SERVER["DOCUMENT_ROOT"] . '/admin/Controller/connectDB.php';
include($path);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $tensp = isset($data['tensp'])? $data['tensp'] : '';
    $hang = isset($data['hang'])? intval($data['hang']) : 1;
    $danhmuc = isset($data['danhmuc'])? intval($data['danhmuc']) : 1;
    $mota = isset($data['mota'])? $data['mota'] : "Hiện không có mô tả sản phẩm.";

    $message='';

    //Xử lý file ảnh
    $img_name = isset($data['fileName'])? basename($data['fileName']) : ''; //Lấy ra tên file gốc
    $ext_img = pathinfo($img_name, PATHINFO_EXTENSION);//Lấy đuôi file
    $img_data = isset($data['fileData'])? $data['fileData'] : '';  //Dữ liệu file
    //Ấy nó ra
    $img_content = base64_decode($img_data);

    $new_url = $tensp . "." . $ext_img; //Như cái tên
    $images_dir = $_SERVER["DOCUMENT_ROOT"] . "\images\products" . "/" . $new_url; //url lưu ảnh

    //Tính id của hiện tại của sản phẩm
    $id_temp = mysqli_query($conn, "SELECT idSP FROM sanpham");
    $num_rows_id = mysqli_num_rows($id_temp) + 1;

    // Kiểm tra xem sản phẩm đã tồn tại trong cơ sở dữ liệu chưa
    $sql_check_product = mysqli_query($conn, "SELECT idSP FROM sanpham WHERE TENSP = '$tensp'");
    $num_rows = mysqli_num_rows($sql_check_product);
    
    // $message = $img_name;
    if ($num_rows > 0) {  
        //Thông điệp trả về  
        $message = "Sản phửm đã tồn tại rùi kưng";
    } else {
        // Sản phẩm chưa tồn tại, thêm sản phẩm mới
        if(!mysqli_query($conn, "INSERT INTO sanpham
        (idSP, TENSP, HANG, GIANHAP, idDM, IMG, MOTA, GIA) 
        VALUES('$num_rows_id', '$tensp', '$hang', 0, '$danhmuc', '$new_url', '$mota', 0)")){

            $message = "truy vấn thất bại";
        }else{
            //Thêm ảnh vào folder images
            $message = file_put_contents($images_dir, $img_content)? "Đã thêm $tensp vào danh sách sản phửm" : "Lỗi r";
        }
    }

    $response = [
        'tensp' => $tensp,
        'message' => $message
    ];

    $json = json_encode($response);
    echo $json;
}
?>
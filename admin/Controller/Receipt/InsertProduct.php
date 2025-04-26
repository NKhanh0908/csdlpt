<?php
$conn=mysqli_connect("localhost:3306", "root", "", "chdidong");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $tensp = isset($data['tensp'])? $data['tensp'] : '';
    $hang = isset($data['hang'])? intval($data['hang']) : 1;
    $danhmuc = isset($data['danhmuc'])? intval($data['danhmuc']) : 1;
    $mausac = isset($data['mausac'])? $data['mausac'] : 'KHÔNG CÓ';
    $dungluong = isset($data['dungluong'])? $data['dungluong'] : 'KHÔNG CÓ';
    $mota = isset($data['mota'])? $data['mota'] : "Hiện không có mô tả sản phẩm.";

    $message='';

    //Xử lý file ảnh
    $img_name = isset($data['fileName'])? basename($data['fileName']) : ''; //Lấy ra tên file gốc
    $ext_img = pathinfo($img_name, PATHINFO_EXTENSION);//Lấy đuôi file
    $img_data = isset($data['fileData'])? $data['fileData'] : '';  //Dữ liệu file
    //Ấy nó ra
    $img_content = base64_decode($img_data);

    $temp_nameIMG = "";
    if($mausac != "KHÔNG CÓ")
    $temp_nameIMG .= "_" . $mausac;

    if($dungluong != "KHÔNG CÓ")
    $temp_nameIMG .= "_" . $dungluong;

    $new_url = $tensp . $temp_nameIMG . "." . $ext_img; //Như cái tên
    $images_dir = $_SERVER["DOCUMENT_ROOT"] . "/HTTTDN/images/products/" . $new_url; //url lưu ảnh

    //Tính id của hiện tại của sản phẩm
    $id_temp = mysqli_query($conn, "SELECT idSP FROM sanpham");
    $num_rows_id = mysqli_num_rows($id_temp) + 1;

    $message = '';

    // Tính id của hiện tại của sản phẩm
    $idct_temp = mysqli_query($conn, "SELECT idCTSP FROM chitietsanpham");
    $num_rows_idct = mysqli_num_rows($idct_temp) + 1;

    // Kiểm tra xem tên sản phẩm đã tồn tại trong cơ sở dữ liệu chưa
    //kiểm tra điều kiện màu hoặc dung lượng bị trùng
    $sql_check_nameproduct = mysqli_query($conn, "SELECT s.idSP FROM sanpham s JOIN chitietsanpham ct ON s.idSP = ct.idSP WHERE TENSP = '$tensp'");
    $num_rows_name = mysqli_num_rows($sql_check_nameproduct);

    $listPro = mysqli_fetch_assoc($sql_check_nameproduct);

    
    // Kiểm tra xem màu sản phẩm đã tồn tại trong cơ sở dữ liệu chưa
    $sql_check_mausac = mysqli_query($conn, "SELECT ct.idCTSP FROM sanpham s JOIN chitietsanpham ct ON s.idSP = ct.idSP WHERE s.TENSP = '$tensp' AND ct.MAUSAC = '$mausac' AND ct.DUNGLUONG = '$dungluong'");
    $num_rows_taken = mysqli_num_rows($sql_check_mausac);
    

    // $message = $img_name;
    if ($num_rows_name == 0) {  
        // Sản phẩm chưa tồn tại, thêm sản phẩm mới
        $insert_sp = mysqli_query($conn, "INSERT INTO sanpham
        (idSP, TENSP, HANG, GIANHAP, idDM, IMG, MOTA, GIA) 
        VALUES('$num_rows_id', '$tensp', '$hang', 0, '$danhmuc', '$new_url', '$mota', 0)");

        $insert_ctsp = mysqli_query($conn, "INSERT INTO chitietsanpham
        (idSP, MAUSAC, DUNGLUONG, DIEUCHINHGIA, IMG, TONKHO) 
        VALUES('$num_rows_id', '$mausac', '$dungluong', 0, '$new_url', 0)");

        if(!$insert_sp || !$insert_ctsp){

            $message = "truy vấn thất bại";

        }else{
            $message = file_put_contents($images_dir, $img_content)? "Đã thêm $tensp vào danh sách sản phửm" : "Lỗi r";
        }
    } else {
        //ktra trùng màu sắc, hay dung lượng
        if ($num_rows_taken == 0) {
            if(!mysqli_query($conn, "INSERT INTO chitietsanpham
                (idSP, MAUSAC, DUNGLUONG, DIEUCHINHGIA, IMG, TONKHO) 
                VALUES('{$listPro['idSP']}', '$mausac', '$dungluong', 0, '$new_url', 0)")
                ){

                    $message = "truy vấn thất bại";

                } else {
                    $message = "trùng tên nhưng mà thêm dô chi tiết thành công dồi nha chời:>";
                }
        } else {
            //Thông điệp trả về
            $message = "Sản phửm đã tồn tại rùi kưng";
        }
        
    }


    $response = [
        'tensp' => $tensp,
        'mausac' => $mausac,
        'dungluong' => $dungluong,
        'message' => $message
    ];

    $json = json_encode($response);
    echo $json;
}
?>
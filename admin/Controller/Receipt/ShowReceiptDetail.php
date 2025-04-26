<?php
include('../connector.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $idPN = isset($_GET['idPN'])? $_GET['idPN'] : '';
    $branch = isset($_GET['branch'])? $_GET['branch'] : '';

    $connect = getConnection($branch);

    //Móc ra sản phẩm trong phiếu nhập
    $sql = 'SELECT sp.TENSP, sp.IMG, dm.LOAISP, ct.SOLUONG, sp.GIA, h.TENHANG
    FROM chitietphieunhap ct 
	JOIN phieunhap pn ON ct.idPN = pn.idPN 
	JOIN sanpham sp ON ct.idSP = sp.idSP 
	JOIN danhmuc dm ON sp.idDM = dm.idDM
	JOIN hang h ON sp.HANG = h.idHANG
	WHERE pn.idPN=' . intval($idPN);

    $result = sqlsrv_query($connect, $sql);
    $list_details= array();
    //Chạy truy vấn lưu từng sp vào mảng
    while($details = sqlsrv_fetch_array($result)){
        $tensp = $details['TENSP'];
        $soluong = $details['SOLUONG'];
        $gianhap = $details['GIA'];
        $loaisp = $details['LOAISP'];
        $hang = $details['TENHANG'];
        $img = $details['IMG'];

        $arr = array(
            'tensp' => $tensp,
            'soluong' => $soluong,
            'gianhap' => $gianhap,
            'loaisp' => $loaisp,
            'hang' => $hang,
            'img' => $img
        );

        array_push($list_details, $arr);
    }

    $json = json_encode($list_details);
    echo $json;
}
?>
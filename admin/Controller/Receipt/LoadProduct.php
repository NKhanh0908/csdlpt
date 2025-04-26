<?php
include('../connector.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');   
    $data = json_decode($json, true);

    $idSP = isset($data['idSP'])? $data['idSP'] : '';

    $sql = 'SELECT s.idSP, s.TENSP, s.IMG, s.GIANHAP, dm.LOAISP, h.TENHANG, s.idDM 
	from sanpham s 
		INNER JOIN danhmuc dm ON s.idDM = dm.idDM
		INNER JOIN hang h ON h.idHANG = s.HANG
		
		WHERE s.idSP=' . intval($idSP);

    $connect = getConnection("branch2");
    $result = sqlsrv_query($connect, $sql);
    $list = array();
    while($sp = sqlsrv_fetch_array($result)){
        $idsp = $sp['idSP'];
        $tensp = $sp['TENSP'];
        $img = $sp['IMG'];
        $gianhap = $sp['GIANHAP'];
        $loaisp = $sp['LOAISP'];
        $hang = $sp['TENHANG'];
        $danhmuc = $sp['idDM'];

        $arr = ['id' => $idsp,
            'name' => $tensp,
            'img' => $img,
            'gianhap' => $gianhap,
            'loaisp' => $loaisp,
            'hang' => $hang,
            'danhmuc' => $danhmuc
        ];
        array_push($list, $arr);
    }
    
    $json = json_encode($list);
    echo $json;
}
?>
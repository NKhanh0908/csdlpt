<?php
include('../connector.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');   
    $data = json_decode($json, true);

    $idSP = isset($data['idSP'])? $data['idSP'] : '';
    $connect = getConnection('branch2');

    $sql = 'SELECT * FROM sanpham WHERE idSP =' . intval($idSP);

    $result = sqlsrv_query($connect, $sql);
    while($sp = sqlsrv_fetch_array($result)){
        $idsp = $sp['idSP'];
        $tensp = $sp['TENSP'];
        $img = $sp['IMG'];
        $gianhap = $sp['GIANHAP'];

        $respone = [
            'id' => $idsp,
            'name' => $tensp,
            'img' => $img,
            'gianhap' => $gianhap
        ];
    }
    
    $json = json_encode( $respone);
    echo $json;
}
?>
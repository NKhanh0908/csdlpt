<?php
include_once("../../Controller/kho/khoController.php");

if(!isset($_POST['branch'])) {
    die("Không có thông tin chi nhánh!");
}

$khoController = new KhoController($_POST['branch']);
$khoList = $khoController->getAllKho();

if($khoList): 
    foreach($khoList as $kho): 
?>
    <tr>
        <td><?php echo $kho['idKho']; ?></td>
        <td><?php echo $kho['TENKHO']; ?></td>
        <td><?php echo $kho['TEN_CHI_NHANH']; ?></td>
        <td>
            <button class="btn btn-info btn-sm" onclick="viewTonKho(<?php echo $kho['idKho']; ?>)">
                Xem tồn kho
            </button>
        </td>
    </tr>
<?php 
    endforeach; 
else:
?>
    <tr>
        <td colspan="5" class="text-center">Không có dữ liệu kho</td>
    </tr>
<?php endif; ?> 
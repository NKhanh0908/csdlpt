<link rel="stylesheet" href="/css/admin/Provider.css">

<h1>Quản lý Nhà cung cấp</h1><br>
<?php

include  '.\..\Controller\Provider\GetAllProvider.php';

$result = getAllProvider();
?>

<div class='containers'>
    <?php
        if(isset($_GET['chon'])){
            $select = $_GET['chon'];
            switch ($select) {
                case 'list': include('ProviderList.php'); break;
                case 'Add': include('../Controller/Provider/AddProviderController.php'); break;
                case 'Remove':
                case 'Restore': include('../Controller/Provider/RemoveProviderController.php'); break;
                case 'Update': include('../Controller/Provider/UpdateProviderController.php'); break;
                default: include('ProviderList.php'); break;
            }
        }else{
            include('ProviderList.php');
        }
        
    ?>
</div>
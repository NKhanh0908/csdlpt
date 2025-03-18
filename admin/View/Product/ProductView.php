<link rel="stylesheet" href="/css/admin/Product.css">
 

<h1>Quản lý sản phẩm</h1><br>
<?php 
?>

<div class='containers'>
    <?php
        if(isset($_GET['chon'])){
            $select = $_GET['chon'];
            switch ($select) {
                case 'list': include('ProductList.php'); break;
                case 'Add': include('../Controller/Product/AddProductController.php'); break;
                case 'Remove':
                case 'Restore': include('../Controller/Product/RemoveProductController.php'); break;
                case 'Update': include('../Controller/Product/UpdateProductController.php'); break;
                default: include('ProductList.php'); break;
            }
        }else{
            include('ProductList.php'); 
        }
    ?>
</div>
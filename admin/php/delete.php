<?php 

    if(isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];

        require_once 'dbwebshop.php';
        mysqli_query($dbWebshop, "DELETE FROM product WHERE id=$id");
    }

    header('Location: ../products.php');

?>
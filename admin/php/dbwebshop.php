<?php

    // Webshop adatbázis csatlakozás
    $dbWebshop = mysqli_connect('localhost', 'root', '', 'chocoshop');
    mysqli_query($dbWebshop, "SET NAMES utf8");

?>
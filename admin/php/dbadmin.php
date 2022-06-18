<?php

    // Admin adatbázis csatlakozás
    $dbAdmin = mysqli_connect('localhost', 'root', '', 'chocoshop_admin');
    mysqli_query($dbAdmin, "SET NAMES utf8");

?>
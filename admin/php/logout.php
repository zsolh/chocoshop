<?php

    // Admin kijelentkezés
    session_start();

    unset($_SESSION['adminId']);

    header('Location: ../login.php');

?>
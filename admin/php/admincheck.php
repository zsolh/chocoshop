<?php

    // Be van-e jelentkezve admin felhasználó

    // Munkamenet
    session_start();

    // A bejelentkezéskor felvett adminId létezik-e a munkamenetben
    if(isset($_SESSION['adminId'])) {
        // Be van lépve egy admin, eltároljuk az azonosítóját egy változóba
        $adminId = $_SESSION['adminId'];
    } else {
        // Ha valaki nincs belépve, visszairányítjuk a bejelentkezésre
        header('Location: login.php');
    }

?>
<?php

    session_start();

    $login = false;
    if(isset($_SESSION['userId'])){
        $userId = $_SESSION['userId'];
        $login = true;
        
    }

?>
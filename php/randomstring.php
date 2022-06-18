<?php

function generateRandomString(int $stringLength = 10){
    $characters = "abcdefghijklmnopqrstuvwxyz0123456789";

    $randomString = '';

    for($i=0; $i<$stringLength;$i++){
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}

?>
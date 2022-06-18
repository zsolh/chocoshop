<?php
function generateHashCode(string $password, string $salt){
    return hash('sha512', $password.md5($salt));
}

?>
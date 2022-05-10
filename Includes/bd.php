<?php
    $bd = mysqli_connect('localhost','root','root','veterinaria_capidev');
    if (!$bd) {
        echo 'No se conecto a la base de datos';
    }
    
?>
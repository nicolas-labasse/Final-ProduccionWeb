<?php

if (isset($_GET['userID'])) {

    require_once 'includes/conector.php';
    $conn = new Conector();
    
    $caracteresRndPass = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $newPass = substr(str_shuffle($caracteresRndPass), 0, 8);
    $newPass = password_hash($newPass, PASSWORD_DEFAULT);

    if($conn->ModificarUsuarioPw($_GET['userID'], $newPass));
        header("Location: admin.php?tab=usuarios");
}
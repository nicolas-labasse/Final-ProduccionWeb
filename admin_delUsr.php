<?php

if (isset($_GET['userID'])) {

    require_once 'includes/conector.php';
    $conn = new Conector();

    if($conn->HabilitarUsuario($_GET['userID'], $_GET['method']));
        header("Location: admin.php?tab=usuarios");
}
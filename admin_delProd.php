<?php

if (isset($_GET['prodID'])) {

    require_once 'includes/conector.php';
    $conn = new Conector();

    if($conn->HabilitarProducto($_GET['prodID'], $_GET['method']))
        header("Location: admin.php?tab=productos");
}
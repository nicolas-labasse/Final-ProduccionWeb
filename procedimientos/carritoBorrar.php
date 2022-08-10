<?php

if (!isset($_GET['prodID']))
    header("Location: ../index.php");
else {

    require_once '../includes/conector.php';
    $conn = new Conector();

    $conn->QuitarDelCarrito($_GET['prodID']);
    header('Location: /carrito.php');
}

<?php

session_start();

if (!isset($_GET['prodID']))
    header("Location: ../index.php");
else {

    require_once '../includes/conector.php';
    $conn = new Conector();

    $conn->AgregarAlCarrito($_GET['prodID'], $_SESSION['userID']);
    header('Location: /producto.php?id='.$_GET['prodID']);
}





<?php
    require_once '../includes/conector.php';
    $conn = new Conector();
    $conn->EnviarCarritoAPedidos();
    header('Location: /ventaExitosa.php');




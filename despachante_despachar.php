<?php

require_once 'includes/conector.php';
$conn = new Conector();
$result = $conn->ActualizarFechaDespacho($_GET['pedidoID']);
var_dump($_GET['pedidoID']);
header('Location: /despachante.php');
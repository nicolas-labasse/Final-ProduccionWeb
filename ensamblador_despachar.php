<?php

require_once 'includes/conector.php';
$conn = new Conector();
$result = $conn->ActualizarEnsambladoADespacho($_GET['pedidoID']);
var_dump($_GET['pedidoID']);
header('Location: /despachante.php');
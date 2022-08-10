<?php

if (isset($_SESSION['isLogged']) && !$_SESSION['isLogged'])
    header("Location: index.php");

session_start();
session_unset();
$_SESSION['isLogged'] = false;

header("Location: index.php");
<?php 

if (session_status() != PHP_SESSION_ACTIVE)
  session_start();

  // funcionales de Recordar Usuario
  /*
  if (isset($_COOKIE['cookieUSUARIO'])) {
    $_SESSION['usuario'] = $_COOKIE['cookieUSUARIO'];
    $_SESSION['id'] = $_COOKIE['cookieID'];
    $_SESSION['nombre'] = $_COOKIE['cookieNOMBRE'];
    $_SESSION['apellido'] = $_COOKIE['cookieAPELLIDO'];
    $_SESSION['nivel'] = $_COOKIE['cookieNIVEL'];

    $_SESSION['isLogged'] = true;
  }
  */

  if ( !isset($_SESSION['isLogged'])) {
    $_SESSION['isLogged']=false;
  }
?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- links -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="css/estilo.css">

  <!-- slick -->
  <link rel="stylesheet" type="text/css" href="componentes/slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="componentes/slick/slick-theme.css"/>

  <!-- google fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet"> 

  <!-- scripts -->
  <script src="https://kit.fontawesome.com/f28549af1d.js" crossorigin="anonymous"></script>

  <!-- siteprefs -->
  <title>Retabasse</title>
</head>
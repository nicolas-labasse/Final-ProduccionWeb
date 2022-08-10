<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-pag">

    <div class="container-fluid">


      <a class="navbar-brand d-flex align-items-center" href="index.php">
        <img src="../imagenes/logo.png" alt="" style="height: 30px;">
        <h5 class="m-0 px-2 d-none d-lg-block" style="font-family: 'Share Tech Mono', monospace;" >RETABASSE</h5>
      </a>

      
      <div class="btn-group">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
          class="navbar-toggler-icon"></span></button>

          <?php
        if ($_SESSION['isLogged'] && ($_SESSION['nivel'] == 0 || $_SESSION['nivel'] == 3)){
          require_once 'carrolista.php';
          dibujarCarroLista("d-block d-lg-none");
        }
        ?>
        </div>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item mx-2">
            <div class="btn-group">
              <a href="lista.php" class="btn btn-outline-light noBorder py-2 px-3" type="button">
                Productos
              </a>
              <button type="button" class="btn btn-outline-light noBorder dropdown-toggle dropdown-toggle-split py-2 px-2"
                data-bs-toggle="dropdown" id="dropMenu" aria-expanded="false" data-bs-auto-close="outside">
                <span class="visually-hidden">Toggle Dropdown</span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropMenu">
                <li>
                  <?php require_once 'categoriaslateral.php';
                
                dibujarAcordeon("header");
                
                ?>
                </li>
              </ul>
            </div>
          </li>
        </ul>
        <?php
             if ($_SESSION['isLogged']) {

              echo '
                      <div class="dropdown me-3">
              <a class="btn btn-outline-light noBorder dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">';
                echo '<i class="fa-solid fa-user me-2"></i>';
                echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];
                echo '
              </a>
      
              <ul class="dropdown-menu me-2" aria-labelledby="dropdownMenuLink">';
              
              echo '<li><a class="dropdown-item" href="cuenta.php">Configuración de cuenta</a></li>';
              if ($_SESSION['nivel'] == 0 || $_SESSION['nivel'] == 3) {
                echo '<li><a class="dropdown-item" href="compras.php">Mis Compras</a></li>';          
              }
              if ($_SESSION['nivel'] > 0)
                echo '<li><hr></li>';
              
              if ($_SESSION['nivel'] == 3)
                echo '<li><a class="dropdown-item" href="admin.php?tab=productos">Panel de Administrador</a></li>';
              
              if ($_SESSION['nivel'] == 3 || $_SESSION['nivel'] == 1)
                echo '<li><a class="dropdown-item" href="ensamblador.php">Panel de Ensamblador</a></li>';

              if ($_SESSION['nivel'] == 3 || $_SESSION['nivel'] == 2)  
                echo '<li><a class="dropdown-item" href="despachante.php">Panel de Despachante</a></li>';
              
              echo '<li><hr></li>';

              echo '<li><a class="dropdown-item" href="logout.php">Desloguearse</a></li>';
              echo '</ul>
              </div> ';

              if ($_SESSION['nivel'] == 0 || $_SESSION['nivel'] == 3) {
                require_once 'carrolista.php';
                dibujarCarroLista("d-none d-lg-block");              
              }
      
          } else {
              echo '<div> <a class="fo me-3 datos" href="login.php">Login</a></br> </div>';
              echo '<div> <a class="fo me-3 datos" href="registro.php">Registrarse</a></br> </div>';
          }
             ?>
      </div>
    </div>
  </nav>
</header>
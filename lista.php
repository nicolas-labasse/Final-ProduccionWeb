<!doctype html>
<html lang="es">

<?php require_once 'componentes/head.php';?>

<body>

    <?php require_once 'componentes/header.php'; ?>

    <div class="container-fluid mt-5" style="min-height: 100vh">
    <div class="row justify-content-center mb-3" >
                <form action="lista.php" method="POST" class="d-flex input-group w-auto">
                    <input type="search" class="form-control rounded" id="buscar" name="buscar" placeholder="Buscar" aria-label="Buscar"
                        aria-describedby="search-addon" />
                        <button  class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                       </button>
                </form>
    </div>

        <div class="d-flex">
            <div class="me-3 d-md-block d-none">

                <!-- acá empieza dinámico-->
                <div style="width: 15rem">
                    <a href="lista.php">
                        <button type="button" class="btn btn-secondary">
                            TODOS LOS PRODUCTOS
                        </button>
                    </a>
                    <hr>
                    <?php require_once 'componentes/categoriaslateral.php'; 
                    
                    dibujarAcordeon("lateral");

                    ?>

                </div>
                <!-- acá termina dinámico-->
            </div>

         
                <div class="d-block" style="width:100%">
                <?php

                require_once 'componentes/card.php';

                require_once 'includes/conector.php';
                require_once 'modelos/paginador.php';
                    $conn = new Conector();
                    
                    if(!isset($_POST['buscar']) or  $_POST['buscar'] == null){
                       
                        if (isset($_GET['categoria'])) {
                            if (isset($_GET['subcategoria'])) {
                                $pagina = $_GET['pag'] ?? 1;
                                $result = $conn->CargarListadoPorCategoriaSubcategoria($_GET['categoria'], $_GET['subcategoria'],CalcularLimites($pagina,10),10);
                                $paginacion = Paginador($pagina, $conn->contarCategorias($_GET['categoria']),10);
                            } else {
                                $pagina = $_GET['pag'] ?? 1;
                                $result = $conn->CargarListadoPorCategoria($_GET['categoria'],CalcularLimites($pagina,10),10);
                                $paginacion = Paginador($pagina, $conn->contarCategorias($_GET['categoria']),10);
                            }
                        } else {
                            $pagina = $_GET['pag'] ?? 1;
                            $result = $conn->CargarListadoHabilitado(CalcularLimites($pagina,10),10);
                            $paginacion = Paginador($pagina, $conn->contarHabilitados(),10);
                        }
    
                            if ($result->num_rows > 0) {
                                foreach ($result as $row) {
                                    imprimirHorizontal($row['nombre'],"$ " . number_format($row['precio'], 0, ",", "."), $row['nombreCategoria'], $row['rutaImagen'], $row['id']);
                                }
                            }
                    }else{ 
                        $pagina = $_GET['pag'] ?? 1;
                        $result = $conn->mostrarBusqueda($_POST['buscar'],CalcularLimites($pagina,10),10);
                        $paginacion = Paginador($pagina, $conn->contarProductosBuscador($_POST['buscar']),10);
                        if ($result->num_rows > 0) {
                            foreach ($result as $row) {
                                imprimirHorizontal($row['nombre'],"$ " . number_format($row['precio'], 0, ",", "."), $row['nombreCategoria'], $row['rutaImagen'], $row['id']);
                            }
                            
                        }
                    }
                    echo'
                            <nav>
                            <ul class="pagination justify-content-center">

                                <li class="page-item '; if(!$paginacion['anterior']) echo 'disabled'; echo'">
                                    <a class="page-link"
                                    href="lista.php?&pag='.($paginacion['anterior']).'"
                                        aria-label="Anterior">
                                        <span aria-hidden="true">&laquo;</span>             
                                    </a>
                                </li>';
                                        for ($i = 1; $i <= $paginacion['cantidadPaginas']; $i++) {
                                            if ($pagina == $i)
                                                echo '<li class="page-item active"><span class="page-link">'.($i).'</span></li>';
                                                else
                                                echo '<li class="page-item"><a class="page-link" href="lista.php?&pag='.($i).'">'.($i).'</a></li>';
                                            
                                        }
                                echo '<li class="page-item'; if(!$paginacion['siguiente']) echo 'disabled'; echo'">
                                    <a class="page-link"
                                        href="lista.php?&pag='.($paginacion['siguiente']).'"
                                        aria-label="Siguiente">
                                        <span aria-hidden="true">&raquo;</span>
                                        
                                    </a>
                                </li>
                            </ul>
                        </nav>';
              
                ?>
            </div>
        </div>
    </div>


    <?php require_once 'componentes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
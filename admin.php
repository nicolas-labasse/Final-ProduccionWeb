<?php
    session_start();
    if (!$_SESSION['isLogged'] || ($_SESSION['nivel'] != 3))
          
    header("Location: index.php");
?>

<!doctype html>
<html lang="es">

<?php require_once 'componentes/head.php';?>

<body>

    

    <?php require_once 'componentes/header.php'; ?>

    <div class=" d-flex d-md-none nav-pills me-3" style="width: 10rem" aria-orientation="vertical">
        <a href="admin.php?tab=productos" class="noStyle">
            <button style="width: 100%"
                class="nav-link <?php if ($_GET['tab'] == 'productos' || !isset($_GET['tab'])) echo 'active fw-bold';?>">Productos</button>
        </a>
        <a href="admin.php?tab=usuarios" class="noStyle">
            <button style="width: 100%"
                class="nav-link <?php if ($_GET['tab'] == 'usuarios') echo 'active fw-bold';?>">Usuarios</button>
        </a>
        <a href="admin.php?tab=categorias" class="noStyle">
            <button style="width: 100%"
                class="nav-link <?php if ($_GET['tab'] == 'categorias') echo 'active fw-bold';?>">Categorías</button>
        </a>
    </div>

    <div class="d-flex align-items-start mt-3">
        <div class="nav flex-column d-none d-md-flex nav-pills me-3" style="width: 10rem" aria-orientation="vertical">
            <a href="admin.php?tab=productos" class="noStyle">
                <button style="width: 100%"
                    class="nav-link <?php if (!isset($_GET['tab']) || $_GET['tab'] == 'productos') echo 'active fw-bold';?>">Productos</button>
            </a>
            <a href="admin.php?tab=usuarios" class="noStyle">
                <button style="width: 100%"
                    class="nav-link <?php if ($_GET['tab'] == 'usuarios') echo 'active fw-bold';?>">Usuarios</button>
            </a>
            <a href="admin.php?tab=categorias" class="noStyle">
                <button style="width: 100%"
                    class="nav-link <?php if ($_GET['tab'] == 'categorias') echo 'active fw-bold';?>">Categorías</button>
            </a>
        </div>

        <div style="width: 100%"
            class="<?php echo (!isset($_GET['tab']) || $_GET['tab'] == 'productos') ? ' d-flex' : 'd-none'?>">
            <div class="px-3" style="width: 100%">

                <div class="table-title">
                
                    <div class="row ps-2">
                        <div class="col-12 col-md-6">
                            <h2>Administrar <b>Productos</b></h2>
                        </div>
                        <div class="col-12 col-md-6 d-flex">
                            <div class="d-block">
                                <a href="admin_addProd.php" class="btn btn-success" data-toggle="modal">
                                    <i class="fa-solid fa-plus"></i>
                                    <span class="d-none d-lg-inline">Nuevo</span>
                                </a>
                            </div>
                            <div>
                                <div class="input-group rounded ms-3">
                                    <input type="search" class="form-control rounded" placeholder="Buscar..."
                                        aria-label="Search" aria-describedby="search-addon" />
                                    <span class="input-group-text border-0" id="search-addon">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th class="d-none d-lg-table-cell">Categoría</th>
                            <th class="d-none d-lg-table-cell">Subcategoría</th>
                            <th class="d-none d-md-table-cell">Precio</th>
                            <th class="d-none d-md-table-cell">Habilitado</th>
                            <th class="d-table-cell d-md-none">H</th>
                            <th class="d-none d-md-table-cell">Promoción</th>
                            <th class="d-table-cell d-md-none">P</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        

                        require_once 'includes/conector.php';
                        require_once 'modelos/paginador.php';
                        $conn = new Conector();
                        $pagina = $_GET['pag'] ?? 1;
                        $productos = $conn->CargarListadoCompletoPaginado(CalcularLimites($pagina, 10), 10);

                        foreach ($productos as $row) {
                                echo '<td>'.$row['nombre'].'</td>';
                                echo '<td class="d-none d-lg-table-cell"> '.$row['nombreCategoria'].'</td>';
                                echo '<td class="d-none d-lg-table-cell"> '. (is_null($row['subcategoria']) ? ' ' : $row['nombreSubcategoria']) . ' </td>';
                                echo '<td class="d-none d-md-table-cell"> $'.number_format($row['precio'], 0, ",", ".") .  '</td>';

                                echo '<td><i class="fa-solid '. ($row['esHabilitado'] == 1 ? 'fa-check' : 'fa-x').' ms-2"></i></td>';
                                echo '<td><i class="fa-solid '. ($row['esPromocion'] == 1 ? 'fa-check' : 'fa-x').' ms-2"></i></td>';
                                echo '
                                    <td>
                                        <div class="d-flex">
                                        <a href="admin_modProd.php?prodID='.$row['id'].'" class="fa-solid fa-pencil me-2" style="text-decoration: none; color: green;" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"></a>                                
                                        <a href="admin_delProd.php?prodID='.$row['id'].'&method='. ($row['esHabilitado'] == 0 ? '1' : '0').'" class="fa-solid '. ($row['esHabilitado'] == 0 ? 'fa-check' : 'fa-x').' me-2" style="text-decoration: none; color: red;" data-bs-toggle="tooltip" data-bs-placement="top" title="'. ($row['esHabilitado'] == 0 ? 'Habilitar' : 'Deshabilitar').'"></a>
                                        <a href="admin_promProd.php?prodID='.$row['id'].'&method='. ($row['esPromocion'] == 0 ? '1' : '0').'" class="fa-solid '. ($row['esPromocion'] == 0 ? 'fa-angles-up' : 'fa-angles-down').' me-2" style="text-decoration: none; color: dark-blue;" data-bs-toggle="tooltip" data-bs-placement="top" title="'. ($row['esPromocion'] == 0 ? 'Promocionar' : 'Quitar promoción').'"></a>
                                        </div>
                                    </td>
                                    ';
                            echo "</tr>";
                        }                        
                        ?>
                    </tbody>
                </table>


                <nav>

                    <?php
                        $paginacion = Paginador($pagina, $conn->ContarProductosHabilitados(), 10);
                    ?>

                    <ul class="pagination justify-content-center">

                        <li class="page-item <?php if(!$paginacion['anterior']) echo 'disabled'?>">
                            <a class="page-link"
                                href="admin.php?tab=productos&pag=<?php echo ($paginacion['anterior']) ?>"
                                aria-label="Anterior">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>

                        <?php
                            for ($i = 1; $i <= $paginacion['cantidadPaginas']; $i++) {
                                if ($pagina == $i)
                                    echo '<li class="page-item active"><span class="page-link">'.($i).'</span></li>';
                                else
                                    echo '<li class="page-item"><a class="page-link" href="admin.php?tab=productos&pag='.($i).'">'.($i).'</a></li>';
                                
                            }?>

                        <li class="page-item <?php if(!$paginacion['siguiente']) echo 'disabled'?>">
                            <a class="page-link"
                                href="admin.php?tab=productos&pag=<?php echo ($paginacion['siguiente'])?>"
                                aria-label="Siguiente">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div style="width: 100%" class="<?php echo ($_GET['tab'] == 'usuarios')? ' d-block' : ' d-none'?>">
            <div class="px-3" style="width: 100%">

                <div class="table-title">
                    <div class="row ps-2">
                        <div class="col-12 col-md-6">
                            <h2>Administrar <b>Usuarios</b></h2>
                        </div>
                        <div class="col-12 col-md-6 d-flex">
                            <div class="d-block">
                                <a href="admin_addUsr.php" class="btn btn-success" data-toggle="modal">
                                    <i class="fa-solid fa-plus"></i>
                                    <span class="d-none d-lg-inline">Nuevo</span>
                                </a>
                            </div>
                            <div>
                                <div class="input-group rounded ms-3">
                                    <input type="search" class="form-control rounded" placeholder="Buscar..."
                                        aria-label="Search" aria-describedby="search-addon" />
                                    <span class="input-group-text border-0" id="search-addon">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th class="d-none d-lg-table-cell">Nombre</th>
                            <th class="d-none d-lg-table-cell">Apellido</th>
                            <th class="d-none d-md-table-cell">Email</th>
                            <th class="d-none d-md-table-cell">Nivel de Usuario</th>
                            <th class="d-table-cell d-md-none">Nv. U</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        
                        require_once 'includes/conector.php';
                        require_once 'modelos/paginador.php';
                        $conn = new Conector();
                        $pagina = $_GET['pag'] ?? 1;
                        $usuarios = $conn->CargarUsuariosPaginado(CalcularLimites($pagina, 10), 10);

                        foreach ($usuarios as $row) {
                            echo '<tr>';
                            echo '<td>'.$row['usuario'].'</td>';
                            echo '<td class="d-none d-lg-table-cell">'.$row['nombre'].'</td>';
                            echo '<td class="d-none d-lg-table-cell">'.$row['apellido'].'</td>';
                            echo '<td class="d-none d-md-table-cell">'.$row['email'].'</td>';

                            echo '<td><span class="badge '.$row['tipoBadge'].'">'.$row['descripcion'].'</span></td>';

                            echo '
                                    <td>
                                        <a href="admin_modUsr.php?userID='.$row['id'].'" class="fa-solid fa-pencil me-2" style="text-decoration: none; color: green;" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"></a>
                                        <a href="admin_delUsr.php?userID='.$row['id'].'&method='. ($row['f_baja'] ? 'alta' : 'baja').'" class="fa-solid '. ($row['f_baja'] ? 'fa-check' : 'fa-x').' me-2" style="text-decoration: none; color: red;" data-bs-toggle="tooltip" data-bs-placement="top" title="'. ($row['f_baja'] ? 'Habilitar' : 'Deshabilitar').'"></a>
                                        <a href="admin_resUsr.php?userID='.$row['id'].'" class="fa-solid fa-key me-2" style="text-decoration: none; color: light-blue;" data-bs-toggle="tooltip" data-bs-placement="top" title="Resetear Contraseña"></a>
                                    </td>
                                    ';
                            echo '</tr>';
                        }                        
                        ?>
                    </tbody>
                </table>
                
                <nav>
                    <?php
                        $paginacion = Paginador($pagina, $conn->ContarUsuarios(), 10);
                    ?>

                    <ul class="pagination justify-content-center">

                        <li class="page-item <?php if(!$paginacion['anterior']) echo 'disabled'?>">
                            <a class="page-link"
                                href="admin.php?tab=usuarios&pag=<?php echo ($paginacion['anterior']) ?>"
                                aria-label="Anterior">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>

                        <?php
                            for ($i = 1; $i <= $paginacion['cantidadPaginas']; $i++) {
                                if ($pagina == $i)
                                    echo '<li class="page-item active"><span class="page-link">'.($i).'</span></li>';
                                else
                                    echo '<li class="page-item"><a class="page-link" href="admin.php?tab=usuarios&pag='.($i).'">'.($i).'</a></li>';
                                
                            }?>

                        <li class="page-item <?php if(!$paginacion['siguiente']) echo 'disabled'?>">
                            <a class="page-link"
                                href="admin.php?tab=usuarios&pag=<?php echo ($paginacion['siguiente'])?>"
                                aria-label="Siguiente">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div style="width: 100%" class="<?php echo ($_GET['tab'] == 'categorias')? ' d-block' : ' d-none'?>">
            <div class="px-3" style="width: 100%">
                
                <div class="table-title">
                    <div class="row ps-2">
                        <div class="col-12 col-md-6">
                            <h2>Administrar <b>Categorías</b></h2>
                        </div>
                        <div class="col-12 col-md-6 d-flex">
                            <div class="d-block">
                                <a href="admin_addUsr.php" class="btn btn-success" data-toggle="modal">
                                    <i class="fa-solid fa-plus"></i>
                                    <span class="d-none d-lg-inline">Nuevo</span>
                                </a>
                            </div>
                            <div>
                                <div class="input-group rounded ms-3">
                                    <input type="search" class="form-control rounded" placeholder="Buscar..."
                                        aria-label="Search" aria-describedby="search-addon" />
                                    <span class="input-group-text border-0" id="search-addon">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                    
                        <?php
                        
                        require_once 'includes/conector.php';
                        $conn = new Conector();
                        $pagina = $_GET['pag'] ?? 1;
                        $categorias = $conn->CargarCategorias();

                        foreach ($categorias as $categoria) {
                            $subcategorias = $conn->CargarSubCategoriasPorCategoria($categoria['id']);
                            $modelosCategoria = $conn->CargarModeloAdicionales($categoria['categoria']);
                            echo '
                            <div class="row">
                                <div class="col-6">
                                    <table class="table table-striped table-hover">
                                        <thead class="mt-3">
                                            <tr>
                                                <th style="width:200px">'.$categoria['categoria'].'<a href="" class="fa-solid fa-pencil ms-2" style="text-decoration: none; color: green;" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Estructura"></a></th>
                                                <th style="width:200px"></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        ';

                                        foreach ($subcategorias as $subcategoria) {
                                            echo '
                                                <tr>
                                                    <td>'.$subcategoria['subcategoria'].'</td>
                                                    <td>'.$subcategoria['nombre'].'</td>
                                                    <td><a href="" class="fa-solid fa-eraser me-2" style="text-decoration: none; color: red;" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar"></a></td>
                                                </tr>
                                            ';
                                        }
                                        echo ' 
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-6">
                                    <table class="table table-striped table-hover">
                                        <thead class="mt-3">
                                            <tr>
                                                <th style="width:200px"></th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        ';

                                        foreach ($modelosCategoria as $modeloCategoria) {
                                            echo '
                                                <tr>
                                                    <td>'.$modeloCategoria['columna'].'</td>
                                                    <td><a href="" class="fa-solid fa-eraser me-2" style="text-decoration: none; color: red;" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar"></a></td>
                                                </tr>
                                                
                                            ';
                                        }
                                        echo ' 
                                        </tbody>
                                    </table>                                        
                                </div>
                            </div>
                            ';
                        }                      
                        ?>
                    
                
                    
                
            </div>
        </div>

    </div>


    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
</body>

</html>
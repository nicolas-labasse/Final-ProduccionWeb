<?php
    if (!$_SESSION['isLogged'] || $_SESSION['nivel'] != 3 || $_SESSION['nivel'] != 1) {}
    header("Location: index.php");
?>

<!doctype html>
<html lang="es">

<?php

use LDAP\Result;

 require_once 'componentes/head.php';?>

<body class="fondoArmador">

    <?php require_once 'componentes/header.php'; ?>
    <section>
        <div class="container mt-5" style="min-height: 100vh">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="col-6">
                <?php
                     require_once 'componentes/card.php';
                     require_once 'includes/conector.php';
                     require_once 'modelos/paginador.php';
                     $conn = new Conector();
                     if($_SESSION['isLogged']){
                        $_SESSION['lista'] = array();
                        
                        
                      
                        
                        $_SESSION['lista'] = $lista;
                         var_dump($_SESSION['lista']);
                     }
                  
            
                    ?>
                </div>
                <div class="col-6">
                    <div class="card p-3 <?php echo ($_GET['tab']) ? ' d-none' : 'd-block'?>">
                        <div class="card-body">
                            <h5 class="card-title text-center">Arma tu PC</h5>
                            <div class="card mt-5">
                                <div class="card-body text-center">
                                    <a href="">Quiero que me guien</a>
                                </div>
                            </div>
                            <div class="card mt-3">
                                <div class="card-body text-center">
                                    <a href="armador.php?tab=armar"
                                        class=" <?php if ($_GET['tab'] == 'armar' || !isset($_GET['tab'])) echo 'active fw-bold';?>">
                                        Conozco del tema</a>
                                </div>
                            </div>
                        </div>
                    </div><!--Fin Inicio-->

                    <div class=" <?php echo ($_GET['tab'] == 'armar') ? ' d-block' : 'd-none'?>">
                        <?php
                            require_once 'componentes/card.php';
                            require_once 'includes/conector.php';
                            require_once 'modelos/paginador.php';
                            $conn = new Conector();
                            $pagina = $_GET['pag'] ?? 1;
                            $result = $conn->CargarListadoPorCategoriaUnico('microprocesador',CalcularLimites($pagina,10),10);
                            $paginacion = Paginador($pagina, $conn->contarCategorias('microprocesador'),10);
                            if ($result->num_rows > 0) {
                                echo'
                                    <div class="card p-3">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">Elegi la Marca del Procesador</h5>';
                                        foreach ($result as $row) {                               
                                        echo'
                                            <div class="card mt-3">
                                                <div class="card-body text-center">
                                                    <a href="armador.php?tab='.$row['marca'].'">
                                                    '.$row['marca'].'</a>
                                                </div>
                                            </div>';
                                        }
                                      
                                echo'
                                </div>
                            </div>';
                              
                            }
                        
                        ?>
                    </div><!--Fin Marca-->
                    
                    <div class=" <?php echo (isset($_GET['tab']) && $_GET['tab'] != 'armar' && $_GET['socket'] == null) ? ' d-block' : 'd-none'?>">
                        <?php
                        require_once 'componentes/card.php';
                        require_once 'includes/conector.php';
                        require_once 'modelos/paginador.php';
                        $conn = new Conector();                  
                        $result = $conn->CargarListadoPorCategoriaArmador('microprocesador',$_GET['tab']);
                        $lista = $result->fetch_assoc();
                        if ($result->num_rows > 0) {
                            echo'
                                <div class="card p-4">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4 text-center">Elegi tu procesador '.$_GET['tab'].'</h5>';
                                    foreach ($result as $row) { 
                                                             
                                    cardArmadorSocket($row['nombre'],"$ " . number_format($row['precio'], 0, ",", "."), $row['nombreCategoria'], $row['rutaImagen'],'motherboard',$row['socket']);
                                    
                                }
                            echo'
                            </div>
                        </div>';
                          
                        }
                    
                        ?>
                    </div><!--Fin ProductoProcesador-->

                    <div class=" <?php echo (isset($_GET['tab']) && $_GET['tab'] == 'motherboard' && $_GET['socket'] != null) ? ' d-block' : 'd-none'?>">
                        <?php
                            require_once 'componentes/card.php';
                            require_once 'includes/conector.php';
                            require_once 'modelos/paginador.php';
                            $conn = new Conector();                  
                            $result = $conn->CargarProductoPorSocket($_GET['socket']);
                            
                            if ($result->num_rows > 0) {
                                echo'
                                    <div class="card p-4">
                                        <div class="card-body">
                                            <h5 class="card-title mb-4 text-center">Elegi tu '.$_GET['tab'].'</h5>';
                                        foreach ($result as $row) {  
                                        cardArmador($row['nombre'],"$ " . number_format($row['precio'], 0, ",", "."),$_GET['tab'] , $row['rutaImagen'],'memoria',$row['id']);                    
                                    }
                                echo'
                                </div>
                            </div>';
                            
                            }
                        
                            ?>
                    </div><!--Fin ProductoMotherboard-->
                    

                    <div class=" <?php echo (isset($_GET['tab']) && $_GET['tab'] == 'memoria') ? ' d-block' : 'd-none'?>">
                    <?php
                            require_once 'componentes/card.php';
                            require_once 'includes/conector.php';
                            require_once 'modelos/paginador.php';
                            $conn = new Conector();                  
                            $result = $conn->CargarProductoExtrasSinID($_GET['tab']);
                            if ($result->num_rows > 0) {
                                echo'
                                    <div class="card p-4">
                                        <div class="card-body">
                                            <h5 class="card-title mb-4 text-center">Elegi tu '.$_GET['tab'].'</h5>';
                                        foreach ($result as $row) {                              
                                        cardArmador($row['nombre'],"$ " . number_format($row['precio'], 0, ",", "."),$_GET['tab'] , $row['rutaImagen'],'disco',$row['id']);                    
                                    }
                                echo'
                                </div>
                            </div>';
                            
                            }
                        
                            ?>
                    </div><!--Fin ProductoProcesador-->
                    <div class=" <?php echo (isset($_GET['tab']) && $_GET['tab'] == 'disco') ? ' d-block' : 'd-none'?>">
                    <?php
                            require_once 'componentes/card.php';
                            require_once 'includes/conector.php';
                            require_once 'modelos/paginador.php';
                            $conn = new Conector();                  
                            $result = $conn->CargarProductoExtrasSinID($_GET['tab']);
                            if ($result->num_rows > 0) {
                                echo'
                                    <div class="card p-4">
                                        <div class="card-body">
                                            <h5 class="card-title mb-4 text-center">Elegi tu '.$_GET['tab'].'</h5>';
                                        foreach ($result as $row) {                              
                                        cardArmador($row['nombre'],"$ " . number_format($row['precio'], 0, ",", "."),$_GET['tab'] , $row['rutaImagen'],'disco',$row['id']);                    
                                    }
                                echo'
                                </div>
                            </div>';
                            
                            }
                        
                            ?>
                    </div><!--Fin ProductoProcesador-->
                   

                    
                </div><!--Fin COL-->
            </div><!--Fin ROW-->
        </div>
        <!--Fin container-->
    </section>


    <?php require_once 'componentes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">


<?php require_once 'componentes/head.php'; ?>


<body>
<?php require_once 'componentes/header.php'; ?>
<section>
<div class="container" style="height:100vh">
        <div class="row d-flex align-items-center justify-content-center" style="height: 100%;">
                <div class="col-6">
                    <section class="galeria container">
                        <div class="row py-3 shadow-5">
                            <div class="col-12 mb-1">
                                   <?php 
                                   if (isset($_GET['id'])) {

                                        require_once 'includes/conector.php';
                                        

                                        $conn = new Conector();
                                        $result = $conn->CargarProductoConID($_GET['id']);

                                        if ($result->num_rows > 0) {
                                            $rowProducto = $result->fetch_assoc();

                                        
                                            echo '
                                            <div class="centro">
                                            <a href="#imagen0">
                                            <img src="./imagenes/productos/'.$rowProducto['rutaImagen'].'" class="img-fluid rounded-start ms-1" alt="...">
                                            </a>
                                            </div>';
                                        
                                        } else {
                                        echo '404';
                                        }
                                    }?>
                                
                                                               
                            </div>
                            <?php 
                            echo'
                            <div class="col-3 mt-1">
                            <a href="#imagen1">
                            <img src="./imagenes/productos/'.$rowProducto['rutaImagen'].'" class="img-fluid rounded-start ms-1" alt="...">
                            </a>
                            </div> 
                            <div class="col-3 mt-1">
                            <a href="#imagen2">
                            <img src="./imagenes/productos/'.$rowProducto['rutaImagen'].'" class="img-fluid rounded-start ms-1" alt="...">
                                </a>
                            </div>
                            <div class="col-3 mt-1">
                            <a href="#imagen3">
                            <img src="./imagenes/productos/'.$rowProducto['rutaImagen'].'" class="img-fluid rounded-start ms-1" alt="...">
                                </a>
                            </div>
                            <div class="col-3 mt-1">
                            <a href="#imagen4">
                            <img src="./imagenes/productos/'.$rowProducto['rutaImagen'].'" class="img-fluid rounded-start ms-1" alt="...">
                                </a>
                            </div>
                            ';
                            ?>
                          
                        </div>
                    </section>
                </div>
                <div class="col-6 text-center mt-5">
                   
                    <?php 
                     echo'
                     <h1 class="h2">
                      '.$rowProducto['nombreCategoria'].'('.$rowProducto['nombreSubcategoria'].')
                     </h1>
                     <h2 class="h4">
                        '.$rowProducto['nombre'].'
                    </h2>
                    <hr style="width: 50%;">';
                         $result = $conn->CargarProductoConID($_GET['id']);
                        if ($result->num_rows > 0) {
                            $rowProducto = $result->fetch_assoc();
                            $result = $conn->CargarProductoExtras($rowProducto['categoria'],$_GET['id']);
                            if($result->num_rows > 0 && $result){
                                $rowAdicionales = $result->fetch_array();
                                $result = $conn->CargarModeloAdicionales($rowProducto['categoria']);
                                echo '<table class="table table-borderless">';
                                    echo '<tbody class="text-start">';
                                        $nroColumna = 2;
                                        foreach ($result as $rowModelo) {
                                            echo "<tr>";
                                                echo "<td>{$rowModelo['texto']}</td>";
                                                echo "<td>{$rowAdicionales[$nroColumna]} {$rowModelo['unidad']}</td>";
                                                $nroColumna++;
                                            echo "</tr>";
                                        }
                                    echo '</tbody>';
                                echo '</table>';
                            }
                        }
                                            
                    echo'<hr class="hrderecha" style="width: 50%;">
                    
                    <p class="text-end">Precio $ '.$rowProducto['precio'].'</p> 
                   <div class="d-flex">
                   <a href="procedimientos/carritoAgregar.php?prodID='.$_GET['id'].'"><i class="h2 fa-solid fa-cart-plus text-dark"></i></a>
                   <a href="" class="btn btn-outline-dark but">Comprar</a> 
                   </div>
                   ';
                   
                    
                    $cont = 0;
                    $imagenes = 5;
                    for($i=0; $i < $imagenes; $i++){
                        if($cont == 0){
                            echo'
                                <article class="box" id="imagen0">
                                <a href="#imagen'.($imagenes - 1).'" class="next me-2"><i class="fa-solid fa-arrow-left-long"></i></a>
                                <img src="./imagenes/productos/'.$rowProducto['rutaImagen'].'" class="img-fluid" alt="...">
                                <a href="#imagen1" class="next ms-2"><i class="fa-solid fa-arrow-right-long"></i></a>
                                <a href="#" class="close">X</a>
                                </article>';
                                $cont++;
                        }else{
                            echo'
                            <article class="box" id="imagen'.$cont.'">
                            <a href="#imagen'.($cont-1).'" class="next me-2"><i class="fa-solid fa-arrow-left-long"></i></a>
                            <img src="./imagenes/productos/'.$rowProducto['rutaImagen'].'" class="img-fluid" alt="...">
                            <a href="#imagen'.(($cont+1) == $imagenes? 0 : ($cont + 1)).'" class="next ms-2"><i class="fa-solid fa-arrow-right-long"></i></a>
                            <a href="#" class="close">X</a>
                            </article>';
                            $cont++;
    
                        }
                    }
                   ?>
                   
                </div>
            </div>
        </div>
    </section>
   



<?php require_once 'componentes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
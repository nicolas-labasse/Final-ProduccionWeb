<!doctype html>
<html lang="es">

<?php require_once 'componentes/head.php';?>

<body>

    <?php require_once 'componentes/header.php'; ?>

    <section style="min-height: 90vh;">
        <div class="container">
            <h1>Carrito</h1>
            <div class="row">
                <div class="col-8">
                    <?php

                            require_once 'componentes/card.php';
                            require_once 'includes/conector.php';
                            $conn = new Conector();
                            $result = $conn->CargarCarrito();
                            if ($result->num_rows > 0) {
                                $total = 0;
                                foreach ($result as $row) {
                                    imprimirHorizontalCarro($row['cantidad'].'x '.$row['marca'].' '.$row['modelo'],"$ " . number_format($row['precio'], 0, ",", "."), $row['nombreCategoria'], $row['rutaImagen'], $row['id']);
                                    $total += $row['precio'] * $row['cantidad'];
                                }
                            }else{
                                echo '
                                <p class="card-text">No hay ningun producto en el carro</p>
                              ';

                            }

                            ?>
                </div>
                <div class="col-3">
                    <div class="card text-dark mx-3 mx-sm-auto my-2" style="max-height:433px;">
                        <div class="card-body">
                        <h1 class="h5 mt-3">Total:</h1>
                        <?php 
                       
                        if($result->num_rows > 0){
                           
                          echo '
                            <p class="card-text text-center">$ '.number_format($total,0,",",".").'</p>
                            <div class=" d-flex justify-content-center">
                             <a href="procedimientos/carritoEjecutarVenta.php?userID='.$_SESSION['userID'].'" class="btn btn-outline-dark" style="width:80%">Pagar</a>
                             </div>
                          '; 
                        }else{
                            echo '
                            <p class="card-text">No hay ningun producto en el carro</p>
                          ';
                        }
                        
                        ?>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  




    <?php require_once 'componentes/footer.php'; ?>

    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
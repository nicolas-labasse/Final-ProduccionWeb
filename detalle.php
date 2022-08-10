
<!doctype html>
<html lang="es">

<?php require_once 'componentes/head.php';?>

<body>

    <?php require_once 'componentes/header.php'; ?>

    <section style="min-height: 90vh;">
        <div class="container">
        <?php  
        echo'
        <div class="row justify-content-center">
            <div class="col-8 mt-3">
            <h1 class="text-center">Detalles del Pedido '.$_GET['pedidoID'].'</h1>
            ';
                            require_once 'componentes/card.php';
                            require_once 'includes/conector.php';
                            $conn = new Conector();
                            $result = $conn->DetallePedido($_GET['pedidoID']); 
                             if ($result->num_rows > 0) {
                                $total = 0;
                                foreach ($result as $row) {
                                    
                                    imprimirDetalle($row['nombreCategoria'], $row['nombre'],"$ " . number_format($row['precio'], 0, ",", ".") ,$row['rutaImagen'], $row['id']);
                                }
                            }else{
                                echo '
                                <p class="card-text">No hay ningun producto en el carro</p>
                            ';

                            }

                ?>
                  <a href="./despachante.php" class="fo d-flex fa-solid fa-arrow-left h2 ms-3 text-dark">
        </a>
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





























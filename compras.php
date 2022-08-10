<!doctype html>
<html lang="es">

<?php require_once 'componentes/head.php';?>

<body>

   

    <?php require_once 'componentes/header.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col">
            <div class="table-title">
                <h2 class="text-center mt-3 mb-2">Tus <b>Compras</b></h2>
                </div>
           <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Numero de pedido</th>
                                <th>Fecha de Creacion</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                     
                            <?php
                       

                        require_once 'includes/conector.php';
                        $conn = new Conector();
                        $result = $conn->MostrarPedidoPorID($_SESSION['userID']);
                        foreach ($result as $row) {
                            echo '<tr>';
                                echo "<td> {$row['id']}</td>";
                                echo "<td> {$row['fechaCreacion']}</td>";
                                echo "<td> {$row['estado']}</td>";
                            echo "</tr>";
                        }                   
                        ?>
                        </tbody>
                    </table>

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
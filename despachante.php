<?php
session_start();
    if (!$_SESSION['isLogged'] || ($_SESSION['nivel'] != 3 && $_SESSION['nivel'] != 2))
        header("Location: index.php");
?>

<!doctype html>
<html lang="es">

<?php require_once 'componentes/head.php';?>

<body>

    <?php
    if (!$_SESSION['isLogged'] || $_SESSION['nivel'] != 3 && $_SESSION['nivel'] != 2)
        header("Location: index.php");
    ?>

    <?php require_once 'componentes/header.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col">
            <div class="table-title">
                <h2 class="text-center mt-3 mb-2">Administrar <b>Pedidos</b></h2>
                </div>
           <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Id pedido</th>
                                <th>Fecha de Creacion</th>
                                <th>Fecha de Despacho</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                     
                            <?php
                       

                        require_once 'includes/conector.php';
                        $conn = new Conector();
                        $result = $conn->VistaPedidos("despacho");
                        foreach ($result as $row) {
                            echo '<tr>';
                                echo "<td> {$row['id']}";
                                echo "<td> {$row['fechaCreacion']}";
                                echo "<td> {$row['fechaDespacho']}";
                                echo "<td> {$row['estado']}";
                                echo "<td>";
                                echo '<a href="detalle.php?pedidoID='.$row['id'].'" class="fa-solid fa-eye me-2" style="text-decoration: none; color: blue;" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Productos"></a>';
                                if ($row['cod_estado'] == 1)
                                    echo '<a href="despachante_despachar.php?pedidoID='.$row['id'].'" class="fa-solid fa-calendar-plus me-2" style="text-decoration: none; color: red;" data-bs-toggle="tooltip" data-bs-placement="top" title="Actualizar fecha de despacho"></a>';
                                echo "</td>"; 
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
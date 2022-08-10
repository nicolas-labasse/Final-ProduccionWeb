<?php

session_start();

if (isset($_POST['prodID'])) {

    require_once 'includes/conector.php';
    $conn = new Conector();

    $result = $conn->ModificarProducto($_POST);

    header("Location: admin.php?tab=productos#".$_POST['prodID']);
}

if (!isset($_GET['prodID']))
    header("Location: admin.php");
?>

<!doctype html>
<html lang="es">

<?php require_once 'componentes/head.php';?>

<body>

    <?php    
    
    require_once 'componentes/header.php';
    require_once 'includes/conector.php';

    $conn = new Conector();

    $producto = ($conn->CargarProductoConID($_GET['prodID']))->fetch_assoc();
    $dataExtra = ($conn->CargarProductoExtras($producto['categoria'], $_GET['prodID']))->fetch_array();
    $modeloExtra = ($conn->CargarModeloAdicionales($producto['categoria']));
    
    ?>

    <div style="height: 10vh">

    </div>

    <section class="mx-auto" style="max-width:1200px">
        <form action="admin_modProd.php" method="POST" enctype="multipart/form-data">
            <div class="row border shadow p-3">
                <div class="row col-12 col-md-6">
                    <h4>Información Primaria</h4>

                    <div class="form-floating col-12 mb-2">
                        <input type="text" id="nombre" class="form-control" value="<?php echo $producto['nombre'] ?>"
                            name="nombre" placeholder="MSI" required>
                        <label for="nombre" class="ms-2">Nombre</label>
                    </div>

                    <div class="form-floating col-12 col-md-6 mb-2">
                        <input type="text" id="marca" class="form-control" value="<?php echo $producto['marca'] ?>"
                            name="marca" placeholder="MSI" required>
                        <label for="marca" class="ms-2">Marca</label>
                    </div>

                    <div class="form-floating col-12 col-md-6 mb-2">
                        <input type="text" id="modelo" class="form-control" value="<?php echo $producto['modelo'] ?>"
                            name="modelo" placeholder="MSI" required>
                        <label for="modelo" class="ms-2">Modelo</label>
                    </div>

                    <div class="form-floating col-12 col-md-8 mb-2">
                        <input type="text" id="precio" class="form-control" value="<?php echo $producto['precio'] ?>"
                            name="precio" placeholder="MSI" required>
                        <label for="precio" class="ms-2">Precio en Pesos</label>
                    </div>

                    <div class="form-floating col-12 col-md-4 mb-2">
                        <input type="text" id="stock" class="form-control" value="<?php echo $producto['stock'] ?>"
                            name="stock" placeholder="MSI" required>
                        <label for="stock" class="ms-2">Stock</label>
                    </div>

                    <input type="hidden" name="prodID" value="<?php echo $producto['id'] ?>">
                    <input type="hidden" name="categoria" value="<?php echo $producto['categoria'] ?>">
                    <input type="hidden" name="cod_categoria" value="<?php echo $producto['cod_categoria'] ?>">



                </div>

                <div class="row col-12 col-md-6">
                    <h4>Información Adicional</h4>

                    <div class="form-floating col-12 col-md-4 mb-2">
                        <input type="text" id="categoria" class="form-control"
                            value="<?php echo $producto['nombreCategoria'] ?>" placeholder="MSI" disabled>
                        <label for="categoria" class="ms-2">Categoría</label>
                    </div>

                    <div class="form-floating col-8 mb-2">
                        <select class="form-select" id="subcategoria" name="subcategoria" placeholder="MSI" required>;
                            <?php
                            $subCategorias = $conn->CargarSubCategoriasPorCategoria($producto['cod_categoria']);
                            foreach ($subCategorias as $rowSub) {
                                if ($rowSub['subcategoria'] == $producto['subcategoria'])
                                    echo '<option value="'.$rowSub['subcategoria'].'" selected>'.$rowSub['subcategoria'].'</option>';
                                else
                                    echo '<option value="'.$rowSub['subcategoria'].'">'.$rowSub['subcategoria'].'</option>';
                            }
                            ?>
                        </select>
                        <label for="subcategoria" class="ms-2">Subcategoría</label>
                    </div>

                    <input type="hidden" name="FINBASE" value=1> <!-- ESTO TIENE QUE QUEDAR JUUUUUUSTO ACÁ-->

                    <?php
                    $nroColumna = 2;
                    foreach ($modeloExtra as $filaME) {
                        echo '<div class="form-floating col-12 col-md-6 mb-2">';
                            echo '<input 
                            type="text" id="'.$filaME['columna'].'" name="'.$filaME['columna'].'" 
                                class="form-control" value="'.$dataExtra[$nroColumna].'" placeholder="MSI" required>';
                            echo '<label for="'.$filaME['columna'].'" class="ms-2">'.$filaME['texto'].'</label>';
                        echo '</div>';
                        $nroColumna++;
                    }
                    ?>



                </div>

                <div class="d-block text-end mt-4">
                    <button class="btn btn-lg btn-success" type="submit">Modificar Producto</button>
                </div>
            </div>
        </form>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
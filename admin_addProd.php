<?php

if (isset($_FILES['imagen']['name'])) {

    require_once 'includes/conector.php'; 
    $conn = new Conector();


    // realizar chequeos previos

    $tipoArchivo = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));

    do {
        
        $aleatorio = mt_rand(100000,999999);
        $checkExiste = $conn->query("SELECT * FROM productos WHERE rutaImagen='{$aleatorio}.{$tipoArchivo}'");
        
    } while ($checkExiste->num_rows > 0);

    $directorio = "imagenes/productos/";
    $nombreFinal = $aleatorio . '.'. $tipoArchivo;
    $archivo = $directorio . $nombreFinal;
    
    move_uploaded_file($_FILES['imagen']['tmp_name'], $archivo);

    $result = $conn->InsertarProducto($_POST['nombre'], $_POST['marca'], $_POST['modelo'], $_POST['precio'], $_POST['stock'], $_POST['categoria'], $nombreFinal);

    if ($result) {
        header("Location: admin.php?tab=productos");
    }    
}
?>

<!doctype html>
<html lang="es">

<?php require_once 'componentes/head.php';?>

<body>

    <?php
    
    require_once 'componentes/header.php';
    require_once 'includes/conector.php';

    $conn = new Conector();
    
    ?>

    <div style="height: 10vh">

    </div>

    <section class="mx-auto" style="max-width:60%">
        <form action="admin_addProd.php" method="POST" enctype="multipart/form-data">

            <div class="row">
                <div class="form-floating col-4 mb-2">
                    <input type="text" id="nombre" class="form-control" name="nombre" placeholder="MSI" required>
                    <label for="nombre" class="ms-3">Nombre</label>
                </div>

                <div class="form-floating col-4 mb-2">
                    <input type="text" id="marca" class="form-control" name="marca" placeholder="MSI" required>
                    <label for="marca" class="ms-3">Marca</label>
                </div>

                <div class="form-floating col-4 mb-2">
                    <input type="text" id="modelo" class="form-control" name="modelo" placeholder="MSI" required>
                    <label for="modelo" class="ms-3">Modelo</label>
                </div>

                <div class="form-floating col-6 mb-2">
                    <input type="text" id="precio" class="form-control" name="precio" placeholder="MSI" required>
                    <label for="precio" class="ms-3">Precio</label>
                </div>

                <div class="form-floating col-6 mb-2">
                    <input type="text" id="stock" class="form-control" name="stock" placeholder="MSI" required>
                    <label for="stock" class="ms-3">Stock</label>
                </div>

                <div class="form-floating mb-2">
                    <select class="form-select" id="categoria" name="categoria" placeholder="MSI" required>;
                        <?php
                    $categorias = $conn->CargarCategorias();
                    foreach ($categorias as $rowCategoria) {
                        echo '<option value="'.$rowCategoria['categoria'].'">'.$rowCategoria['categoria'].'</option>';
                    }?>
                    </select>
                    <label for="categoria" class="ms-3">Categoría</label>
                </div>

                <div class="form-outline mb-2">
                    <label for="imagen" class="form-label">Seleccionar una imagen</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value=30000>
                    <input class="form-control" type="file" id="imagen" name="imagen">
                </div>

                <div class="d-block text-end">
                        <button class="btn btn-success" type="submit">Agregar Producto</button>
                </div>

            </div>
        </form>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
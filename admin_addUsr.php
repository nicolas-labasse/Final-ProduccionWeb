<?php

if (isset($_POST['usuario'])) {

    // chequeos previos
    require_once 'includes/conector.php';
    $conn = new Conector();

    $nivel = $conn->CargarNivelConDescripcion($_POST['nivel']);

    $result = $conn->InsertarUsuario($_POST['usuario'], $_POST['passwd'], $_POST['nombre'], $_POST['apellido'], $_POST['email'], $nivel);

    if ($result) {
        header("Location: admin.php?tab=usuarios");
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
        <form action="admin_addUsr.php" method="POST" enctype="multipart/form-data">

            <div class="row">
                <div class="form-floating col-4 mb-2">
                    <input type="text" id="nombre" class="form-control" name="nombre" placeholder="MSI" required>
                    <label for="nombre" class="ms-3">Nombre</label>
                </div>

                <div class="form-floating col-4 mb-2">
                    <input type="text" id="apellido" class="form-control" name="apellido" placeholder="MSI" required>
                    <label for="apellido" class="ms-3">Apellido</label>
                </div>

                <div class="form-floating col-4 mb-2">
                    <input type="text" id="usuario" class="form-control" name="usuario" placeholder="MSI" required>
                    <label for="usuario" class="ms-3">Usuario</label>
                </div>

                <div class="form-floating col-4 mb-2">
                    <input type="password" id="passwd" class="form-control" name="passwd" placeholder="MSI" required>
                    <label for="passwd" class="ms-3">Contraseña</label>
                </div>

                <div class="form-floating col-4 mb-2">
                    <input type="password" id="passwdc" class="form-control" name="passwdc" placeholder="MSI" required>
                    <label for="passwdc" class="ms-3">Confirmar Contraseña</label>
                </div>

                <div class="form-floating col-6 mb-2">
                    <input type="email" id="email" class="form-control" name="email" placeholder="MSI" required>
                    <label for="email" class="ms-3">Email</label>
                </div>

                <div class="form-floating mb-2">
                    <select class="form-select" id="nivel" name="nivel" placeholder="MSI" required>;
                        <?php
                    $niveles = $conn->CargarNiveles();
                    foreach ($niveles as $rowNivel) {
                        echo '<option value="'.$rowNivel['descripcion'].'">'.$rowNivel['descripcion'].'</option>';
                    }?>
                    </select>
                    <label for="nivel" class="ms-3">Nivel de Usuario</label>
                </div>

                <div class="d-block text-end">
                        <button class="btn btn-success" type="submit">Agregar Usuario</button>
                </div>

            </div>
        </form>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
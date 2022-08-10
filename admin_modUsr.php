<?php

if (isset($_POST['uID'])) {

    // chequeos previos
    require_once 'includes/conector.php';
    $conn = new Conector();

    $nivel = $conn->CargarNivelConDescripcion($_POST['nivel']);

    var_dump($nivel);
    var_dump($_POST);

    $result = $conn->ModificarUsuario($_POST['uID'], $_POST['nombre'], $_POST['apellido'], $_POST['email'], $nivel);

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

    $usuario = ($conn->CargarUsuarioConID($_GET['userID']))->fetch_assoc();
    
    ?>

    <div style="height: 10vh">

    </div>

    <section class="mx-auto" style="max-width:60%">
        <form action="admin_modUsr.php" method="POST" enctype="multipart/form-data">

            <div class="row">
                <div class="form-floating col-4 mb-2">
                    <input type="text" id="nombre" class="form-control" name="nombre" placeholder="MSI" value="<?php echo $usuario['nombre']?>" required>
                    <label for="nombre" class="ms-3">Nombre</label>
                </div>

                <div class="form-floating col-4 mb-2">
                    <input type="text" id="apellido" class="form-control" name="apellido" placeholder="MSI" value="<?php echo $usuario['apellido']?>" required>
                    <label for="apellido" class="ms-3">Apellido</label>
                </div>

                <div class="form-floating col-4 mb-2">
                    <input type="text" id="usuario" class="form-control" name="usuario" placeholder="MSI" value="<?php echo $usuario['usuario']?>" disabled>
                    <label for="usuario" class="ms-3">Usuario</label>
                </div>

                <div class="form-floating col-6 mb-2">
                    <input type="email" id="email" class="form-control" name="email" placeholder="MSI" value="<?php echo $usuario['email']?>" required>
                    <label for="email" class="ms-3">Email</label>
                </div>

                <div class="form-floating mb-2">
                    <select class="form-select" id="nivel" name="nivel" placeholder="MSI" required>;
                        <?php
                    $niveles = $conn->CargarNiveles();
                    foreach ($niveles as $rowNivel) {
                        if ($rowNivel['descripcion'] == $usuario['descripcion'])
                            echo '<option value="'.$rowNivel['descripcion'].'" selected>'.$rowNivel['descripcion'].'</option>';
                        else
                            echo '<option value="'.$rowNivel['descripcion'].'">'.$rowNivel['descripcion'].'</option>';
                    }?>
                    </select>
                    <label for="nivel" class="ms-3">Nivel de Usuario</label>
                </div>

                <input type="hidden" name="uID" value="<?php echo $_GET['userID']?>">

                <div class="d-block text-end">
                        <button class="btn btn-success" type="submit">Modificar Usuario</button>
                </div>
            </div>
        </form>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
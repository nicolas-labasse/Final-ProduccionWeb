<?php
require_once 'includes/conector.php';

if (isset($_POST['updateThis'])) {
    if (strlen($_POST['nombre']) == 0 || strlen($_POST['apellido']) == 0 || strlen($_POST['email']) == 0) {
        $mensaje = "Falta completar alguno de los datos.";
    } else {
        session_start();

        $conn = new Conector();
        $result = $conn->ModificarUsuarioPerfil($_POST['nombre'],$_POST['apellido'],$_POST['email'], $_SESSION['userID']);

        $_SESSION['nombre'] = $_POST['nombre'];
        $_SESSION['apellido'] = $_POST['apellido'];
    }
}


?>

<!doctype html>
<html lang="es">

<?php require_once 'componentes/head.php'; 
?>

<body>
<?php require_once 'componentes/header.php'; ?>
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <h1 class="text-center h3 mt-5">Perfil Publico</h1>
                <p class="text-center">Añade información sobre ti</p>

                <?php
                if (isset($mensaje)) {
                    echo '<h3 class="text-center" style="color: red">';
                    echo $mensaje;
                    echo '</h3>';
                }
                
                
                ?>
                
                <form action="cuenta.php" method="POST">
                    <?Php
                    
                    require_once 'includes/conector.php';
                    $conn = new Conector();
            
                    $result = $conn->MostrarUsuarioID($_SESSION['userID']);
                    $row = $result->fetch_assoc();
                    echo'
                    <div class="row mb-4">
                                <div class="col">
                                    <div class="form-outline input-group-sm">
                                        <input type="text" name="nombre" class="form-control" value="'.$row['nombre'].'"  required/>
                                        <label class="form-label" for="nombre">Nombre</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-outline input-group-sm">
                                        <input type="text" name="apellido" class="form-control" value="'.$row['apellido'].'" required/>
                                        <label class="form-label" for="apellido">Apellido</label>
                                    </div>
                                </div>
                    </div>
                    <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline input-group-sm">
                                    <input type="email" name="email" class="form-control" value="'.$row['email'].'" required/>
                                    <label class="form-label" for="email">Email</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline input-group-sm">
                                    <input type="password" name="password" class="form-control" value="'.$row['passwd'].'" required/>
                                    <label class="form-label" for="user">Contraseña</label>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="updateThis" value=1>
                        
                        <div class="text-center">
                        <input type="submit" class="btn btn-dark" value="Actualizar" style="width: 80%;" tabindex="-1">
                        </div>

                    </form>';
                    ?>
            </div>
        </div>
    </section>
   




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>
<!doctype html>
<html lang="es">

<?php require_once 'componentes/head.php'; ?>

<?php
if (isset($_SESSION['isLogged']) && $_SESSION['isLogged'])
    header("Location: index.php");

if (isset($_POST['user'])) {

    $registroIncorrecto = array();
    $correcto = true;

    if (!ctype_alnum($_POST['user'])) {
        $correcto = false;
        array_push($registroIncorrecto, "El usuario contiene caracteres prohibidos.");
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $correcto = false;
        array_push($registroIncorrecto, "El email contiene caracteres prohibidos.");
    }

    if ($_POST['pass'] != $_POST['passConfirm']) {
        $correcto = false;
        array_push($registroIncorrecto, "La contraseña y su confirmación no coinciden.");
    }

    //meter más chequeos por acá

    if ($correcto) {
        require_once 'includes/conector.php';
        $conn = new Conector();

        $result = $conn->BuscarUsuario($_POST['user'], $_POST['email']);
        if ($result->num_rows == 0) {
            $result = $conn->InsertarUsuario($_POST['user'], $_POST['pass'], $_POST['nombre'], $_POST['apellido'], $_POST['email'], 0);
        } else {
            $correcto = false;
            array_push($registroIncorrecto, "El nombre de usuario o email ya se encuentra registrado.");
        }
    }    
}
?>

<body class="fondolog">
    <section class=" <?php echo $correcto? 'd-none' : 'd-block';?>">
        <div class="container"  style="height:100vh">
            <div class="row d-flex align-items-center justify-content-center" style="height: 100%;">
                <div class="col-8 mt-5 pb-5 pt-5 bg-login shadow-lg">
                    <a href="./index.php" class="fo d-flex">
                        <i class="fa-solid fa-arrow-left h2 ms-3 text-dark"></i>
                    </a>
                    <form action="registro.php" method="POST">
                    <div class="text-center mb-5">
                            <img src="./imagenes/logo.png" style="width: 150px; height:150px;" alt="">
                            <h1 class="my-2" style="font-family: 'Share Tech Mono', monospace;">RETABASSE</h1>
                            <?php
                            if (isset($registroIncorrecto) && count($registroIncorrecto) > 0)
                                foreach ($registroIncorrecto as $error) {
                                    echo "<li>{$error}</li>";
                                }
                            ?>
                        </div>

                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline input-group-sm">
                                    <input type="text" name="nombre" class="form-control"  required/>
                                    <label class="form-label" for="nombre">Nombre</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline input-group-sm">
                                    <input type="text" name="apellido" class="form-control"  required/>
                                    <label class="form-label" for="apellido">Apellido</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline input-group-sm">
                                    <input type="email" name="email" class="form-control"  required/>
                                    <label class="form-label" for="email">Email</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline input-group-sm">
                                    <input type="text" name="user" class="form-control"  required/>
                                    <label class="form-label" for="user">Usuario</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline input-group-sm">
                                    <input type="password" name="pass" class="form-control"  required/>
                                    <label class="form-label" for="pass">Contraseña</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline input-group-sm">
                                    <input type="password" name="passConfirm" class="form-control"  required/>
                                    <label class="form-label" for="passConfirm">Confirmar Contraseña</label>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                        <input type="submit" class="btn btn-dark" value="Registrarse" style="width: 80%;" tabindex="-1">
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </section>

    <section class=" <?php echo $correcto? 'd-block' : 'd-none';?>">
        <h1>Exito!!</h1>
        <?php 
            if ($correcto) 
                header( "Refresh:5; login.php", true, 303);
        ?>;

    </section>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>
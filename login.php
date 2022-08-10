<?php
session_start();
if (isset($_SESSION['isLogged']) && $_SESSION['isLogged'])
    header("Location: index.php");

if (isset($_POST['usuario'])) {

    require_once 'includes/conector.php';
    $conn = new Conector();

    $result = $conn->Login($_POST['usuario'], $_POST['passwd']);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (!password_verify($_POST['passwd'], $row['passwd'])) {
            $loginIncorrecto = "La combinación de usuario y contraseña son incorrectos.";
        } else {
            if (is_null($row['f_baja'])) {

                $_SESSION['usuario'] = $row['usuario'];
                $_SESSION['userID'] = $row['id'];
                $_SESSION['nombre'] = $row['nombre'];
                $_SESSION['apellido'] = $row['apellido'];
                $_SESSION['nivel'] = $row['nivel'];

                $_SESSION['isLogged'] = true;

                var_dump($_SESSION);

                    // funcionalidades de Recordar Usuario
                    /*
                    if(isset($_POST['recordar'])) {
                        $hour = time()+3600 *24 * 30;
                        setcookie('cookieUSUARIO', $row['id'], $hour);
                        setcookie('cookieID', $row['id'], $hour);
                        setcookie('cookieNOMBRE', $row['id'], $hour);
                        setcookie('cookieAPELLIDO', $row['id'], $hour);
                        setcookie('cookieNIVEL', $user_name, $hour);
                    }
                    */
                
                    header("Location: index.php");
                
            } else {            
                $loginIncorrecto = "El usuario fue dado de baja con fecha " . $row['f_baja'];
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php require_once 'componentes/head.php'; ?>

<body class="fondolog">
    <section>
        <div class="container" style="height:100vh">
            <div class="row d-flex align-items-center justify-content-center" style="height: 100%;">
                <div class="col-10 col-lg-4 pb-3 pt-4 bg-login shadow-lg">
                    <form action="login.php" method="POST">

                        <div class="text-center mb-5">
                            <img src="./imagenes/logo.png" style="width: 200px; height:200px;" alt="">
                            <h1 class="my-2" style="font-family: 'Share Tech Mono', monospace;">RETABASSE</h1>
                            <?php
                            if (isset($loginIncorrecto))
                                echo "<p>{$loginIncorrecto}</p>";
                            ?>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="text" name="usuario" class="form-control" required />
                            <label class="form-label" for="usuario">Usuario</label>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="password" name="passwd" class="form-control" required />
                            <label class="form-label" for="passwd">Contraseña</label>
                        </div>

                        <div class="row mb-4">
                            <div class="col d-flex justify-content-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" name="recordar" checked />
                                    <label class="form-check-label" for="recordar">Recuérdame</label>
                                </div>
                            </div>

                            <div class="col">
                                <a href="#!" class="btn btn-warning" class="pro">Olvidé mi contraseña</a>
                            </div>

                        </div>

                        <div class="text-center">
                            <input type="submit" class="btn btn-outline-dark" id="registrar" value="Ingresar" style="width: 80%;" tabindex="-1">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
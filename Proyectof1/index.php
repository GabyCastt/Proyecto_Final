<?php
// index.php

session_start();
require_once('config/conexion.php');
require_once('models/usuarios.model.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = new Clase_Usuarios();
    
    if (isset($_POST['login'])) {
        $correo_electronico = $_POST['correo_electronico'];
        $contrasena = $_POST['contrasena'];
        $resultado = $usuario->login($correo_electronico, $contrasena);
        
        if ($resultado) {
            $_SESSION['usuario'] = $resultado;
            header('Location: views/dashboard.php');
            exit();
        } else {
            header('Location: index.php?error=1');
            exit();
        }
    } elseif (isset($_POST['registrar'])) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $correo_electronico = $_POST['correo_electronico'];
        $contrasena = $_POST['contrasena'];
        $resultado = $usuario->registrar($nombre, $apellido, $correo_electronico, $contrasena);
        
        if ($resultado) {
            header('Location: index.php?registro=1');
            exit();
        } else {
            header('Location: index.php?error=2');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Login</h3>
                    </div>
                    <div class="card-body">
                        <form action="index.php" method="post">
                            <div class="form-group">
                                <label for="correo_electronico">Correo Electrónico</label>
                                <input type="email" name="correo_electronico" id="correo_electronico" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="contrasena">Contraseña</label>
                                <input type="password" name="contrasena" id="contrasena" class="form-control" required>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary btn-block">Entrar</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="views/registro.php">Registrarse</a>
                        </div>
                    </div>
                </div>
                <?php
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == 1) {
                        echo '<div class="alert alert-danger mt-3">Credenciales incorrectas.</div>';
                    } elseif ($_GET['error'] == 2) {
                        echo '<div class="alert alert-danger mt-3">Error al registrar usuario.</div>';
                    }
                }
                if (isset($_GET['registro']) && $_GET['registro'] == 1) {
                    echo '<div class="alert alert-success mt-3">Registro exitoso. Por favor, inicia sesión.</div>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>

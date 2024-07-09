<?php
session_start();
require_once('../models/usuario.model.php');

$usuario = new Clase_Usuarios();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $correo_electronico = $_POST['correo_electronico'];
        $contrasena = $_POST['contrasena'];
        $resultado = $usuario->login($correo_electronico, $contrasena);
        if ($resultado) {
            $_SESSION['usuario'] = $resultado;
            header('Location: ../views/dashboard.php');
        } else {
            header('Location: ../index.php?error=1');
        }
    } elseif (isset($_POST['registrar'])) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $correo_electronico = $_POST['correo_electronico'];
        $contrasena = $_POST['contrasena'];
        $resultado = $usuario->registrar($nombre, $apellido, $correo_electronico, $contrasena);
        if ($resultado) {
            header('Location: ../index.php?registro=1');
        } else {
            header('Location: ../index.php?error=2');
        }
    }
}
?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

header('Content-Type: application/json');

try {
    require_once '../models/usuario_registro.model.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (!$data) {
        throw new Exception('Datos inválidos');
    }

    $nombre = filter_var($data['nombre'], FILTER_SANITIZE_STRING);
    $apellido = filter_var($data['apellido'], FILTER_SANITIZE_STRING);
    $correo = filter_var($data['correo'], FILTER_SANITIZE_EMAIL);
    $contrasena = $data['contrasena'];

    if (empty($nombre) || empty($apellido) || empty($correo) || empty($contrasena)) {
        throw new Exception('Todos los campos son obligatorios');
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Correo electrónico inválido');
    }

    $usuarioModel = new UsuarioRegistroModel();

    if ($usuarioModel->correoExiste($correo)) {
        throw new Exception('El correo electrónico ya está registrado');
    }

    $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

    $resultado = $usuarioModel->registrarUsuario($nombre, $apellido, $correo, $contrasena);

    if ($resultado) {
        echo json_encode(['success' => true, 'message' => 'Usuario registrado con éxito']);
    } else {
        throw new Exception('Error al registrar el usuario');
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} catch (Error $e) {
    echo json_encode(['success' => false, 'message' => 'Error interno del servidor']);
}
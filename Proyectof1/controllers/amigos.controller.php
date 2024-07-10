<?php
// Muestra todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluye archivos necesarios
require_once('../config/cors.php');
require_once('../models/amigos.model.php');
require_once('../config/Clase_Conectar.php');

// Crea una instancia de la clase de amigos
$dbClass = new Clase_Conectar();
$conn = $dbClass->Procedimiento_Conectar();
$amigosModel = new AmigosModel($conn);

// Obtiene el método HTTP utilizado
$method = $_SERVER['REQUEST_METHOD'];

// Asegura que la respuesta sea siempre JSON
header('Content-Type: application/json');

// Función para enviar respuesta JSON
function enviarRespuesta($status, $message, $data = null) {
    echo json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

// Manejo de diferentes tipos de solicitudes HTTP
switch ($method) {
    case 'GET':
        if (isset($_GET['id_amigo'])) {
            $id_amigo = $_GET['id_amigo'];
            $amigo = $amigosModel->obtenerAmigoPorId($id_amigo);
            if ($amigo) {
                enviarRespuesta('success', 'Amigo encontrado', $amigo);
            } else {
                enviarRespuesta('error', 'Amigo no encontrado');
            }
        } else {
            $amigos = $amigosModel->listarAmigos();
            enviarRespuesta('success', 'Amigos encontrados', $amigos);
        }
        break;

    case 'POST':
        $datos = json_decode(file_get_contents('php://input'), true);
        $id_usuario1 = $datos['id_usuario1'] ?? '';
        $id_usuario2 = $datos['id_usuario2'] ?? '';
        $fecha_amistad = $datos['fecha_amistad'] ?? '';

        if (!empty($id_usuario1) && !empty($id_usuario2) && !empty($fecha_amistad)) {
            $insertar = $amigosModel->insertarAmigo($id_usuario1, $id_usuario2, $fecha_amistad);
            if ($insertar) {
                enviarRespuesta('success', 'Amigo insertado correctamente');
            } else {
                enviarRespuesta('error', 'Error al insertar el amigo');
            }
        } else {
            enviarRespuesta('error', 'Faltan datos para insertar el amigo');
        }
        break;

    case 'PUT':
        $datos = json_decode(file_get_contents('php://input'), true);
        $id_amigo = $datos['id_amigo'] ?? '';
        $id_usuario1 = $datos['id_usuario1'] ?? '';
        $id_usuario2 = $datos['id_usuario2'] ?? '';
        $fecha_amistad = $datos['fecha_amistad'] ?? '';

        if (!empty($id_amigo) && !empty($id_usuario1) && !empty($id_usuario2) && !empty($fecha_amistad)) {
            $actualizar = $amigosModel->actualizarAmigo($id_amigo, $id_usuario1, $id_usuario2, $fecha_amistad);
            if ($actualizar) {
                enviarRespuesta('success', 'Amigo actualizado correctamente');
            } else {
                enviarRespuesta('error', 'Error al actualizar el amigo');
            }
        } else {
            enviarRespuesta('error', 'Faltan datos para actualizar el amigo');
        }
        break;

    case 'DELETE':
        $datos = json_decode(file_get_contents('php://input'), true);
        $id_amigo = $datos['id_amigo'] ?? '';

        if (!empty($id_amigo)) {
            $eliminar = $amigosModel->eliminarAmigo($id_amigo);
            if ($eliminar) {
                enviarRespuesta('success', 'Amigo eliminado correctamente');
            } else {
                enviarRespuesta('error', 'Error al eliminar el amigo');
            }
        } else {
            enviarRespuesta('error', 'No se proporcionó el ID del amigo');
        }
        break;

    default:
        enviarRespuesta('error', 'Método HTTP no soportado');
        break;
}
?>
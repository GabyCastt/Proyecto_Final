<?php
// miembros_grupos.controller.php

// Muestra todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluye archivos necesarios
require_once('../config/cors.php');
require_once('../models/miembros_grupos.model.php');

// Crea una instancia de la clase de miembros_grupos
$miembro_grupo = new Clase_Miembros_Grupos();

// Obtiene el método HTTP utilizado
$metodo = $_SERVER['REQUEST_METHOD'];

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
switch ($metodo) {
    case "GET":
        if (isset($_GET["MiembroId"])) {
            $uno = $miembro_grupo->uno($_GET["MiembroId"]);
            $resultado = mysqli_fetch_assoc($uno);
            if ($resultado) {
                enviarRespuesta('success', 'Miembro del grupo encontrado', $resultado);
            } else {
                enviarRespuesta('error', 'Miembro del grupo no encontrado');
            }
        } else {
            $datos = $miembro_grupo->todos();
            $todos = array();
            while ($fila = mysqli_fetch_assoc($datos)) {
                $todos[] = $fila;
            }
            enviarRespuesta('success', 'Miembros del grupo encontrados', $todos);
        }
        break;

    case "POST":
        $datos = $_POST;
        $id_grupo = $datos["id_grupo"] ?? '';
        $id_usuario = $datos["id_usuario"] ?? '';
        $fecha_union = $datos["fecha_union"] ?? '';

        if (!empty($id_grupo) && !empty($id_usuario) && !empty($fecha_union)) {
            $insertar = $miembro_grupo->insertar($id_grupo, $id_usuario, $fecha_union);
            if ($insertar) {
                enviarRespuesta('success', 'Miembro del grupo insertado correctamente');
            } else {
                enviarRespuesta('error', 'Error al insertar el miembro del grupo');
            }
        } else {
            enviarRespuesta('error', 'Faltan datos para insertar el miembro del grupo');
        }
        break;

    case "PUT":
        $datos = json_decode(file_get_contents('php://input'), true);
        $id_miembro = $datos["id_miembro"] ?? '';
        $id_grupo = $datos["id_grupo"] ?? '';
        $id_usuario = $datos["id_usuario"] ?? '';
        $fecha_union = $datos["fecha_union"] ?? '';

        if (!empty($id_miembro) && !empty($id_grupo) && !empty($id_usuario) && !empty($fecha_union)) {
            $actualizar = $miembro_grupo->actualizar($id_miembro, $id_grupo, $id_usuario, $fecha_union);
            if ($actualizar) {
                enviarRespuesta('success', 'Miembro del grupo actualizado correctamente');
            } else {
                enviarRespuesta('error', 'Error al actualizar el miembro del grupo');
            }
        } else {
            enviarRespuesta('error', 'Faltan datos para actualizar el miembro del grupo');
        }
        break;

    case "DELETE":
        $datos = json_decode(file_get_contents('php://input'), true);
        $id_miembro = $datos["id_miembro"] ?? '';

        if (!empty($id_miembro)) {
            $eliminar = $miembro_grupo->eliminar($id_miembro);
            if ($eliminar) {
                enviarRespuesta('success', 'Miembro del grupo eliminado correctamente');
            } else {
                enviarRespuesta('error', 'Error al eliminar el miembro del grupo');
            }
        } else {
            enviarRespuesta('error', 'No se proporcionó el ID del miembro del grupo');
        }
        break;

    default:
        enviarRespuesta('error', 'Método HTTP no soportado');
        break;
}
?>

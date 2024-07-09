<?php
// grupos.controller.php

// Muestra todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluye archivos necesarios
require_once('../config/cors.php');
require_once('../models/grupos.model.php');

// Crea una instancia de la clase de grupos
$grupo = new Clase_Grupos();

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
        if (isset($_GET["GrupoId"])) {
            $uno = $grupo->uno($_GET["GrupoId"]);
            $resultado = mysqli_fetch_assoc($uno);
            if ($resultado) {
                enviarRespuesta('success', 'Grupo encontrado', $resultado);
            } else {
                enviarRespuesta('error', 'Grupo no encontrado');
            }
        } else {
            $datos = $grupo->todos();
            $todos = array();
            while ($fila = mysqli_fetch_assoc($datos)) {
                $todos[] = $fila;
            }
            enviarRespuesta('success', 'Grupos encontrados', $todos);
        }
        break;

    case "POST":
        $datos = $_POST;
        $nombre_grupo = $datos["nombre_grupo"] ?? '';
        $descripcion = $datos["descripcion"] ?? '';

        if (!empty($nombre_grupo) && !empty($descripcion)) {
            $insertar = $grupo->insertar($nombre_grupo, $descripcion);
            if ($insertar) {
                enviarRespuesta('success', 'Grupo insertado correctamente');
            } else {
                enviarRespuesta('error', 'Error al insertar el grupo');
            }
        } else {
            enviarRespuesta('error', 'Faltan datos para insertar el grupo');
        }
        break;

    case "PUT":
        $datos = json_decode(file_get_contents('php://input'), true);
        $id_grupo = $datos["id_grupo"] ?? '';
        $nombre_grupo = $datos["nombre_grupo"] ?? '';
        $descripcion = $datos["descripcion"] ?? '';

        if (!empty($id_grupo) && !empty($nombre_grupo) && !empty($descripcion)) {
            $actualizar = $grupo->actualizar($id_grupo, $nombre_grupo, $descripcion);
            if ($actualizar) {
                enviarRespuesta('success', 'Grupo actualizado correctamente');
            } else {
                enviarRespuesta('error', 'Error al actualizar el grupo');
            }
        } else {
            enviarRespuesta('error', 'Faltan datos para actualizar el grupo');
        }
        break;

    case "DELETE":
        $datos = json_decode(file_get_contents('php://input'), true);
        $id_grupo = $datos["id_grupo"] ?? '';

        if (!empty($id_grupo)) {
            $eliminar = $grupo->eliminar($id_grupo);
            if ($eliminar) {
                enviarRespuesta('success', 'Grupo eliminado correctamente');
            } else {
                enviarRespuesta('error', 'Error al eliminar el grupo');
            }
        } else {
            enviarRespuesta('error', 'No se proporcionó el ID del grupo');
        }
        break;

    default:
        enviarRespuesta('error', 'Método HTTP no soportado');
        break;
}
?>

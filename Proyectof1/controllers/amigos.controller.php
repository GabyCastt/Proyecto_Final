<?php
// Iniciamos la sesión solo si no hay una activa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../models/amigos.model.php');

class Amigos_Controller {
    private $modelo;

    public function __construct() {
        $this->modelo = new Amigos_Model();
    }

    public function listarAmigos($id_usuario) {
        return $this->modelo->listarAmigos($id_usuario);
    }

    public function buscarUsuarios($busqueda, $id_usuario) {
        return $this->modelo->buscarUsuarios($busqueda, $id_usuario);
    }

    public function agregarAmigo($id_usuario1, $id_usuario2) {
        return $this->modelo->agregarAmigo($id_usuario1, $id_usuario2);
    }

    public function eliminarAmigo($id_usuario1, $id_usuario2) {
        return $this->modelo->eliminarAmigo($id_usuario1, $id_usuario2);
    }
}

// Manejo de solicitudes AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new Amigos_Controller();
    
    if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['id_usuario'])) {
        echo json_encode(['error' => 'Usuario no autenticado']);
        exit;
    }
    
    $id_usuario = $_SESSION['usuario']['id_usuario'];

    switch ($_POST['accion']) {
        case 'buscar':
            $resultados = $controller->buscarUsuarios($_POST['busqueda'], $id_usuario);
            $html = '';
            foreach ($resultados as $usuario) {
                $html .= '<div class="usuario-resultado">';
                $html .= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']);
                $html .= ' <button class="btn btn-primary btn-sm agregarAmigo" data-id="' . $usuario['id_usuario'] . '">Agregar</button>';
                $html .= '</div>';
            }
            echo $html;
            break;

        case 'agregar':
            $resultado = $controller->agregarAmigo($id_usuario, $_POST['id_usuario2']);
            echo $resultado ? 'success' : 'error';
            break;

        case 'eliminar':
            $resultado = $controller->eliminarAmigo($id_usuario, $_POST['id_usuario2']);
            echo $resultado ? 'success' : 'error';
            break;

        default:
            echo json_encode(['error' => 'Acción no reconocida']);
            break;
    }
    exit;
}
<<<<<<< HEAD
=======

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
>>>>>>> 664187bf97d30703b75fab594a26ade245ea9466
?>
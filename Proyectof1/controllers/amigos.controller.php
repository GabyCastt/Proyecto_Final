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
?>
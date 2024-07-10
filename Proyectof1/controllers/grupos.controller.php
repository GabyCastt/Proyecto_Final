<?php
// Iniciamos la sesión solo si no hay una activa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../models/grupos.model.php');

class Grupos_Controller {
    private $modelo;

    public function __construct() {
        $this->modelo = new Grupos_Model();
    }

    public function listarGrupos() {
        return $this->modelo->Listar_Grupos();
    }

    public function insertarGrupo($nombre_grupo, $descripcion) {
        return $this->modelo->Insertar_Grupo($nombre_grupo, $descripcion);
    }

    public function editarGrupo($id_grupo, $nombre_grupo, $descripcion) {
        return $this->modelo->Editar_Grupo($id_grupo, $nombre_grupo, $descripcion);
    }

    public function eliminarGrupo($id_grupo) {
        return $this->modelo->Eliminar_Grupo($id_grupo);
    }
}

// Manejo de solicitudes AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new Grupos_Controller();
    
    if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['id_usuario'])) {
        echo json_encode(['error' => 'Usuario no autenticado']);
        exit;
    }
    
    $id_usuario = $_SESSION['usuario']['id_usuario'];

    switch ($_POST['accion']) {
        case 'listar':
            $grupos = $controller->listarGrupos();
            echo json_encode($grupos);
            break;

        case 'insertar':
            $nombre_grupo = $_POST['nombre_grupo'];
            $descripcion = $_POST['descripcion'];
            $resultado = $controller->insertarGrupo($nombre_grupo, $descripcion);
            echo $resultado ? 'success' : 'error';
            break;

        case 'editar':
            $id_grupo = $_POST['id_grupo'];
            $nombre_grupo = $_POST['nombre_grupo'];
            $descripcion = $_POST['descripcion'];
            $resultado = $controller->editarGrupo($id_grupo, $nombre_grupo, $descripcion);
            echo $resultado ? 'success' : 'error';
            break;

        case 'eliminar':
            $id_grupo = $_POST['id_grupo'];
            $resultado = $controller->eliminarGrupo($id_grupo);
            echo $resultado ? 'success' : 'error';
            break;

        default:
            echo json_encode(['error' => 'Acción no reconocida']);
            break;
    }
    exit;
}
?>

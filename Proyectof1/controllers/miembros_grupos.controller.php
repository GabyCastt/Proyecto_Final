<?php
// Iniciamos la sesión solo si no hay una activa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../models/miembros.model.php');

class Miembros_Controller {
    private $modelo;

    public function __construct() {
        $this->modelo = new Miembros_Model();
    }

    public function listarMiembros($id_usuario1) {
        return $this->modelo->listarMiembros($id_usuario1);
    }

    // Puedes agregar más métodos aquí según las operaciones necesarias

}

// Manejo de solicitudes AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new Miembros_Controller();
    
    if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['id_usuario'])) {
        echo json_encode(['error' => 'Usuario no autenticado']);
        exit;
    }
    
    $id_usuario = $_SESSION['usuario']['id_usuario'];

    switch ($_POST['accion']) {
        case 'listarMiembros':
            $id_usuario1 = $_POST['id_usuario1'];
            $miembros = $controller->listarMiembros($id_usuario1);
            echo json_encode($miembros);
            break;

        // Puedes agregar más casos según las operaciones que necesites realizar

        default:
            echo json_encode(['error' => 'Acción no reconocida']);
            break;
    }
    exit;
}
?>

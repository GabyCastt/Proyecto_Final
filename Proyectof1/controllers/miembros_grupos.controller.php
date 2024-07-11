<?php
header('Content-Type: application/json');

require_once("../models/miembros_grupos.model.php");

class GruposMiembrosController {
    private $modelo;

    public function __construct() {
        $this->modelo = new GruposMiembrosModel();
    }

    // ... (resto de los métodos)

    public function crearGrupo($nombre, $descripcion) {
        try {
            $resultado = $this->modelo->crearGrupo($nombre, $descripcion);
            return ['success' => $resultado, 'message' => $resultado ? 'Grupo creado con éxito' : 'Error al crear el grupo'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    // Modifica los demás métodos de manera similar
}

// Manejo de solicitudes AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new GruposMiembrosController();
    $accion = $_POST['accion'] ?? '';

    $response = ['success' => false, 'message' => 'Acción no válida'];

    switch ($accion) {
        case 'crearGrupo':
            $response = $controller->crearGrupo($_POST['nombre'] ?? '', $_POST['descripcion'] ?? '');
            break;
        // ... (otros casos)
        default:
            $response = ['success' => false, 'message' => 'Acción no reconocida'];
    }

    echo json_encode($response);
} else {
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no válido']);
}
?>
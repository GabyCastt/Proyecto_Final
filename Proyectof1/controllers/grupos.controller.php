<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Something went wrong'];
require_once('../models/grupos.model.php');

class GruposController
{
    public function listarGrupos()
    {
        try {
            $gruposModel = new Clase_Grupos();
            $grupos = $gruposModel->todos();
            $data = [];

            while ($grupo = mysqli_fetch_assoc($grupos)) {
                $data[] = $grupo;
            }

            echo json_encode(['status' => 'success', 'data' => $data]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function obtenerGrupo($id_grupo)
    {
        try {
            $gruposModel = new Clase_Grupos();
            $grupo = $gruposModel->uno($id_grupo);
            $data = mysqli_fetch_assoc($grupo);

            echo json_encode(['status' => 'success', 'data' => $data]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function crearGrupo($nombre_grupo, $descripcion)
    {
        try {
            $gruposModel = new Clase_Grupos();
            $resultado = $gruposModel->insertar($nombre_grupo, $descripcion);

            if ($resultado) {
                echo json_encode(['status' => 'success', 'message' => 'Grupo creado correctamente']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function actualizarGrupo($id_grupo, $nombre_grupo, $descripcion)
    {
        try {
            $gruposModel = new Clase_Grupos();
            $resultado = $gruposModel->actualizar($id_grupo, $nombre_grupo, $descripcion);

            if ($resultado) {
                echo json_encode(['status' => 'success', 'message' => 'Grupo actualizado correctamente']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function eliminarGrupo($id_grupo)
    {
        try {
            $gruposModel = new Clase_Grupos();
            $resultado = $gruposModel->eliminar($id_grupo);

            if ($resultado) {
                echo json_encode(['status' => 'success', 'message' => 'Grupo eliminado correctamente']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function listarMiembros($id_grupo)
    {
        try {
            $gruposModel = new Clase_Grupos();
            $miembros = $gruposModel->miembros($id_grupo);
            $data = [];

            while ($miembro = mysqli_fetch_assoc($miembros)) {
                $data[] = $miembro;
            }

            echo json_encode(['status' => 'success', 'data' => $data]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}

// Manejo de las solicitudes HTTP
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller = new GruposController();

    switch ($_POST['action']) {
        case 'listarGrupos':
            $controller->listarGrupos();
            break;
        case 'obtenerGrupo':
            $controller->obtenerGrupo($_POST['id_grupo']);
            break;
        case 'crearGrupo':
            $controller->crearGrupo($_POST['nombre_grupo'], $_POST['descripcion']);
            break;
        case 'actualizarGrupo':
            $controller->actualizarGrupo($_POST['id_grupo'], $_POST['nombre_grupo'], $_POST['descripcion']);
            break;
        case 'eliminarGrupo':
            $controller->eliminarGrupo($_POST['id_grupo']);
            break;
        case 'listarMiembros':
            $controller->listarMiembros($_POST['id_grupo']);
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
            break;
    }
}
?>

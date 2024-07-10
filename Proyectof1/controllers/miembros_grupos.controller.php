<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
$response = ['status' => 'error', 'message' => 'Something went wrong'];
require_once('../models/miembros_grupos.model.php');

class MiembrosGrupoController
{
    public function listarMiembros()
    {
        try {
            $miembrosModel = new Clase_Miembros_Grupo();
            $miembros = $miembrosModel->todos();
            $data = [];

            while ($miembro = mysqli_fetch_assoc($miembros)) {
                $data[] = $miembro;
            }

            echo json_encode(['status' => 'success', 'data' => $data]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function obtenerMiembro($id_miembro)
    {
        try {
            $miembrosModel = new Clase_Miembros_Grupo();
            $miembro = $miembrosModel->uno($id_miembro);
            $data = mysqli_fetch_assoc($miembro);

            echo json_encode(['status' => 'success', 'data' => $data]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function agregarMiembro($id_grupo, $id_usuario, $fecha_union)
    {
        try {
            $miembrosModel = new Clase_Miembros_Grupo();
            $resultado = $miembrosModel->insertar($id_grupo, $id_usuario, $fecha_union);

            if ($resultado) {
                echo json_encode(['status' => 'success', 'message' => 'Miembro agregado correctamente']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function eliminarMiembro($id_miembro)
    {
        try {
            $miembrosModel = new Clase_Miembros_Grupo();
            $resultado = $miembrosModel->eliminar($id_miembro);

            if ($resultado) {
                echo json_encode(['status' => 'success', 'message' => 'Miembro eliminado correctamente']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function obtenerGrupos()
    {
        try {
            $miembrosModel = new Clase_Miembros_Grupo();
            $grupos = $miembrosModel->obtenerGrupos();

            return ['status' => 'success', 'data' => $grupos];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    public function obtenerUsuarios()
    {
        try {
            $miembrosModel = new Clase_Miembros_Grupo();
            $usuarios = $miembrosModel->obtenerUsuarios();

            echo json_encode(['status' => 'success', 'data' => $usuarios]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}

// Manejo de las solicitudes HTTP
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller = new MiembrosGrupoController();

    switch ($_POST['action']) {
        case 'listarMiembros':
            $controller->listarMiembros();
            break;
        case 'obtenerMiembro':
            $controller->obtenerMiembro($_POST['id_miembro']);
            break;
        case 'agregarMiembro':
            $controller->agregarMiembro($_POST['id_grupo'], $_POST['id_usuario'], $_POST['fecha_union']);
            break;
        case 'eliminarMiembro':
            $controller->eliminarMiembro($_POST['id_miembro']);
            break;
        case 'obtenerGrupos':
            $controller->obtenerGrupos();
            break;
        case 'obtenerUsuarios':
            $controller->obtenerUsuarios();
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
            break;
    }
}

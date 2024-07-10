<?php
session_start();
require_once('../models/comentario.model.php');
require_once('../models/clase_conectar.php');

// Crear una instancia de la conexión
$conexion = new Clase_Conectar();
$dbConnection = $conexion->Procedimiento_Conectar();

// Crear una instancia del modelo de comentarios
$comentarioModel = new ComentarioModel($dbConnection);

<<<<<<< HEAD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['crearComentario'])) {
        $id_publicacion = $_POST['id_publicacion'];
        $id_usuario = $_SESSION['usuario']['id']; // Asumiendo que el id del usuario está en la sesión
        $contenido = $_POST['contenido'];
        $resultado = $comentarioModel->crearComentario($id_publicacion, $id_usuario, $contenido);
        if ($resultado) {
            header('Location: ../views/publicacion.php?id=' . $id_publicacion);
        } else {
            header('Location: ../views/publicacion.php?id=' . $id_publicacion . '&error=1');
        }
    } elseif (isset($_POST['editarComentario'])) {
        $id_comentario = $_POST['id_comentario'];
        $contenido = $_POST['contenido'];
        $comentarioModel->editarComentario($id_comentario, $contenido);
        header('Location: ../views/publicacion.php?id=' . $_POST['id_publicacion']);
    } elseif (isset($_POST['eliminarComentario'])) {
        $id_comentario = $_POST['id_comentario'];
        $comentarioModel->eliminarComentario($id_comentario);
        header('Location: ../views/publicacion.php?id=' . $_POST['id_publicacion']);
=======
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

            echo json_encode(['status' => 'success', 'data' => $grupos]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
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
>>>>>>> d2052c9bca80827b0c018fe9645816df9788e847
    }
}

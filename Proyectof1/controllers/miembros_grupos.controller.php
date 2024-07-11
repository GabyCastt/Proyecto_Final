<?php
require_once('../config/conexion.php');
require_once('../models/miembros_grupos.model.php');
<<<<<<< HEAD

session_start();
$id_usuario = $_SESSION['id_usuario']; // Suponiendo que el ID del usuario logueado se guarda en la sesión
=======
>>>>>>> a34e76c2ca199f4cb95f571fa943e70e69029000

// Crear instancia de la clase de conexión
$conectar = new Clase_Conectar();
$conexion = $conectar->Procedimiento_Conectar();

$grupo = new Clase_Miembros_Grupo($conexion);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener todos los grupos
    if (isset($_GET['accion']) && $_GET['accion'] === 'obtenerGrupos') {
        $resultado = $grupo->obtenerGrupos();
        $grupos = array();
        while ($row = $resultado->fetch_assoc()) {
            $grupos[] = $row;
        }
        echo json_encode($grupos);
    }

    // Obtener miembros de un grupo
    elseif (isset($_GET['accion']) && $_GET['accion'] === 'obtenerMiembrosGrupo' && isset($_GET['id_grupo'])) {
        $id_grupo = $_GET['id_grupo'];
        $resultado = $grupo->obtenerMiembrosGrupo($id_grupo);
        $miembros = array();
        while ($row = $resultado->fetch_assoc()) {
            $miembros[] = $row;
        }
        echo json_encode($miembros);
    }
<<<<<<< HEAD

    // Obtener amigos del usuario logueado
    elseif (isset($_GET['accion']) && $_GET['accion'] === 'obtenerAmigos') {
        $resultado = $grupo->obtenerAmigos($id_usuario);
        $amigos = array();
        while ($row = $resultado->fetch_assoc()) {
            $amigos[] = $row;
        }
        echo json_encode($amigos);
    }
}

elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
=======
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
>>>>>>> a34e76c2ca199f4cb95f571fa943e70e69029000
    // Agregar miembro a un grupo
    if (isset($_POST['accion']) && $_POST['accion'] === 'agregarMiembroGrupo') {
        $id_grupo = $_POST['id_grupo'];
        $id_usuario_amigo = $_POST['id_usuario'];
        if ($grupo->agregarMiembroGrupo($id_grupo, $id_usuario_amigo)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false));
        }
    }

    // Eliminar miembro de un grupo
    elseif (isset($_POST['accion']) && $_POST['accion'] === 'eliminarMiembroGrupo') {
        $id_miembro = $_POST['id_miembro'];
        if ($grupo->eliminarMiembroGrupo($id_miembro)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false));
        }
    }
}

<?php
// controllers/miembros_grupos.controller.php

// Incluir la configuración de la conexión a la base de datos
require_once('../config/conexion.php'); // Asegúrate de que la ruta sea correcta según la estructura de tus archivos
require_once('../models/miembros_grupos.model.php');

session_start();

// Crear instancia de la clase de conexión
$conectar = new Clase_Conectar();
$conexion = $conectar->Procedimiento_Conectar();

// Crear una instancia del modelo MiembrosGrupo, pasando la conexión como parámetro
$miembrosGrupo = new MiembrosGrupo($conexion);

// Manejo de las peticiones GET y POST
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['accion'])) {
        switch ($_GET['accion']) {
            case 'obtenerGrupos':
                $resultado = $grupo->obtenerGrupos();
                $grupos = array();
                while ($row = $resultado->fetch_assoc()) {
                    $grupos[] = $row;
                }
                echo json_encode($grupos);
                break;

            case 'obtenerMiembrosGrupo':
                if (isset($_GET['id_grupo'])) {
                    $id_grupo = $_GET['id_grupo'];
                    $resultado = $grupo->obtenerMiembrosGrupo($id_grupo);
                    $miembros = array();
                    while ($row = $resultado->fetch_assoc()) {
                        $miembros[] = $row;
                    }
                    echo json_encode($miembros);
                }
                break;

            case 'obtenerAmigos':
                if (isset($_SESSION['usuario']['id_usuario'])) {
                    $id_usuario = $_SESSION['usuario']['id_usuario'];
                    $resultado = $grupo->obtenerAmigosUsuario($id_usuario);
                    $amigos = array();
                    while ($row = $resultado->fetch_assoc()) {
                        $amigos[] = $row;
                    }
                    echo json_encode($amigos);
                }
                break;
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        switch ($_POST['accion']) {
            case 'agregarMiembroGrupo':
                $id_grupo = $_POST['id_grupo'];
                $id_usuario = $_POST['id_usuario'];
                if ($grupo->agregarMiembroGrupo($id_grupo, $id_usuario)) {
                    echo json_encode(array("success" => true));
                } else {
                    echo json_encode(array("success" => false));
                }
                break;

            case 'eliminarMiembroGrupo':
                $id_miembro = $_POST['id_miembro'];
                if ($grupo->eliminarMiembroGrupo($id_miembro)) {
                    echo json_encode(array("success" => true));
                } else {
                    echo json_encode(array("success" => false));
                }
                break;
        }
    }
}
?>
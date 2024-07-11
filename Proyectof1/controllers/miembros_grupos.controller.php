<?php
// controllers/miembros_grupos.controller.php

// Incluir la configuración de la conexión a la base de datos
require_once('../config/conexion.php'); // Asegúrate de que la ruta sea correcta según la estructura de tus archivos
require_once('../models/miembros_grupos.model.php');

// Crear una instancia de la clase para la conexión a la base de datos
$clase_conectar = new Clase_Conectar();
$conexion = $clase_conectar->Procedimiento_Conectar();

// Crear una instancia del modelo MiembrosGrupo, pasando la conexión como parámetro
$miembrosGrupo = new MiembrosGrupo($conexion);

// Manejo de las peticiones GET y POST
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['accion'] === 'obtenerMiembrosGrupo') {
        // Verificar y obtener el ID del grupo desde los parámetros GET
        $idGrupo = isset($_GET['id_grupo']) ? $_GET['id_grupo'] : die();

        // Llamar al método del modelo para obtener los miembros del grupo
        $resultados = $miembrosGrupo->obtenerMiembrosGrupo($idGrupo);

        // Convertir a formato JSON y devolver como respuesta
        echo json_encode($resultados);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Manejar la acción para agregar o eliminar miembros del grupo
    if ($_POST['accion'] === 'agregarMiembroGrupo') {
        // Verificar y obtener los IDs del grupo y del usuario desde los parámetros POST
        $idGrupo = isset($_POST['id_grupo']) ? $_POST['id_grupo'] : die();
        $idUsuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : die();

        // Llamar al método del modelo para agregar un miembro al grupo
        $resultado = $miembrosGrupo->agregarMiembroGrupo($idGrupo, $idUsuario);

        // Preparar la respuesta JSON con un indicador de éxito o fallo
        echo json_encode(array('success' => $resultado));
    } elseif ($_POST['accion'] === 'eliminarMiembroGrupo') {
        // Verificar y obtener el ID del miembro desde los parámetros POST
        $idMiembro = isset($_POST['id_miembro']) ? $_POST['id_miembro'] : die();

        // Llamar al método del modelo para eliminar un miembro del grupo
        $resultado = $miembrosGrupo->eliminarMiembroGrupo($idMiembro);

        // Preparar la respuesta JSON con un indicador de éxito o fallo
        echo json_encode(array('success' => $resultado));
    }
}
?>

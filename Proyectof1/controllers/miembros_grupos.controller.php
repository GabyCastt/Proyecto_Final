<?php
session_start();
require_once('../models/comentario.model.php');
require_once('../models/clase_conectar.php');

// Crear una instancia de la conexión
$conexion = new Clase_Conectar();
$dbConnection = $conexion->Procedimiento_Conectar();

// Crear una instancia del modelo de comentarios
$comentarioModel = new ComentarioModel($dbConnection);

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
    }
}
?>

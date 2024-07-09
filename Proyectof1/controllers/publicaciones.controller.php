<?php
require_once '../models/publicaciones.model.php';

class PublicacionesController {
    private $model;

    public function __construct($conexion) {
        $this->model = new PublicacionesModel($conexion);
    }

    public function crearPublicacion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
            $idUsuario = 1; // Asume un ID de usuario fijo, deberías obtenerlo de la sesión
            $titulo = $_POST['titulo'];
            $contenido = $_POST['contenido'];

            if ($this->model->crearPublicacion($idUsuario, $titulo, $contenido)) {
                header('Location: publicaciones.php');
                exit;
            } else {
                echo "Error al crear la publicación.";
            }
        }
    }

    public function obtenerPublicacion() {
        if (isset($_GET['id_publicacion'])) {
            return $this->model->obtenerPublicacion($_GET['id_publicacion']);
        }
        return null;
    }

    public function editarPublicacion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
            $idPublicacion = $_POST['id_publicacion'];
            $titulo = $_POST['titulo'];
            $contenido = $_POST['contenido'];

            if ($this->model->editarPublicacion($idPublicacion, $titulo, $contenido)) {
                header('Location: publicaciones.php');
                exit;
            } else {
                echo "Error al editar la publicación.";
            }
        }
    }

    public function eliminarPublicacion() {
        if (isset($_GET['eliminar']) && isset($_GET['id_publicacion'])) {
            $idPublicacion = $_GET['id_publicacion'];
            if ($this->model->eliminarPublicacion($idPublicacion)) {
                header('Location: publicaciones.php');
                exit;
            } else {
                echo "Error al eliminar la publicación.";
            }
        }
    }

    public function listarPublicaciones() {
        try {
            return $this->model->listarPublicaciones();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}
?>